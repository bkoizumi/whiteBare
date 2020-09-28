<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class AdminModels extends Model
{
    protected $table = 'admins';

    public function getListAll($app_type, array $orderBy){
      $queryString = \DB::connection()->table($this->table);
      //$queryString->where('app_type', '=', $app_type);
      foreach ($orderBy as $key => $val) {
        $queryString->orderBy($key, $val);
      }
      $queryString->select([
           DB::raw('id')
          ,DB::raw('name')
          ,DB::raw('email')
          ,DB::raw('authority')
          ,DB::raw('status')
          ,DB::raw('locale')
          ,DB::raw('created_at')
          ,DB::raw('updated_at')
      ]);
      return $queryString->get();
    }


    public function getAutoReplies($app_type, $string)
    {
      $queryString = \DB::connection()->table($this->table);
      $queryString->where('app_type', '=', $app_type);
      $queryString->where('receive_meg_body', '=', $string);

      $queryString->select([
           DB::raw('id')
          ,DB::raw('send_meg_type_01')
          ,DB::raw('send_meg_body_01')
      ]);
      return $queryString->first();
    }


    public function resist($app_type, array $string){
        return DB::table($this->table)->insertGetId($string);
    }


    public function renewal($id, array $string){
        return DB::table($this->table) ->where('id', $id)->update($string);
    }

    public function getOne($app_type, $uid)
    {
      $queryString = \DB::connection()->table($this->table);
      //$queryString->where('app_type', '=', $app_type);
      $queryString->where('id', '=', $uid);

      $queryString->select([
           DB::raw('id')
          ,DB::raw('name')
          ,DB::raw('email')
          ,DB::raw('lid')
          ,DB::raw('authority')
          ,DB::raw('status')
          ,DB::raw('locale')
          ,DB::raw('created_at')
          ,DB::raw('updated_at')
      ]);
      return $queryString->first();
    }

}
