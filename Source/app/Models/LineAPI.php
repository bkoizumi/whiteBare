<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Log;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;

class LineAPI extends Model
{
    protected $table = 'users';

    public $message;
    protected $httpClient;
    protected $bot;

    public function __construct() {
        $this->message = new MultiMessageBuilder ();
        $this->httpClient = new CurlHTTPClient ('YGUzHpLDpqJcoKdKJ1knhyI9YPHtB30ArPZqfCGFppswoU2B3lRWOeW+pPRWDTovns5eOYOIM+0Ac9Obi+w3gepZzZswYTktbsu3PnhRExNDzDQ1LZ9Zq6fVQhvGGwvzod/5n/vqauBEb+sW+Ury0QdB04t89/1O/w1cDnyilFU=');
        $this->bot = new LINEBot ( $this->httpClient, [
                'channelSecret' => 'c3195cb4b264b86d95e80ca3ab7720ce'
        ] );
    }

    /**
     * Lineのイベント取得
     * @param unknown $Content
     * @param unknown $signature
     * @return \LINE\LINEBot\Event\BaseEvent[]
     */
    public function parseEventRequest($Content, $signature) {
        $events = $this->bot->parseEventRequest ($Content, $signature);
        return $events;
    }


    /**
     * プロフィール情報の取得
     */
    public function getProfile($userId) {
        $profile = array (
                'displayName' => NULL,
                'pictureUrl' => NULL,
                'statusMessage' => NULL
        );
        $response = $this->bot->getProfile ( $userId );

        if ($response->isSucceeded ()) {
            $profile = $response->getJSONDecodedBody ();
        } else {
            Log::debug ( $response->getHTTPStatus () . ' ' . $response->getRawBody () );
        }

        return $profile;
    }

    /**
     * 絵文字変換
     */
    public function convertEmoticon($message = '') {
//         $message = preg_replace_callback ( '/\([\w ]+\)/', function ($matches) {
//             $code = config ( 'line.emotion.' . $matches [0] );
//             $bin = hex2bin ( str_repeat ( '0', 8 - strlen ( $code ) ) . $code );
//             return mb_convert_encoding ( $bin, 'UTF-8', 'UTF-32BE' );
//         }, $message );
        return $message;
    }

    /**
     * テキストメッセージ送信
     */
    public function sendTextMessage($textMessage) {

        $textMessage = new TextMessageBuilder ( $this->convertEmoticon ( $textMessage ) );
        $this->message->add ( $textMessage );
    }

    /**
     * イメージメッセージ送信
     */
    public function sendImageMessage($originalContentUrl, $previewImageUrl) {
        $imageMessage = new ImageMessageBuilder ( $originalContentUrl, $previewImageUrl );
        $this->message->add ( $imageMessage );
    }

    /**
     * イメージマップメッセージ送信
     */
    public function sendImageMapMessage($baseUrl, $altText, $baseSizeBuilder, array $imagemapActionBuilders) {

        $imageMessage = new ImagemapMessageBuilder ( $baseUrl, $altText, $baseSizeBuilder, $imagemapActionBuilders );
        $this->message->add ( $imageMessage );
    }

    /**
     * Yes/Noメッセージ送信
     */
    public function sendConfirmMessage($mainText, $altText, $action_char01, $act_type01, $action_char02, $act_type02) {

        $yesPost = new PostbackTemplateActionBuilder ( $action_char01, $act_type01 );
        $noPost = new PostbackTemplateActionBuilder ( $action_char02, $act_type02 );
        $confirm = new ConfirmTemplateBuilder ( $mainText, [ $yesPost, $noPost ] );

        $confirmMessage = new TemplateMessageBuilder ( $altText, $confirm );

        $this->message->add ( $confirmMessage );
    }

    /**
     * リプライメッセージ
     *
     * @param unknown $replyToken
     * @param unknown $message
     */
    public function replyMessage($replyToken, $message) {
        $response = $this->bot->replyMessage ( $replyToken, $message );
        return $response;
    }

    /**
     * マルチキャストメッセージ送信
     */
    public function multicastMessage($uidList, $Message) {
        $response = $this->bot->multicast ( $uidList, $Message );
        return $response;
    }

    /**
     * プッシュメッセージ送信
     */
    public function pushMessage($uid, $Message) {
        $response = $this->bot->pushMessage ( $uid, $Message );
        return $response;
    }



}
