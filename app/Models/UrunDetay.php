<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UrunDetay extends Model
{
    //
    protected $table = 'urun_detay';
    protected $guarded = [];
    public $timestamps = false;

    public function urun(){
        return $this->belongsTo('App\Models\Urun');
    }
    
}
