<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Siparis;

class SiparisController extends Controller
{
    //
    public function index(){
       
        $siparisler = Siparis::with('sepet')->orderByDesc('created_at')->get();
        return view('siparisler',compact('siparisler'));
    }

    public function detay($id)
    {
        return view('siparis');
    }

}
