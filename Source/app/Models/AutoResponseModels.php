<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class AutoResponseModels extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'keywords';


    /**
     * Map relation between 2 tables
     *
     */
    public function messageContents()
    {
        return $this->hasMany('App\Models\MessageContents');
    }


    public function getAllList($app_type, array $orderBy)
    {
      $queryString = \DB::connection()->table($this->table);
      $queryString->where('app_type', '=', $app_type);
      foreach ($orderBy as $key => $val) {
        $queryString->orderBy($key, $val);
      }
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




}
