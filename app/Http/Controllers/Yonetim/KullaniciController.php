<?php

namespace App\Http\Controllers\Yonetim;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Kullanici;

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

    public function form(){
    }
    public function kaydet(){
    }
    public function sil(){
    }
}
