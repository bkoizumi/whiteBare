<?php
/**
 ******************************************************************************
 * @Description : プロフィール情報再取得バッチ
 * @Author      : B.Koizumi
 * @Create Date : 2017/07/25
 *
 * 実行方法： php artisan getProfile
 ********************************************************************************/
namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Log;

use App\Models\MessageModels;
use App\Models\UsersModels;
use App\Models\LineAPI;

ini_set('memory_limit', '1024M');
set_time_limit(0);

class reGetProfile extends Command
{


  protected $signature = 'reGetProfile';
  protected $description = 'Command description';
  protected $LineAPI;
  protected $mdlUsers;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(){
        parent::__construct();

        //利用モジュール宣言
        $this->LineAPI= new LineAPI();
        $this->mdlUsers = new UsersModels();

    }


    /**
     * コンソールコマンドの実行
     *
     * @return mixed
     */
    public function handle(){
//         Log::info('メッセージ配信開始：' . Carbon::now());

        //プロフィール情報の再取得
        $this->reSetProfile();

    }


    /**
     * プロフィール情報の再取得
     */
    public function reSetProfile(){

    }
}
