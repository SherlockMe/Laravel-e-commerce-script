<?php

namespace App\Http\Controllers;

use App\Models\Kullanici;
use App\Models\Urun;
use App\Models\Sepet;
use App\Models\SepetUrun;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Validator;

class SepetController extends Controller
{
   

    public function index(){
        return view('sepet');
    }

    public function ekle(){

        $urun = Urun::find(request('id'));
        $cartItem = Cart::add($urun->id, $urun->urun_adi, 1, $urun->fiyat, ['slug' => $urun->slug]);

        if (auth()->check()) {
            $aktif_sepet_id = session('aktif_sepet_id'); /* sessiondan veriyi cekiyoruz*/ 
            if (!isset($aktif_sepet_id)){ /* kontrol ediliyor */
            $aktif_sepet=Sepet::create([
                'kullanici_id'=>auth()->id() /* kullanici girişini elde ediyoruz*/ 
            ]);
            $aktif_sepet_id = $aktif_sepet->id;
            session()->put('aktif_sepet_id', $aktif_sepet_id); /* sessiona değer atılıyor */
            }

            SepetUrun::updateOrCreate(
                ['sepet_id'=> $aktif_sepet_id, 'urun_id'=> $urun->id],
                ['adet'=> $cartItem->qty, 'fiyati'=> $urun->fiyat, 'durum'=> 'Beklemede']
            );

        }

        return redirect()->route('sepet')
        ->with('mesaj_tur','success')
        ->with('mesaj','Ürün Sepete Eklendi');
    }

    public function kaldir($rowid){

        if (auth()->check()) {
            $aktif_sepet_id = session('aktif_sepet_id');
            $cartItem = Cart::get($rowid);
            SepetUrun::where('sepet_id',$aktif_sepet_id)->where('urun_id', $cartItem->id)->Delete();
        }

       Cart::remove($rowid);
       return redirect()->route('sepet')
       ->with('mesaj_tur','info')
        ->with('mesaj','Ürün Sepetten Silindi');
    }

    public function bosalt(){

        if (auth()->check()) {
            $aktif_sepet_id = session('aktif_sepet_id');
            SepetUrun::where('sepet_id',$aktif_sepet_id)->Delete();
        }

        Cart::destroy();
        return redirect()->route('sepet')
        ->with('mesaj_tur','warning')
         ->with('mesaj','Sepet Temizlendi.');
     }
     
    public function guncelle($rowid){
        $validator = Validator::make(request()->all(),[
            'adet'=>'required|numeric|between:0,5'
        ]);
        if ($validator->fails()){
        session()->flash('mesaj_tur','danger');
        session()->flash('mesaj','Adet değeri en fazla 5 olabilir.');
        return response()->json(['success'=>false]);
        }

        if (auth()->check()) {
            $aktif_sepet_id = session('aktif_sepet_id');
            $cartItem = Cart::get($rowid);

            if(request('adet')==0)
            SepetUrun::where('sepet_id',$aktif_sepet_id)->where('urun_id', $cartItem->id)->delete();
            else
            SepetUrun::where('sepet_id',$aktif_sepet_id)->where('urun_id', $cartItem->id)->update(['adet'=> request('adet')]);
        }

        Cart::update($rowid,request('adet'));
        
        session()->flash('mesaj_tur','success');
        session()->flash('mesaj','Sepet adet güncellendi.');

        return response()->json(['success'=>true]);
     }

}

/* 
php artisan jwt:secret
php artisan cache:clear
php artisan config:cache
*/