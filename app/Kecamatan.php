<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = "tb_kecamatan";
    protected $fillable=['id_kabupaten','kecamatan'];
}
