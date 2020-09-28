<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Log;

class TargetsModels extends Model
{
    protected $table = 'targets';
    protected $tableDetails = 'targets_details';

    public function getListAll($app_type, array $orderBy) {
        $queryString = \DB::connection ()->table ( $this->table )
            ->where ( 'app_type', '=', $app_type )
            ->where ( 'status', '=', 1 );
        foreach ( $orderBy as $key => $val ) {
            $queryString->orderBy ( $key, $val );
        }
        $queryString->select ( 'id', 'name', 'parameters', 'status', 'notes', 'created_at', 'updated_at' );

        return $queryString->get ();
    }

    public function getAutoReplies($app_type, $string) {
        $queryString = \DB::connection ()->table ( $this->table );
        $queryString->where ( 'app_type', '=', $app_type );
        $queryString->where ( 'receive_meg_body', '=', $string );
        $queryString->select ( 'id', 'send_meg_type_01', 'send_meg_body_01' );

        return $queryString->first ();
    }

    public function resist($app_type, array $string) {
        return DB::table ( $this->table )->insertGetId ( $string );
    }

    public function setUpdate($id, array $string) {
        return DB::table ( $this->table )->where ( 'id', $id )->update ( $string );
    }

    public function resistDetails($app_type, array $string) {
        return DB::table ( $this->tableDetails )->insertGetId ( $string );
    }

    public function deleteDetails($id) {
        return DB::table ( $this->tableDetails )->where ( 'target_id', '=', $id )->delete ();
    }

    public function renewal($id, array $string) {
        return DB::table ( $this->table )->where ( 'id', $id )->update ( $string );
    }

    public function getOne($app_type, $id) {

        $queryString = DB::connection ()->table ( $this->table );
        $queryString->where ( 'app_type', '=', $app_type );
        $queryString->where ( 'id', '=', $id );

        $queryString->select ( 'id', 'name', 'parameters', 'status', 'notes', 'created_at', 'updated_at' );

        return $queryString->first ();
    }

    // LIDが該当のターゲットIDに登録されているか確認
    public function getTargetDetailsIdFromLid($targetId, $lid) {
        $queryString = \DB::connection ()->table ( $this->tableDetails );
        $queryString->where ( 'target_id', '=', $targetId );
        $queryString->where ( 'lid', '=', $lid );

        return $queryString->first ();
    }

    // 登録されているターゲットIDからUIDを取得
    public function getTargetDetailsIdFromUids($targetId) {
        $queryString = \DB::connection ()->table ( $this->tableDetails );
        $queryString->where ( 'target_id', '=', $targetId );

        $queryString->select ( 'uid', 'lid' );

        return $queryString->get ();
    }

    // 登録されているターゲットIDからニックネームを取得
    public function getTargetDetailsIdFromNickName($targetId) {
        $queryString = \DB::connection ()->table ( 'users' );
        $queryString->whereIn ( 'uid', function ($query) use ($targetId) {
            $query->select ( DB::raw ( 'uid' ) )
                ->from ( 'targets_details' )
                ->where ( 'target_id', '=', $targetId )
                ->orderBy('created_at', 'desc');
        } );

        return $queryString->pluck ( 'nick_name' );
    }

    // 登録されているターゲットIDからニックネーム等を取得
    public function getTargetDetailList($targetId) {
        $queryString = \DB::connection ()->table ( 'users' );
        $queryString->whereIn ( 'uid', function ($query) use ($targetId) {
            $query->select ( DB::raw ( 'uid' ) )
            ->from ( 'targets_details' )
            ->where ( 'target_id', '=', $targetId );
        } );

            return $queryString->get ();
    }
    /**
     * 登録されているターゲットIDからLIDを削除
     *
     * @param unknown $id
     */
    public function deleteTargetDetailsIdFromLid($targetId, $lid) {
        return DB::table ( $this->tableDetails )->where ( 'lid', '=', $lid )->where ( 'target_id', '=', $targetId )->delete ();
    }

}
