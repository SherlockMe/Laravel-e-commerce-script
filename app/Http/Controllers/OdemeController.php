<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Kullanici;
use App\Models\Siparis;
use App\Models\SepetUrun;
use App\Models\Sepet;
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
        
        $siparis = request()->all();
        $siparis['sepet_id'] = session('aktif_sepet_id');
        $siparis['banka'] = "Garanti";
        $siparis['taksit_sayisi'] = 1;
        $siparis['durum'] = "Siparişiniz alındı.";
        $siparis['siparis_tutari'] = Cart::subtotal();

        Siparis::create($siparis);
        
        Cart::destroy();

        $aktif_sepet_id = session('aktif_sepet_id');
        SepetUrun::where('sepet_id',$aktif_sepet_id)->Delete();

        $kullanici_id = auth()->id();
        Sepet::where('kullanici_id',$kullanici_id)->Delete();

        session()->forget('aktif_sepet_id');

        return redirect()->route('siparisler')
        ->with('mesaj_tur','success')
        ->with('mesaj','Ödeme başarılı');

    }

}
