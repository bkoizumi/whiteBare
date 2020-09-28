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

class LineLoginAPI extends Model
{
    protected $table = 'users';

    public $message;
    protected $client_id;
    protected $client_secret;

    public function __construct() {
        $this->client_id ="1572863896";
        $this->client_secret =  "def4b66355696af09f079c4c52b2743c";
    }

    /**
     * 認可コードを取得
     */
    public function getCode($callBackUrl) {
        $url = 'https://access.line.me/oauth2/v2.1/authorize';
        $url .= '?response_type=code';
        $url .= '&client_id=' . $this->client_id;
        $url .= '&redirect_uri=' . urlencode($callBackUrl);
        $url .= '&state=' . env ( 'APP_HASH_KEY');
        $url .= '&scope=openid%20profile';
        //$url .= '&prompt=consent';        //同意画面を毎回出す
        //$url .= '&bot_prompt=normal';     //友達追加画面を出す
        //$url .= '&bot_prompt=aggressive'; //友達追加画面を出す

        header("Location: $url");
    }

    /**アクセストークンを取得
     *
     * @param unknown $callBackUrl
     */
    public function getAccessToken($callBackUrl, $code) {
        $base_url = 'https://api.line.me/oauth2/v2.1/token';
        $data = [
                'grant_type' => 'authorization_code'
                ,'code' => $code
                ,'redirect_uri' => $callBackUrl
                ,'client_id'=> $this->client_id
                ,'client_secret'=> $this->client_secret
        ];
        $header = [
                'Content-Type: application/x-www-form-urlencoded',
        ];
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $base_url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query( $data ));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);

        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response, true);
        return ($data['access_token']);
        }

    /**
     * プロフィール情報取得
     * @param unknown $callBackUrl
     */
    public function getProfile($LineAccessToken) {
        $base_url = 'https://api.line.me/v2/profile';
        $header = [
                'Authorization: Bearer ' .$LineAccessToken
        ];
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $base_url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
//         curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query( $data ));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);

        $response = curl_exec($curl);
        curl_close($curl);
        $profileData = json_decode($response, true);
        return ($profileData);
    }
}
