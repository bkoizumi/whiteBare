<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class EventModels extends Model
{
    protected $table = 'events';
    protected $dates = [
            'event_date'
            ,'event_start'
            ,'event_end'
            ,'created_at'
            ,'updated_at'
    ];
    public function resist(array $attributes) {
        return DB::table ( $this->table )->insertGetId ( $attributes );
    }

    public function getListAll($app_type, array $orderBy) {
        $queryString = \DB::connection ()->table ( $this->table );
        $queryString->where ( 'app_type', '=', $app_type );
        foreach ( $orderBy as $key => $val ) {
            $queryString->orderBy ( $key, $val );
        }
        $queryString->select ( 'id', 'event_name', 'event_start', 'event_end', 'target_id', 'status', 'created_at', 'updated_at' );
        return $queryString->get ();
    }

    public function getTodayEvent($app_type) {
        $queryString = \DB::connection ()->table ( $this->table );
        $queryString->where ( 'app_type', '=', $app_type )
        ->where ( 'event_start', '<=', date ( "Y/m/d H:i:s" ) )
        ->where ( 'event_end', '>=', date ( "Y/m/d H:i:s" ) )
        ->where ( 'status', '=', 1 )
        ->where ( 'id', '!=', 1 );

        $queryString->select ( 'id', 'event_name', 'event_date', 'event_place', 'event_start', 'event_end', 'target_id', 'status' );

        return $queryString->get ();
    }

    public function getOne($app_type, $id) {
        $queryString = \DB::connection ()->table ( $this->table );
        $queryString->where ( 'id', '=', $id );
        $queryString->where ( 'app_type', '=', $app_type );

        $queryString->select ( 'id',
                'event_name',
                'event_date',
                'event_place',
                'event_start',
                'event_end',
                'target_id',
                'status',
                'created_at',
                'updated_at' );
        return $queryString->first ();
    }

    public function renewal($id, array $attributes) {
        return DB::table ( $this->table )->where ( 'id', $id )->update ( $attributes );
    }

}











