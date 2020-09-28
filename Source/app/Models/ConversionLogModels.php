<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class ConversionLogModels extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'conversion_log';


    public function insertOne( array $attributes)
    {
      DB::table($this->table)->insert($attributes);
    }





}
