<?php

/**
 * *****************************************************************************
 * @Description : メッセージ配信バッチ
 * @Author : B.Koizumi
 * @Create Date : 2017/04/03
 *
 * 実行方法： php artisan sendMessage
 * ******************************************************************************
 */
namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Log;
use App\Models\MessagesModels;
use App\Models\TargetsModels;
use App\Models\UsersModels;
use App\Models\LineAPI;

ini_set ( 'memory_limit', '1024M' );
set_time_limit ( 0 );

class sendMessage extends Command
{

    protected $signature = 'sendMessage';

    protected $description = 'Command description';

    protected $mdlMessages;

    protected $mdlTargets;

    protected $mdlUsers;

    protected $LineAPI;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct ();

        // 利用モジュール宣言
        $this->channelAccessToken = env ( 'LINE_CHANNEL_TOKEN' );
        $this->channelSecret = env ( 'LINE_CHANNEL_SECRET' );
        $this->mdlMessages = new MessagesModels ();
        $this->mdlTargets = new targetsModels ();
        $this->mdlUsers = new UsersModels ();
        $this->LineAPI = new LineAPI ();

    }


    /**
     * コンソールコマンドの実行
     *
     * @return mixed
     */
    public function handle() {
//         Log::debug('スケジュール配信開始');

        // 配信スケジュール確認
        $this->checkSendMegSchedule ();

//         Log::debug('スケジュール配信終了');
    }


    /**
     * 配信スケジュールのチェック
     */
    public function checkSendMegSchedule() {

        $date = array (
                'send_schedule' => Carbon::now (),
                'status' => '1'
        );
        $msgList = $this->mdlMessages->checkSchedule ( 'line', $date );

        if (count ( $msgList ) >= 1) {
            $this->sendLineMessage ( $msgList );
        }
    }


    /**
     * Line メッセージ配信
     */
    public function sendLineMessage($msgList) {

        $textMessage = '';
        $imageMessage = '';
        $stickerMessage = '';
        $imagemapMessage = '';

        foreach ($msgList as $key => $message) {
            $msgDetailList = $this->mdlMessages->getMessageDetail ( $message->id );

            foreach ($msgDetailList as $key => $msgDetail) {

                switch ($msgDetail->type) {

                    case 'text' : // テキストメッセージ
                        $this->LineAPI->sendTextMessage ( $msgDetail->text );
                        break;

                    case 'image' : // イメージメッセージ
                        $originalContentUrl = $msgDetail->original_content;
                        $previewImageUrl = $msgDetail->preview_image_url;
                        $this->LineAPI->sendImageMessage ( $originalContentUrl, $previewImageUrl );
                        break;

                    case 'imagemap' : // イメージマップメッセージ
                        $baseUrl = $msgDetail->original_content;
                        $previewImageUrl = $msgDetail->preview_image_url;
                        $this->LineAPI->sendImageMapMessage ( $baseUrl, $previewImageUrl );
                        break;

                    case 'confirm' : // Yes/Noメッセージ
                        $mainText = $msgDetail->text;
                        $altText = $msgDetail->alt_text;
                        $action_char01 = $msgDetail->action_char01;
                        $act_type01 = $msgDetail->act_type01;
                        $action_char02 = $msgDetail->action_char02;
                        $act_type02 = $msgDetail->act_type02;
                        $this->LineAPI->sendConfirmMessage ( $mainText, $altText, $action_char01, $act_type01, $action_char02, $act_type02 );
                        break;

                }
            }

            // 送信対象が0：全員かどうかの判断
            if ($message->target_id == 0) {
                $getTargetList = $this->mdlUsers->getListAll ( 'line', array (), null );
                // 送信メッセージのパラメーターあり/なしを取得
                $getTargetPram = $this->mdlTargets->getOne ( 'line', 1 );

            } else {
                // 送信メッセージのパラメーターあり/なしを取得
                $getTargetPram = $this->mdlTargets->getOne ( 'line', $message->target_id );

                $getTargetList = $this->mdlTargets->getTargetDetailsIdFromUids ( $message->target_id );
            }
            $targetUserIdList = array ();

            if (($getTargetPram->parameters == 0) or ($message->target_id == 0)) {
                // パラメータがないので、マルチキャストを利用する
                foreach ($getTargetList as $key => $targetUserId) {
                    $targetUserIdList [] = $targetUserId->uid;

                    Log::debug ( $targetUserId->uid );
                }

                $response = $this->LineAPI->multicastMessage ( $targetUserIdList, $this->LineAPI->message );
            } else {
                foreach ($getTargetList as $key => $targetUserId) {
                    $response = $this->LineAPI->pushMessage ( $targetUserId->uid, $this->LineAPI->message );
                }
            }

            // 配信完了ならステータスの変更
            if ($response->getHTTPStatus () == "200") {
                $this->mdlMessages->chengeStatus ( $message->id, 3 );
            } else {
                Log::debug ( $response->getHTTPStatus () . ' ' . $response->getRawBody () );
                $this->mdlMessages->chengeStatus ( $message->id, 99 );
            }
        }

    }
}
