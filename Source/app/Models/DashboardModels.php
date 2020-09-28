<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Log;

class DashboardModels extends Model
{
    protected $table = 'log_analyze';


    public function getListAll($app_type){
        $queryString = \DB::connection()->table($this->table);
        $queryString->where('app_type', '=', $app_type);

        return $queryString->get();
    }


    public function dailyFriendsCount($app_type, $whereFromDay, $whereToDay){

        $queryString = \DB::connection()->table($this->table)
            ->where('app_type', '=', $app_type)
            ->whereBetween('created_at', [$whereFromDay, $whereToDay])
            ->select('all_friends', 'new_friends', 'validity_friends', 'block_friends', 'created_at');

        return $queryString->first();
    }

    public function monthlyAnalyzeCount($app_type, $whereFromDay, $whereToDay){
        $queryString = \DB::connection()->table($this->table)
        ->where('app_type', '=', $app_type)
        ->whereBetween('created_at', [$whereFromDay, $whereToDay])
        ->groupBy(DB::raw("all_friends,validity_friends,DATE_FORMAT(created_at, '%Y/%m')"))
        //->select([DB::raw("sum(all_friends)as all_friends, sum(new_friends)as new_friends, sum(validity_friends)as validity_friends, sum(block_friends) as block_friends, DATE_FORMAT(created_at, '%Y/%m') as created_at")]);
        ->select([DB::raw("all_friends,
                sum(new_friends)as new_friends,
                validity_friends,
                sum(block_friends) as block_friends,
                sum(send_message) as send_message,
                sum(receive_message) as receive_message,

                DATE_FORMAT(created_at, '%Y/%m') as created_at")]);

        //->select('all_friends', 'new_friends', 'validity_friends', 'block_friends', 'created_at');

        return $queryString->get();
    }



}

