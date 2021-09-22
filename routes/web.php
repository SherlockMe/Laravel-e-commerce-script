<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['prefix'=>'yonetim', 'namespace'=>'Yonetim'], function () {
    Route::redirect('/','/yonetim/oturumac');

    Route::match(['get', 'post'], '/oturumac', 'KullaniciController@oturumac')->name('yonetim.oturumac');
    Route::get('/oturumkapat','KullaniciController@oturumukapat')->name('yonetim.oturumukapat');

    Route::group(['middleware'=>'yonetim'], function () { //middleware yonetim.php

    Route::get('/anasayfa','AnasayfaController@index')->name('yonetim.anasayfa');

    Route::prefix('kullanici')->group(function () {

    Route::match(['get', 'post'], '/', 'KullaniciController@index')->name('yonetim.kullanici');
    Route::get('/yeni', 'KullaniciController@form')->name('yonetim.kullanici.yeni');
    Route::get('/duzenle/{id}', 'KullaniciController@form')->name('yonetim.kullanici.duzenle');
    Route::post('/kaydet/{id?}', 'KullaniciController@kaydet')->name('yonetim.kullanici.kaydet');
    Route::get('/sil/{id}', 'KullaniciController@sil')->name('yonetim.kullanici.sil');
    
    });


    Route::prefix('kategori')->group(function () {

        Route::match(['get', 'post'], '/', 'KategoriController@index')->name('yonetim.kategori');
        Route::get('/yeni', 'KategoriController@form')->name('yonetim.kategori.yeni');
        Route::get('/duzenle/{id}', 'KategoriController@form')->name('yonetim.kategori.duzenle');
        Route::post('/kaydet/{id?}', 'KategoriController@kaydet')->name('yonetim.kategori.kaydet');
        Route::get('/sil/{id}', 'KategoriController@sil')->name('yonetim.kategori.sil');
        
        });
    
    

    });


});

Route::get('/', 'AnasayfaController@Index')->name('anasayfa');

Route::get('/kategori/{slug_kategoriadi}','KategoriController@index')->name('kategori');
Route::get('/urun/{slug_urunadi}','UrunController@index')->name('urun');

Route::post('/ara','UrunController@ara')->name('urun_ara');
Route::get('/ara','UrunController@ara')->name('urun_ara');

Route::prefix('sepet')->group(function () {
    Route::get('/','SepetController@index')->name('sepet')->middleware('auth');
    Route::post('/ekle','SepetController@ekle')->name('sepet.ekle');
    Route::delete('/kaldir/{rowid}','SepetController@kaldir')->name('sepet.kaldir');
    Route::delete('/bosalt','SepetController@bosalt')->name('sepet.bosalt');
    Route::patch('/guncelle/{rowid}','SepetController@guncelle')->name('sepet.guncelle');
});

Route::group(['middleware'=>'auth'], function () {
Route::get('/siparisler','SiparisController@index')->name('siparisler');
Route::get('/siparisler/{id}','SiparisController@detay')->name('siparis');
});

Route::get('/odeme','OdemeController@index')->name('odeme');

Route::post('/odeme','OdemeController@odemeyap')->name('odemeyap');

Route::prefix('kullanici')->group(function () {
Route::get('/oturumac','KullaniciController@giris_form')->name('kullanici.oturumac');
Route::post('/oturumac','KullaniciController@giris');
Route::get('/kaydol','KullaniciController@kaydol_form')->name('kullanici.kaydol');
Route::post('/kaydol','KullaniciController@kaydol');
Route::get('/aktiflestir/{anahtar}','KullaniciController@aktiflestir')->name('aktiflestir');
Route::post('/oturumkapat','KullaniciController@oturumkapat')->name('kullanici.oturumkapat');
});

Route::get('/test/mail', function(){
    $kullanici = \App\Models\Kullanici::find(1);
    return new App\Mail\KullaniciKayitMail($kullanici);
});
