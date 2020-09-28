<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Log;

class UsersModels extends Model
{
    protected $table = 'users';

    /**
     * 全ユーザー情報取得
     *
     * @param unknown $app_type
     * @param array $orderBy
     */
    public function getListAll($app_type, array $orderBy, $paginate) {
        $queryString = \DB::connection ()->table ( $this->table )->where ( 'app_type', '=', $app_type );
        foreach ( $orderBy as $key => $val ) {
            $queryString->orderBy ( $key, $val );
        }
        $queryString->select ( 'id', 'lid', 'uid', 'relation_state', 'nick_name', 'thumbnail_url', 'created_at', 'updated_at' );
        if ($paginate) {
            $queryString->paginate ( $paginate );
        }

        return $queryString->get ();
    }

    public function countLid($app_type, $newLid) {
        $queryString = \DB::connection ()->table ( $this->table )->where ( 'app_type', $app_type )->where ( 'lid', 'like', 'L%' . $newLid );

        return $queryString->count ();
    }

    public function insertOne($app_type, array $attributes) {
        DB::table ( $this->table )->insert ( $attributes );
    }

    public function deleteOne($app_type, $lid) {
        DB::table ( $this->table )->where ( 'uid', $lid )->delete ();
    }

    public function updateOne($app_type, $uid, array $attributes) {
        return DB::table ( $this->table )->where ( 'uid', $uid )->update ( $attributes );
    }

    // UserIDからLID取得
    public function getUserID2Lid($app_type, $UserId) {
        $result = \DB::connection ()->table ( $this->table )
            ->where ( 'app_type', '=', $app_type )
            ->where ( 'uid', '=', $UserId )
            ->select ( DB::raw ( 'lid' ) )
            ->first ();
        return $result->lid;
    }

    // LIDからUserID取得
    public function getLid2UserID($app_type, $lid) {
        $result = \DB::connection ()->table ( $this->table )
            ->where ( 'app_type', '=', $app_type )
            ->where ( 'lid', '=', $lid )
            ->select ( DB::raw ( 'uid' ) )
            ->first ();

        return $result->uid;
    }

    public function getUserInfo($app_type, $lid) {
        return \DB::connection ()->table ( $this->table )
            ->where ( 'app_type', '=', $app_type )
            ->where ( 'lid', '=', $lid )
            ->select ( 'uid', 'lid', 'nick_name', 'thumbnail_url' )
            ->first ();
    }

    // LIDからニックネーム取得
    public function getUserID2NickName($app_type, $lid) {
        $result = \DB::connection ()->table ( $this->table )
            ->where ( 'app_type', '=', $app_type )
            ->where ( 'lid', '=', $lid )
            ->select ( DB::raw ( 'nick_name' ) )
            ->first ();

        return $result->nick_name;
    }

}
