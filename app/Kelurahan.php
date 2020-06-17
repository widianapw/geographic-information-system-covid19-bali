<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $table = "tb_kelurahan";
    protected $fillable=['id_kecamatan','kelurahan'];

    public function data(){
        return $this->hasMany('App\Data', 'id_kelurahan');
    }
}
