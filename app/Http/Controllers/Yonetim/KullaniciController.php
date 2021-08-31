<?php

namespace App\Http\Controllers\Yonetim;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KullaniciController extends Controller
{
    //
    public function oturumac(){
        return view("yonetim.oturumac");
    }

    public function giris(){

        $this->validate(request(), [
            'email'=> 'required|email',
            'sifre'=> 'required'
        ]);
        
        if(auth()->attempt(['email' => request('email'), 'password' => request('sifre')], request()->has('benihatirla'))){
            request()->session()->regenerate();

            return redirect()->intended('/');
        }
        else{
            $errors = ['email'=>'hatalı giriş'];
            return back()->withErrors($errors);
        }

        return view('yonetim.oturumac');
    }



}
