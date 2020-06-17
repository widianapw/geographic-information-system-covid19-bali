<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    protected $table = "tb_kabupaten";
    protected $fillable= ['kabupaten'];

    // public function data()
    // {
    //     return $this->hasMany('App\Data', 'id_kabupaten');
    // }
}
