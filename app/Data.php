<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    protected $table = "tb_laporan";
    protected $fillable= ['id_kabupaten','positif','meninggal','sembuh','dirawat','tanggal'];

    public function data()
    {
        return $this->belongsTo(Kabupaten::class, 'id_kabupaten');
    }
}
