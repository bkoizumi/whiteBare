<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class KeywordsModels extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'keywords';
    protected $tableDetails = 'keywords_details';

    /**
     * Map relation between 2 tables
     */
    public function messageContents() {
        return $this->hasMany ( 'App\Models\MessageContents' );
    }

    public function getAllList($app_type, array $orderBy) {
        $queryString = \DB::connection ()->table ( $this->table );
        $queryString->where ( 'app_type', '=', $app_type );
        foreach ( $orderBy as $key => $val ) {
            $queryString->orderBy ( $key, $val );
        }
        return $queryString->get ();
    }

    public function getAutoReplies($app_type, $string) {
        return \DB::connection ()->table ( $this->table )
        ->join($this->tableDetails , function ($join) use ($app_type, $string)  {
            $join->on('keywords.id', '=', 'keywords_details.keywords_id')
            ->where ( 'keywords.app_type', '=', $app_type )
            ->where ( 'keywords.status', '=', "1" )
            ->where ( 'keywords.receive_meg_body', '=', $string );
        })

        ->select ( 'keywords.id as id', 'keywords_details.type as type ', 'keywords_details.text as text')
        ->first ();
    }

    /**
     * 情報取得
     *
     * @param unknown $app_type
     * @param unknown $id
     */
    public function getOne( $id) {
        return \DB::connection ()->table ( $this->table)
        ->where ( 'id', '=', $id )->first ();
    }

    /**
     * 詳細情報取得
     *
     * @param unknown $app_type
     * @param unknown $id
     */
    public function getDetail( $id) {
        return \DB::connection ()->table ( $this->tableDetails )
            ->where ( 'keywords_id', '=', $id )->first ();
    }

    /**
     * メッセージヘッダー登録
     * @param array $attributes
     */
    public function insertKeywordsHeader(array $attributes) {
        return DB::table ( $this->table )->insertGetId ( $attributes );
    }

    /**
     * メッセージ詳細登録
     * @param array $attributes
     */
    public function insertKeywordsDetails(array $attributes) {
        foreach ( $attributes as $attribute ) {
            DB::table ( $this->tableDetails )->insert ( $attribute );
        }
    }

    /**
     * メッセージ詳細削除/登録
     * @param array $attributes
     */
    public function updateKeywordsDetails($id, array $attributes) {
        DB::transaction(function () use ($id, &$attributes) {
            DB::table ( $this->tableDetail )->where ( 'keywords_id', $id )->delete();
            foreach ( $attributes as $attribute ) {
                DB::table ($this->tableDetail  )->insertGetId ( $attribute );
            }
        });
    }

}
