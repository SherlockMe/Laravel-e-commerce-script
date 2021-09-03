<?php

namespace App\Http\Controllers\Yonetim;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use App\Models\Kullanici;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class KullaniciController extends Controller
{
    //
    public function oturumac(){
        
        if (request()->isMethod('POST')){

        $this->validate(request(), [
            'email'=> 'required|email',
            'sifre'=> 'required'
        ]);

        $credentials = [ 
            'email'=> request()->get('email'),
            'password'=> request()->get('sifre'),
            'yonetici_mi'=> 1
        ];

        if (Auth::guard('yonetim')->attempt($credentials, request()->has('benihatirla')))
        {

            return redirect()->route('yonetim.anasayfa');

        }
        else{
            return back()->withInput()->withErrors(['email'=>'Giriş Hatalı']);
        }
    }
    return view("yonetim.oturumac");
    }
    

    public function oturumukapat(){
        auth::guard('yonetim')->logout();
        request()->session()->flush();
        request()->session()->regenerate();
        return redirect()->route('yonetim.oturumac');
    }

    public function index(){
        $list = Kullanici::orderByDesc('created_at')->paginate(8);
        return view('yonetim.kullanici.index',compact('list'));
    }

    public function form(Request $request){

        if ($request->is('yonetim/kullanici/duzenle/*')) {

            $entry = Kullanici::findOrFail($request->id);
            return view('yonetim.kullanici.form', compact('entry'));

        }
        else if($request->is('yonetim/kullanici/yeni')){
            $entry = new Kullanici;
            return view('yonetim.kullanici.form', compact('entry'));
        }
        
    }


    public function kaydet($id = 0){

        $this->validate(request(), [
            'adsoyad' => 'required',
            'email' => 'required|email'
        ]);

        $data = request()->only('adsoyad','email');

        if (request()->Filled('sifre')) {
            $data['sifre'] = Hash::make(request('sifre'));
        }
        $data['aktif_mi'] = request()->has('aktif_mi') ? 1 : 0;
        $data['yonetici_mi'] = request()->has('yonetici_mi') ? 1 : 0;

        if ($id > 0) {
            $entry = Kullanici::where('id', $id)->firstorfail();
            $entry->update($data); 
        }
        else{
             $entry = Kullanici::create($data);
        }
        return redirect()
        ->route('yonetim.kullanici.duzenle', $entry->id)
        ->with('mesaj', ($id > 0 ? 'Guncellendi' : 'Kaydedildi'))
        ->with('mesaj_tur', 'success');

    }

    public function sil(){
    }

}
