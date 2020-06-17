<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    protected $table = "tb_laporan";
    protected $fillable= ['id_kelurahan', 'level', 'ppln','ppdn','tl','lainnya','perawatan','sembuh','meninggal','total','tanggal','status'];

    public function data()
    {
        return $this->belongsTo(Kelurahan::class, 'id_kelurahan');
    }
}