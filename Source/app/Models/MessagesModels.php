<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MessagesModels extends Model
{

    protected $table = 'messages';
    protected $tableDetail = 'messages_details';

    public function insertOneReceive(array $attributes) {
        return DB::table ( 'chat' )->insertGetId ( $attributes );
    }

    public function getList($app_type, array $orderBy) {
        $queryString = DB::connection ()->table ( 'messages' )
            ->leftJoin ( 'targets', 'targets.id', '=', 'messages.target_id' )
            ->where ( 'messages.app_type', '=', $app_type )
            ->select ( 'messages.id', 'messages.title', 'messages.send_schedule', 'messages.status', 'messages.target_id',  'targets.name', 'messages.created_at', 'messages.updated_at' );
        foreach ( $orderBy as $key => $val ) {
            $queryString->orderBy ( $key, $val );
        }

        return $queryString->get ();
    }

    /**
     * 情報取得
     *
     * @param unknown $app_type
     * @param unknown $id
     */
    public function getOne($app_type, $id) {

        $queryString = DB::connection ()->table ( $this->table );
        $queryString->where ( 'id', '=', $id );
        return $queryString->first ();
    }

    /**
     * 詳細情報取得
     *
     * @param unknown $app_type
     * @param unknown $id
     */
    public function getDetail($app_type, $id) {

        $queryString = DB::connection ()->table ( $this->tableDetail )
            ->where ( 'message_id', '=', $id )
            ->select ('*' , DB::raw("REPLACE(text ,'\r\n','#br#') as rtext") );

        return $queryString->get ();
    }

    public function getChatList($app_type) {
        $queryString = DB::connection ()->table ( 'chat' )
            ->select ( 'users.nick_name as nick_name', 'users.lid as lid', 'chat.message as message', 'chat.created_at as created_at' )
            ->leftJoin ( 'users', 'chat.lid', '=', 'users.lid' )
            ->orderBy ( 'chat.created_at', 'desc' )
            ->whereIn ( DB::raw ( '(chat.lid ,chat.id)' ), function ($query) use ($app_type) {
            $query->select ( 'lid', DB::raw ( 'max(id)' ) )
                ->where ( 'chat.app_type', '=', $app_type )
                ->where ( 'chat.meg_type', '=', 'receive' )
                ->from ( 'chat' )
                ->groupBy ( 'lid' );
        } );

        return $queryString->get ();
    }

    public function getListChatDetail($app_type, $lid) {
        $queryString = DB::connection ()->table ( 'chat' )
            ->where ( 'app_type', '=', $app_type )
            ->where ( 'lid', '=', $lid )
            ->select ( 'id', 'message_id', 'meg_type', 'message', 'img_url', 'created_at' )
            ->OrderBy ( 'created_at', 'desc' )
            ->OrderBy ( 'id', 'desc' )
            ->take ( 10 );

        return $queryString->get ();
    }

    /**
     * メッセージヘッダー登録
     * @param array $attributes
     */
    public function insertMessageHeader(array $attributes) {
        return DB::table ( $this->table )->insertGetId ( $attributes );
    }


    /**
     * メッセージヘッダー更新
     * @param unknown $id
     * @param array $attributes
     */
    public function updateMessageHeader($id, array $attributes) {
        return DB::table ( $this->table )->where ( 'id', $id )->update ( $attributes );
    }


    /**
     * メッセージ詳細登録
     * @param array $attributes
     */
    public function insertMessageDetails(array $attributes) {
        foreach ( $attributes as $attribute ) {
            DB::table ( 'messages_details' )->insert ( $attribute );
        }
    }

    /**
     * メッセージ詳細削除/更新
     * @param array $attributes
     */
    public function updateMessageDetails($id, array $attributes) {
        DB::transaction(function () use ($id, &$attributes) {
            DB::table ( $this->tableDetail )->where ( 'message_id', $id )->delete();
            foreach ( $attributes as $attribute ) {
                DB::table ($this->tableDetail  )->insertGetId ( $attribute );
            }
        });
    }


    /**
     * 配信スケジュール確認 (バッチから実行)
     *
     * @param unknown $app_type
     * @param array $attributes
     */
    public function checkSchedule($app_type, array $attributes) {

        $queryString = \DB::connection ()->table ( $this->table );
        $queryString->where ( 'app_type', '=', $app_type );

        foreach ( $attributes as $key => $val ) {
            if ($key == 'send_schedule') {
                $queryString->where ( 'send_schedule', '<=', $attributes ['send_schedule'] );
            } else {
                $queryString->where ( $key, $val );
            }
        }
        $queryString->select ( [
                DB::raw ( 'id' ),
                DB::raw ( 'title' ),
                DB::raw ( 'send_schedule' ),
                DB::raw ( 'status' ),
                DB::raw ( 'target_id' ),
                DB::raw ( 'created_at' )
        ] );
        return $queryString->get ();
    }

    public function getMessageDetail($id) {

        $queryString = \DB::connection ()->table ( $this->tableDetail );
        $queryString->where ( 'message_id', $id );

        return $queryString->get ();
    }

    public function getAll($app_type, array $attributes, $order, $dir) {

        $queryString = \DB::connection ()->table ( $this->table );
        $queryString->where ( 'app_type', $app_type );

        foreach ( $attributes as $key => $val ) {
            $queryString->where ( $key, $val );
        }
        $queryString->orderBy ( $order, $dir );
        $queryString->select ( [
                DB::raw ( 'id' ),
                DB::raw ( 'title' ),
                DB::raw ( 'send_schedule' ),
                DB::raw ( 'status' ),
                DB::raw ( 'created_at' )
        ] );
        return $queryString->get ();
    }

    public function chengeStatus($messageId, $status) {
        return DB::table ( $this->table )->where ( 'id', $messageId )->update ( [
                'status' => $status
        ] );

    }
}


