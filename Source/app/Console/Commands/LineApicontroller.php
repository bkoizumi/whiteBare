<?php
// LINEのuserIdリストをダウンロードするプログラムを粛々と作成してみました。
// わかさ生活のuserIdリストを取得してみましたが、OAに表示されている有効お友達数より1000件ほど少なくなります。。。
//
//
// ルーティングの設定
// // API service
// Route::group([], function () {
//     // api get LINE
//     Route::get('getUserId', 'LineApiController@getUserIds');
// });




namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Elasticsearch\ClientBuilder;
use App\Http\Requests;
use DB;
use Log;
use File;

class LineApiController extends Controller
{
    /*
     *
     */
    public function getUserIds()
    {

        $fileName = 'userId_list_'.date('Ymd').'.'.'csv';
        $filepath = storage_path().'/'.'app'.'/'.'userId'.'/';
        $delimiter = ',';
        if (!File::exists($filepath)) {
            echo 'download.errorMessage.notPath';
            return 1;
        }
        if (file_exists($filepath.$fileName)) {
            unlink($filepath.$fileName);
        }
        $fp = fopen($filepath.$fileName, 'a');
        if (!$fp) {
            echo 'download.errorMessage.NotCSVFile';
            return 1;
        }

        $url = 'https://api.line.me/v2/bot/followers/ids';
        $params = array(
            'start' => '',
        );

        // Test account
        // $token = 'yKHqaWJHhD1U8+F4BRMuFg2LA6WnaohRbzlFvXjNwlFtFEdiBXj5bCU2U2eGjg+U0VlaUBJQclcokNRGjO+0k/KGWXszM45FPfrPck7plKPJnrdYxqVdWAsd1mBiQF7FM0MFzykKEP9vx3ecz8JnDo9PbdgDzCFqoOLOYbqAITQ=';
        // $channelId = '97131374988269f7d6ba0f7e254c620c';

        // Production account
        $token = 'QJc+xxaPDeP6ENljz1Wfheed/KtFpKgCWvIGienbpjMeJOoQhCy/GpBBM4W8clpjZdhzXlsuVYsi95cS6+ck+C7I/nwvP6PRQ0gmlcPrz0HfYbtK3KwZIlIlTTLcPe+cLiXkWlcEi70pM5L5PKgv7Y9PbdgDzCFqoOLOYbqAITQ=';
        $channelId = '3a5ea3401aa309f4de3171c443916b78';

        $headers = array('Authorization:Bearer {'.$token.'}');
        $userId ='';
        $cnt = 0;
        do {
            $getResult = $this->wbsRequest('GET', $url, $params, $headers);
            $userIds = $getResult['userIds'];
            if (array_key_exists('next', $getResult)) {
                $next = $getResult['next'];
                $params = array(
                    'start' => $next,
                );
            }else{
                $next = '';
            }
            $arrCSV = array();
            foreach ($userIds as $userId) {
                $cnt ++;
                array_push($arrCSV, $userId);
                $lid = md5($userId.$channelId);
                array_push($arrCSV, $lid);
                fputcsv($fp, $arrCSV, $delimiter);
                $arrCSV = array();
            }
            unset($userId);
            echo $cnt.'<br>';
            sleep(3);
        } while ($next != '');

        fclose($fp);
        exit;
    }

    /**
     *
     */
    public function wbsRequest($method, $url, $params = array(), $headers)
    {
        // Generate query string
        if ($params['start'] == ''){
            $data = '';
        } else {
            $data = http_build_query($params);
        }
        $url = ($data != '') ? $url.'?'.$data : $url;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        curl_setopt($ch, CURLOPT_PROXYPORT, '8080');
        curl_setopt($ch, CURLOPT_PROXY, 'http://tci-proxy.trans-cosmos.co.jp');

        $respons = curl_exec($ch);
        //ステータスをチェック
        if (preg_match('/^(404|403|500)$/', curl_getinfo($ch, CURLINFO_HTTP_CODE))) {
            return false;
        }
        curl_close($ch);

        // json形式で返ってくるので、配列に変換
        $result = json_decode($respons, true);
        return $result;
    }
}