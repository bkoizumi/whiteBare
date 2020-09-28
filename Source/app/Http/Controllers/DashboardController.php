<?php

namespace App\Http\Controllers;


use Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AppBaseController;
use Carbon\Carbon;

use App\Models\DashboardModels;
use App\Models\LogAnalyzeModels;


class DashboardController extends Controller
{
    protected $mdlLogAnalyze;
    protected $mdlDashboard;


    public function __construct(){
        //利用モジュール宣言
        $this->mdlLogAnalyze = new LogAnalyzeModels();
        $this->mdlDashboard = new DashboardModels();
    }

    public function index(){
        $today = Carbon::now()->format('Y/m/d');
        $yesterday = Carbon::now()->subDay(1)->format('Y/m/d');
        $fromMonth = Carbon::now()->subYear()->format('Y/m/d');

        $analyzeData['all_friends'] =  $this->mdlLogAnalyze->friendsCount('line', 'all');
//         $yesterdayFriends =  $this->mdlDashboard->dailyFriendsCount('line', $yesterday, $today);

//         $analyzeData['yesterdayFriends'] = $yesterdayFriends->new_friends;
        $analyzeData['yesterdayFriends'] = 0;

        $analyzeMonth =  $this->mdlDashboard->monthlyAnalyzeCount('line', $fromMonth, $today);
        $analyzeData['analyzeMonth'] = $analyzeMonth;

        $analyzeData['send_message'] = $analyzeMonth[0]->send_message;
        $analyzeData['receive_message'] = $analyzeMonth[0]->receive_message;

        Log::debug($analyzeData);
        return view('dashboard',  $analyzeData);
    }
}
