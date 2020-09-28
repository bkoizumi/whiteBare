<?php

namespace App\Http\Controllers;

use App\Models\EventModels;
use App\Models\KeywordsModels;
use App\Models\LineAPI;
use App\Models\MessagesModels;
use App\Models\TargetsModels;
use App\Models\UsersModels;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;

class WebhookController extends Controller
{

    protected $LineAPI;

    public function __construct() {
        $this->mdlTarget = new targetsModels ();
        $this->mdlUsers = new UsersModels ();
        $this->mdlMessages = new MessagesModels ();
        $this->mdlEvent = new EventModels ();
        $this->mdlKeywords = new KeywordsModels ();
        $this->LineAPI = new LineAPI ();
    }


    /**
     * webhook function
     */
    public function webhook(Request $request) {
        http_response_code( 200 ) ;
        $signature = $request->header ( 'X-Line-Signature' );
        $httpClient = new CurlHTTPClient (env('LINE_CHANNEL_TOKEN'));
        $bot = new LINEBot ( $httpClient, ['channelSecret' => env('LINE_CHANNEL_SECRET') ] );

//         Log::debug($request);
        if ($request->getContent () != '') {
            $events = $this->LineAPI->parseEventRequest ( $request->getContent (), $signature );
            foreach ($events as $event) {
                switch ($event->getType ()) {
                    case 'follow' :
                        self::insert ( $event, $bot );
                        break;
                    case 'unfollow' :
                        self::delete ( $event );
                        break;
                    case 'message' :
                        switch ($event->getMessageType ()) {
                            case 'text' :
                                $this->replyTextMeg ( $event, $bot );
                                break;
                            case 'image' :
                                $this->replyImage ( $event, $bot );
                                break;
                            case 'sticker' :
                                // スタンプ受信
                                break;

                            case 'location' :
                                // 位置情報受信
                                break;
                        }

                        break;
                    case 'postback' :
                        self::postBack ( $event, $bot );

                        break;
                    default :
                        break;
                }
            }
        }
    }


    /**
     * 新規友達登録
     */
    protected function insert($event, $bot) {
        $Profile = array (
                'displayName' => '',
                'pictureUrl' => '',
                'statusMessage' => '',
                'remoteAddr' => ''
        );

        if ($event->getType () == 'follow') {
            $relation_state = 0;
        } else {
            $relation_state = 1;
        }

        $this->mdlUsers->deleteOne ( 'line', $event->getUserId () );

        // LID生成
        $hashId = md5 ( $event->getUserId () . env ( 'APP_HASH_KEY' ) );
        $countLid = $this->mdlUsers->countLid ( 'line', $hashId ) + 1;
        $lid = 'L' . $countLid . $hashId;

        // プロフィール情報取得
        if (env ( 'GET_LINE_USER_INFO' )) {
            $Profile = $this->LineAPI->getProfile ( $event->getUserId () );
            if (isset ( $_SERVER ['REMOTE_ADDR'] )) {
                $Profile ['remoteAddr'] = $_SERVER ['REMOTE_ADDR'];
            }
            if (isset ( $_SERVER ['HTTP_USER_AGENT'] )) {
                $Profile ['user_agent'] = $_SERVER ['HTTP_USER_AGENT'];
            }
            if (! isset($Profile ['pictureUrl']) ){
                $Profile ['pictureUrl'] = '';
            }
            if (! isset($Profile ['statusMessage']) ){
                $Profile ['statusMessage'] = '';
            }
        }
        $newFriend = array (
                'app_type' => 'line',
                'uid' => $event->getUserId (),
                'lid' => $lid,
                'relation_state' => $relation_state,
                'nick_name' => $Profile ['displayName'],
                'thumbnail_url' => $Profile ['pictureUrl'],
               'status_message' => $Profile['statusMessage'],
                'address01' => $Profile ['remoteAddr'],
                'user_agent' => $Profile ['user_agent']
        );
         Log::debug ($newFriend);
        $this->mdlUsers->insertOne ( 'line', $newFriend );

        if ($Profile ['displayName']) {
            $welcomeMessage = $Profile ['displayName'] . 'さん。友だち登録ありがとうございます。';
        } else {
            $welcomeMessage = '友だち登録ありがとうございます。';
        }

        $this->LineAPI->sendTextMessage ( $welcomeMessage );
        $this->LineAPI->replyMessage ( $event->getReplyToken (), $this->LineAPI->message );
    }


    /**
     * ブロック処理
     */
    protected function delete($event) {
        if (env ( 'DELETE_LINE_BLOCKUSER_INFO' )) {
            // ブロックユーザーの削除
            $this->mdlUsers->deleteOne ( 'line', $event->getUserId () );
        } else {
            // ブロックユーザーの論理削除
            $arrayData = array (
                    'relation_state' => '1',
                    'block_at' => Carbon::now ()
            );
            $this->mdlUsers->updateOne ( 'line', $event->getUserId (), $arrayData );
        }
    }


    /**
     * リプライ(自動返信) テキスト
     */
    protected function replyTextMeg($event, $bot) {
        $ret =$result = '';
        $ret = $this->mdlKeywords->getAutoReplies ( 'line', $event->getText () );

//         Log::debug ( "受信メッセージ：" . $event->getText () );

        // メッセージの保存
        $this->saveMessages ( $this->mdlUsers->getUserID2Lid ( 'line', $event->getUserId () ), $event->getMessageType (), $event->getMessageId (), $event->getText (), "receive");

        if (isset($ret)) {

            $result = $this->mdlKeywords->getDetail (  $ret->id );

            switch ($result->type) {
                case 'text' : // テキストメッセージ
                    $this->LineAPI->sendTextMessage ( $result->text );
                    break;

                case 'image' : // イメージメッセージ
                    $originalContentUrl = $result->original_content;
                    $previewImageUrl = $result->preview_image_url;
                    $this->LineAPI->sendImageMessage ( $originalContentUrl, $previewImageUrl );
                    break;

                case 'imagemap' : // イメージマップメッセージ
                    $baseUrl = $result->original_content;
                    $previewImageUrl = $result->preview_image_url;
                    $this->LineAPI->sendImageMapMessage ( $baseUrl, $previewImageUrl );
                    break;

                case 'confirm' : // Yes/Noメッセージ
                    $mainText = $result->text;
                    $altText = $result->alt_text;
                    $action_char01 = $result->action_char01;
                    $act_type01 = $result->act_type01;
                    $action_char02 = $result->action_char02;
                    $act_type02 = $result->act_type02;
                    $this->LineAPI->sendConfirmMessage ( $mainText, $altText, $action_char01, $act_type01, $action_char02, $act_type02 );
                    break;

            }
            $this->LineAPI->replyMessage ( $event->getReplyToken (), $this->LineAPI->message );

        } elseif ($event->getText () == '作成中・・・') {
        } elseif ($event->getText () == '場所') {
            // カルーセルで場所情報配信
            $columns = [ ];

            // 淀川河川敷
            $action = new UriTemplateActionBuilder ( "詳細", "https://www.yodogawa-park.go.jp/bbq/%E8%A5%BF%E4%B8%AD%E5%B3%B6%E5%9C%B0%E5%8C%BA/" );
            $columns [] = new CarouselColumnTemplateBuilder ( "淀川河川敷", "〒532-0011 大阪府大阪市淀川区西中島2丁目", "https://tci-bbq.whitebear.tk/images/cr_yodogawa.jpg", [$action]);

            // 大泉緑地公園
            $action = new UriTemplateActionBuilder ( "詳細", "http://www.oizumi-ryokuchi.com/file/map.html" );
            $columns [] = new CarouselColumnTemplateBuilder ( "大泉緑地", "〒591-8022 大阪府堺市北区金岡町128","https://tci-bbq.whitebear.tk/images/cr_ooizumi.jpg", [$action] );

            // 寝屋川公園
            $action = new UriTemplateActionBuilder ( "詳細", "http://neyagawa.osaka-park.or.jp/barbecue" );
            $columns [] = new CarouselColumnTemplateBuilder ( "寝屋川公園", "〒572-0854 寝屋川市寝屋川公園1707","https://tci-bbq.whitebear.tk/images/cr_neyagawa.jpg", [$action] );

            // 笹置キャンプ場
            $action = new UriTemplateActionBuilder ( "詳細", "http://www.town.kasagi.lg.jp/contents_detail.php?frmId=166" );
            $columns [] = new CarouselColumnTemplateBuilder ( "笹置キャンプ場", "〒619-1303 京都府相楽郡笠置町笠置佃46", "https://tci-bbq.whitebear.tk/images/cr_kasagi.jpg", [$action] );

            // カラムの配列を組み合わせてカルーセルを作成する
            $carousel = new CarouselTemplateBuilder ( $columns );

            // カルーセルを追加してメッセージを作る
            $carousel_message = new TemplateMessageBuilder ( "開催地情報", $carousel );

            $message = new MultiMessageBuilder ();
            $message->add ( $carousel_message );

            // リプライ送信
            //$response = $bot->replyMessage ( $event->getReplyToken (), $message );
            $response = $this->LineAPI->replyMessage ( $event->getReplyToken (), $message );

            Log::debug("getReplyToken:::" . $event->getReplyToken ());
            Log::debug(print_r($response, true));
            Log::debug(print_r($carousel_message, true));

        } elseif ($event->getText () == 'イベント') {
            $eventArray = $this->mdlEvent->getTodayEvent ( 'line' );

            if (count ( $eventArray ) >= 1) {
                foreach ($eventArray as $key => $value) {
                    $eventInfo ['mainInfo'] []  = $value->event_name. "\n日時：" . date ( 'Y/m/d', strtotime ( $value->event_date ) ). "\n　　　10:00～16:00頃". "\n場所：" . $value->event_place . "\n";

                    $eventInfo ['member'] [] = $this->mdlTarget->getTargetDetailsIdFromNickName ( $value->target_id );
                }

                foreach ($eventInfo ['mainInfo'] as $key => $value) {
                    $meg = $value . "\n";
                    $member = '';
                    foreach ($eventInfo ['member'] [$key] as $keys => $value) {
                        if ($member == '') {
                            $member .= "参加者は、" . count ( $eventInfo ['member'] [$keys] ) . "名\n";
                            $member .= $value . "、" ;
                        } else {
                            $member .= $value ;
                            if( ($keys +1)%3 == 0) {
                                $member .= "\n";
                            }else{
                                $member .= "、";
                            }
                        }
                    }
                    $meg = $meg . $member;
                }
                $this->LineAPI->sendTextMessage ( $meg );

                // イベント情報
                foreach ($eventArray as $key => $value) {
                    $mainText = $value->event_name . ' に参加しますか？';
                    $mainText .= '　場所は、'. $value->event_place;
                    $altText = $value->event_name;
                    $action_char01 = '参加';
                    $act_type01 = $value->id . '/' .  $value->target_id . '/add';
                    $action_char02 = '不参加';
                    $act_type02 =  $value->id . '/' .  $value->target_id .'/del';
                }

                $this->LineAPI->sendConfirmMessage ( $mainText, $altText, $action_char01, $act_type01, $action_char02, $act_type02 );
            } else {
                $text = '企画中のイベントはありません';
                $this->LineAPI->sendTextMessage ( $text );
            }
            // リプライ送信
            $response = $bot->replyMessage ( $event->getReplyToken (), $this->LineAPI->message );

        } elseif ($event->getText () == 'アルバム') {
            // カルーセルでアルバム情報配信
            $columns = [ ];

            $action = new UriTemplateActionBuilder ( "詳細", "https://photos.app.goo.gl/1KCxPKXj87r012vU2" );
            $columns [] = new CarouselColumnTemplateBuilder ( "2018.05.26", "BBQ淀川河川敷", "https://tci-bbq.whitebear.tk/images/2018.05.26.jpg", [$action] );

            $action = new UriTemplateActionBuilder ( "詳細", "https://goo.gl/photos/a1nB47ZqxeeeyfwG9" );
            $columns [] = new CarouselColumnTemplateBuilder ( "2017.06.10", "BBQ淀川河川敷", "https://tci-bbq.whitebear.tk/images/2017.06.10.jpg", [$action] );

            $action = new UriTemplateActionBuilder ( "詳細", "https://goo.gl/photos/rZiRzP6YBU7ue7r57" );
            $columns [] = new CarouselColumnTemplateBuilder ( "2016.10.29", "BBQ大泉緑地", "https://tci-bbq.whitebear.tk/images/2016.10.29.jpg", [$action] );

            $action = new UriTemplateActionBuilder ( "詳細", "https://goo.gl/photos/jNg4oBXDSE8LMCTF6" );
            $columns [] = new CarouselColumnTemplateBuilder ( "2016.08.11", "BBQ淀川河川敷", "https://tci-bbq.whitebear.tk/images/2016.08.11.jpg", [$action] );

            $action = new UriTemplateActionBuilder ( "詳細", "https://goo.gl/photos/UpzvsudLLkG6TdED6" );
            $columns [] = new CarouselColumnTemplateBuilder ( "2016.06.05", "大泉緑地公園リレーマラソン＆BBQ", "https://tci-bbq.whitebear.tk/images/2016.06.05.jpg", [$action] );

            $action = new UriTemplateActionBuilder ( "詳細", "https://goo.gl/photos/AXYsEfvgHRjpruHM9" );
            $columns [] = new CarouselColumnTemplateBuilder ( "2016.04.29", "BBQ淀川河川敷", "https://tci-bbq.whitebear.tk/images/2016.04.29.jpg", [$action] );

            $action = new UriTemplateActionBuilder ( "詳細", "https://goo.gl/photos/CZXWUg3EzXBr4mD87" );
            $columns [] = new CarouselColumnTemplateBuilder ( "2015.10.31", "BBQ淀川河川敷", "https://tci-bbq.whitebear.tk/images/2015.10.31.jpg", [$action] );

            // カラムの配列を組み合わせてカルーセルを作成する
            $carousel = new CarouselTemplateBuilder ( $columns );
            // カルーセルを追加してメッセージを作る
            $carousel_message = new TemplateMessageBuilder ( "アルバム", $carousel );

            $message = new MultiMessageBuilder ();
            $message->add ( $carousel_message );

            // リプライ送信
            $response = $bot->replyMessage ( $event->getReplyToken (), $message );
        } else {

            // メッセージの保存とオウム返し
            $lid = $this->mdlUsers->getUserID2Lid ( 'line', $event->getUserId () );
            $messageType = $event->getMessageType ();
            $messageId = $event->getMessageId ();
            $message = $event->getText ();

            $this->Parrot ( $lid, $messageType, $messageId, $message );
        }
    }


    /**
     * リプライ(自動返信) 画像
     */
    protected function replyImage($event, $bot) {
        // Log::debug ( "getMessageId:" . $event->getMessageId () );

        $response = $bot->getMessageContent ( $event->getMessageId () );
        if ($response->isSucceeded ()) {
            // メッセージの保存とオウム返し用
            $lid = $this->mdlUsers->getUserID2Lid ( 'line', $event->getUserId () );
            $messageType = $event->getMessageType ();
            $messageId = $event->getMessageId ();

            // 受信画像を保存
            Storage::disk ( 'receiveLineImage' )->put ( $event->getMessageId (), $response->getRawBody () );
            list ( $width, $height ) = getimagesize ( storage_path ( 'app/line/img/receive' ) . '/' . $event->getMessageId () );

            $originalContentUrl = 'https://tci-bbq.whitebear.tk/img/receive/' . $event->getMessageId () . '/' . $height . '/' . $width;
            $previewImageUrl = 'https://tci-bbq.whitebear.tk/img/receive/' . $event->getMessageId ();

            $text = '画像を受け取りました';
            $this->LineAPI->sendTextMessage ( $text );

            $response = $this->LineAPI->replyMessage ( $event->getReplyToken (), $this->LineAPI->message );

            // メッセージの保存とオウム返し
            $this->saveMessages ( $lid, $messageType, $messageId, $previewImageUrl,'send');
            $this->Parrot ( $lid, $messageType, $messageId, $originalContentUrl );

        } else {
            Log::error ( $response->getHTTPStatus () . ' ' . $response->getRawBody () );
        }
    }


    /**
     * ポストバックメッセージ
     *
     */
    protected function postBack($event, $bot) {

        $getMeg = $event->getPostbackData ();
        list ( $eventId, $targetId, $type ) = explode ( "/", $getMeg );

        $eventList = $this->mdlEvent->getOne ( 'line', $eventId );

        // UidからLidを取得
        $lid = $this->mdlUsers->getUserID2Lid ( 'line', $event->getUserId () );

        if ($eventList->event_name) {
            if ($type == "add") {
                $receiveMeg = "参加";
                // すでに登録されているか確認
                $res = $this->mdlTarget->getTargetDetailsIdFromLid ( $targetId, $lid );
                if (isset($res->lid)){
                    $text = $eventList->event_name . "にすでに「参加済み」です\n";
                }else{
                    $arrValues = array (
                            'target_id' => $targetId,
                            'uid' => $event->getUserId (),
                            'lid' => $lid
                    );
                    $res = $this->mdlTarget->resistDetails ( 'line', $arrValues );
                    if ($res) {
                        $text = $eventList->event_name . "に\n「参加」\n受け付けました。\n";
                        $text .= "回答ありがとうございます！！";
                    } else {
                        $text = $eventList->event_name . "に登録失敗しました\n";
                    }
                }
            } else {
                $receiveMeg = "不参加";
                $text = $eventList->event_name . "に\n「不参加」\n受け付けました。\n";
                $text .= "また次回いきましょう～";

                $res = $this->mdlTarget->deleteTargetDetailsIdFromLid ( $targetId, $lid );
            }
            $this->LineAPI->sendTextMessage ( $text );
            $this->LineAPI->replyMessage ( $event->getReplyToken (), $this->LineAPI->message );

            // メッセージ情報保存
            $arrayMeg = array (
                    'app_type' => 'line',
                    'meg_type' => 'send',
                    'lid' => $lid,
                    'message_id' => "",
                    'message' => $text,
            );
            $this->mdlMessages->insertOneReceive ( $arrayMeg );

            // メッセージの保存
            $this->saveMessages ( $lid, "text", "", $receiveMeg, 'receive');
            $this->saveMessages ( $lid, "text", "", $text, 'send' );

        }

    }


    /**
     * プロフィール情報取得
     */
    protected function getProfile($event) {
        $profile = array (
                'displayName' => NULL,
                'pictureUrl' => NULL,
                'statusMessage' => NULL
        );

        $httpClient = new CurlHTTPClient ( $this->channelAccessToken );
        $bot = new LINEBot ( $httpClient, [
                'channelSecret' => $this->channelSecret
        ] );

        $response = $bot->getProfile ( $event->getUserId () );
        if ($response->isSucceeded ()) {
            $profile = $response->getJSONDecodedBody ();
        } else {
            Log::debug ( $response->getHTTPStatus () . ' ' . $response->getRawBody () );
        }
        return $profile;
    }


    /**
     * 受信メッセージの保存
     */
    protected function saveMessages($lid, $messageType, $messageId, $message,$meg_type) {

        // メッセージ情報取得
        $arrayMeg = array (
                'app_type' => 'line',
                'meg_type' => $meg_type,
                'lid' => $lid,
                'message_id' => $messageId
        );

        if ($messageType == 'text') {
            $arrayMeg ['message'] = $message;
        } elseif ($messageType == 'image') {
            $arrayMeg ['img_url'] = $message;
        }else{
            return ;
        }
        // 受信メッセージの保存
        $this->mdlMessages->insertOneReceive ( $arrayMeg );
    }


    /**
     * オウム返し
     *
     * @param unknown $event
     * @param unknown $bot
     */
    protected function Parrot($lid, $messageType, $messageId, $message) {

        if (config ( 'whitebear.Parrot' ) == false) {
            return;
        }

        $receiveMessage = '';
        $sendMessage = '';
        unset ( $this->LineAPI );
        $this->LineAPI = new LineAPI ();

        // イベント情報取得
        $getEventList = $this->mdlEvent->getTodayEvent ( 'line' );
//         Log::debug ( ' whitebear.Parrot  ' . config ( 'whitebear.Parrot' )  );
        if ((config ( 'whitebear.Parrot' ) == 0)) {
            Log::debug ( "オウム返ししない");
            return;
        }
//         Log::debug(print_r($getEventList, true));


        $NickName = $this->mdlUsers->getUserID2NickName ( 'line', $lid );
        if ($messageType == 'text') {
            $sendMessage = '【' . $NickName . "さんから】\n" . $message;
            $this->LineAPI->sendTextMessage ( $sendMessage );
        } elseif ($messageType == 'image') {
            $sendMessage = '【' . $NickName . "さんから】\n画像を受け取りました";
            $this->LineAPI->sendTextMessage ( $sendMessage );
            $this->LineAPI->sendImageMessage ( $message, $message );
        }
//         Log::debug ( ' $sendMessage ' . $sendMessage );

        // イベント参加者にオウム返し
        foreach ($getEventList as $key => $event) {
//             Log::debug( $event->target_id);
//             Log::debug($lid);
            $resalt = $this->mdlTarget->getTargetDetailsIdFromLid ( $event->target_id, $lid );

//             Log::debug(print_r($resalt, true));
            if (count ( $resalt )) {
                $targetList = $this->mdlTarget->getTargetDetailsIdFromUids ( $event->target_id );

                foreach ($targetList as $key => $values) {
//                     Log::debug ( "values->uid " . $values->uid );
                    $this->LineAPI->pushMessage ( $values->uid, $this->LineAPI->message );

                    $arrayMeg = array (
                            'app_type' => 'line',
                            'meg_type' => 'send',
                            'lid' => $this->mdlUsers->getUserID2Lid ( 'line', $values->uid )
                    );
                    if ($messageType == 'text') {
                        $arrayMeg ['message'] = $sendMessage;
                    } elseif ($messageType == 'image') {
                        $arrayMeg ['img_url'] = $message;
                    }

                    // メッセージの保存
                    $this->mdlMessages->insertOneReceive ( $arrayMeg );
                }
            }
        }
    }

}
