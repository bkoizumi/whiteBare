<?php
/**
 ******************************************************************************
 * @Description : ダッシュボード集計バッチ
 * @Author      : B.Koizumi
 * @Create Date : 2017/08/05
 *
 * 実行方法： php artisan logAnalyze
 ********************************************************************************/
namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Log;

use App\Models\LogAnalyzeModels;

ini_set('memory_limit', '1024M');
set_time_limit(0);

class logAnalyze extends Command
{


  protected $signature = 'logAnalyze';
  protected $description = 'Command description';

  protected $mdlLogAnalyze;
  protected $analyzeData;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->analyzeData = array();

        //利用モジュール宣言
        $this->mdlLogAnalyze = new LogAnalyzeModels();

    }


    /**
     * コンソールコマンドの実行
     *
     * @return mixed
     */
    public function handle()
    {
        //友達情報集計
        $this->analyzeFriends();

        //メッセージ集計
        $this->analyzeMessages();

        //DB登録
        $this->analyzeData['app_type'] = 'line';
        $this->mdlLogAnalyze->resist($this->analyzeData);
    }


    /**
     * 友達情報集計
     */
    public function analyzeFriends(){
        $this->analyzeData['all_friends'] = $this->mdlLogAnalyze->friendsCount('line', 'all');
        $this->analyzeData['new_friends'] = $this->mdlLogAnalyze->friendsCount('line', 'new');
        $this->analyzeData['validity_friends'] = $this->mdlLogAnalyze->friendsCount('line', 'validity');
        $this->analyzeData['block_friends'] = $this->mdlLogAnalyze->friendsCount('line', 'block');
    }


    /**
     * メッセージ情報集計
     */
    public function analyzeMessages(){
        $this->analyzeData['send_message'] = $this->mdlLogAnalyze->messagesCount('line', 'send');
        $this->analyzeData['receive_message'] = $this->mdlLogAnalyze->messagesCount('line', 'receive');
    }





}
