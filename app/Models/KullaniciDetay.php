<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KullaniciDetay extends Model
{
    /*use SoftDeletes;*/

    protected $table = 'kullanici_detay';
    protected $guarded = [];

    public function kullanici(){
        return $this->belongsTo('App\Models\Kullanici');
    }

    
}
