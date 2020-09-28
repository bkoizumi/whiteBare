<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Log;
use Carbon\Carbon;

class LogAnalyzeModels extends Model
{
    protected $today;
    protected $yesterday;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        $this->today = Carbon::now ();
        $this->yesterday = $this->today->subDay ()->format ( 'Y/m/d' );
    }

    /**
     * 登録
     */
    public function resist(array $attributes) {
        return DB::table ( 'log_analyze' )->insertGetId ( $attributes );
    }

    /**
     * 集計：友達数
     */
    public function friendsCount($app_type, $analyzeType) {
        if ($analyzeType == 'new') {
            return DB::table ( 'users' )->where ( 'relation_state', 0 )
                ->where ( 'app_type', $app_type )
                ->whereBetween ( 'created_at', [
                    $this->yesterday . ' 00:00:00',
                    $this->yesterday . ' 23:59:59'
            ] )
                ->count ();

        } elseif ($analyzeType == 'all') {
            return DB::table ( 'users' )->where ( 'app_type', $app_type )->where ( 'relation_state', 0 )->count ();

        } elseif ($analyzeType == 'validity') {
            return DB::table ( 'users' )->where ( 'app_type', $app_type )->where ( 'relation_state', 0 )->count ();

        } elseif ($analyzeType == 'block') {
            return DB::table ( 'users' )
              ->where ( 'app_type', $app_type )
              ->where ( 'relation_state', 1 )
              ->whereBetween ( 'block_at', [
                    $this->yesterday . ' 00:00:00',
                    $this->yesterday . ' 23:59:59'
                    ] )
              ->count ();
        }
    }

    /**
     * 集計：メッセージ数
     *
     * @param unknown $app_type
     * @param unknown $analyzeType
     */
    public function messagesCount($app_type, $analyzeType) {
        return DB::table ( 'chat' )->where ( 'app_type', $app_type )
            ->where ( 'meg_type', $analyzeType )
            ->whereBetween ( 'created_at', [
                $this->yesterday . ' 00:00:00',
                $this->yesterday . ' 23:59:59'
        ] )
            ->count ();
    }
}
