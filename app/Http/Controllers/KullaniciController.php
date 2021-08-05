<?php

namespace App\Http\Controllers;

use App\Models\Kullanici;
use App\Models\Sepet;
use App\Models\SepetUrun;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Mail\KullaniciKayitMail;
use Mail;

class KullaniciController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('guest')->except('oturumkapat');
    }

    public function giris_form(){
        return view('kullanici.oturumac');
    }

    public function giris(){

        $this->validate(request(), [
            'email'=> 'required|email',
            'sifre'=> 'required'
        ]);

        if(auth()->attempt(['email' => request('email'), 'password' => request('sifre')], request()->has('benihatirla'))){
            request()->session()->regenerate();

            $aktif_sepet_id = Sepet::aktif_sepet_id();
            if (is_null($aktif_sepet_id))
            {
                $aktif_sepet = Sepet::create(['kullanici_id'=>auth()->id()]);
                $aktif_sepet_id = $aktif_sepet->id;
            }
           /* dd($aktif_sepet_id);
            */
            session()->put('aktif_sepet_id', $aktif_sepet_id);

            if (Cart::count()>0) { /* sessionda varsa veritabanına ekle yoksa ekle session veritabanı eşitlendi*/
            foreach(Cart::content() as $cartItem)
            {
                SepetUrun::updateOrCreate(
                    ['sepet_id'=> $aktif_sepet_id, 'urun_id'=>$cartItem->id],
                    ['adet'=> $cartItem->qty, 'fiyati'=> $cartItem->price, 'durum'=>'Beklemede']
                );
            }
            }
            
            Cart::destroy();/*sepeti temizle*/
            $sepetUrunler = SepetUrun::where('sepet_id', $aktif_sepet_id)->get(); /*sepeti session id ile veritabanından verileri cek*/
            foreach($sepetUrunler as $sepetUrun)
            {
                Cart::add($sepetUrun->urun->id, $sepetUrun->urun->urun_adi, $sepetUrun->adet, $sepetUrun->urun->fiyat, ['slug' => $sepetUrun->urun->slug]);
            }


            return redirect()->intended('/'); /* kaldiği yerden devam ediyor*/ 
        }
        else{
            $errors = ['email'=>'hatalı giriş'];
            return back()->withErrors($errors);
        }

        return view('kullanici.oturumac');
    }

    public function kaydol_form(){
        return view('kullanici.kaydol');
    }

    public function kaydol(){
        $this->validate(request(), [
            'adsoyad'=>'required|min:5|max:60',
            'email'=> 'required|email|unique:kullanici',
            'sifre'=> 'required|confirmed|min:5|max:15'
        ]);

        $kullanici = Kullanici::create([
            'adsoyad'=> request('adsoyad'),
            'email'=> request('email'),
            'sifre'=> Hash::make(request('sifre')),
            'aktivasyon_anahtari'=> Str::random(60),
            'aktif_mi'=> 0
        ]);

        $kullanici->detay()->save(new KullaniciDetay());

        Mail::to(request('email'))->send(new KullaniciKayitMail($kullanici));
    
        Auth()->login($kullanici);
        return redirect()->route('anasayfa');
    }

    public function aktiflestir($anahtar){
        $kullanici = Kullanici::where('aktivasyon_anahtari', $anahtar)->first();
        if(!is_null($kullanici)){
            $kullanici->aktivasyon_anahtari=null;
            $kullanici->aktif_mi=1;
            $kullanici->save();
            return redirect()->to('/')
            ->with('mesaj','Kullanıcı Hesabınız Aktifleştirildi')
            ->with('mesaj_tur','success');
        }
        else{
            return redirect()->to('/')
            ->with('mesaj','Kullanıcı kaydınız aktifleştirilemedi')
            ->with('mesaj_tur','warning');
        }
    }

    public function oturumkapat(){

        auth()->logout();
        request()->session()->flush();
        request()->session()->regenerate();
        return redirect()->route('anasayfa');
    }


}
