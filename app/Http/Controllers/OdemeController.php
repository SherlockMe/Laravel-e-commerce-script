<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Kullanici;
use Cart;

class OdemeController extends Controller
{
    
    public function index(){

        if (!auth()->check()){
        return redirect()->route('kullanici.oturumac')
        ->with('mesaj_tur','info')
        ->with('mesaj','Ödeme işlemi için oturum açın veya kayıt olun.');
        }
        else if (count(Cart::content())==0)
        {
        return redirect()->route('anasayfa')
        ->with('mesaj_tur','info')
        ->with('mesaj','Ödeme işlemi için sepetinizde ürün bulunmalıdır.');

        }

        $kullanici_detay = auth()->user()->detay;

        return view('odeme', compact('kullanici_detay'));
    }


    public function odemeyap(){
        
        return view('sepet');
    }

}
