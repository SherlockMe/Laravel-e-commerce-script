<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //php artisan make:seeder
        DB::table('kategori')->truncate();

        $id = DB::table('kategori')->insertGetId(['kategori_adi'=>'Elektronik','slug'=>'Elektronik']);
        DB::table('kategori')->insert(['kategori_adi'=>'Bilgisayar Tablet','slug'=>'bilgisayar-tablet','ust_id'=>$id]);
        DB::table('kategori')->insert(['kategori_adi'=>'Telefon','slug'=>'telefon','ust_id'=>$id]);
        DB::table('kategori')->insert(['kategori_adi'=>'Tv Sistemleri','slug'=>'tv','ust_id'=>$id]);
        
        $id = DB::table('kategori')->insertGetId(['kategori_adi'=>'Kitap','slug'=>'Kitap']);
        DB::table('kategori')->insert(['kategori_adi'=>'Roman','slug'=>'roman','ust_id'=>$id]);
        DB::table('kategori')->insert(['kategori_adi'=>'Aşk','slug'=>'ask','ust_id'=>$id]);
        DB::table('kategori')->insert(['kategori_adi'=>'Masal','slug'=>'masal','ust_id'=>$id]);

        $id = DB::table('kategori')->insertGetId(['kategori_adi'=>'Mobilya','slug'=>'Mobilya']);
        DB::table('kategori')->insert(['kategori_adi'=>'Masa Takımı','slug'=>'masa','ust_id'=>$id]);
        DB::table('kategori')->insert(['kategori_adi'=>'Koltuk Takımı','slug'=>'koltuk','ust_id'=>$id]);
        DB::table('kategori')->insert(['kategori_adi'=>'Dolap','slug'=>'dolap','ust_id'=>$id]);


        DB::table('kategori')->insert(['kategori_adi'=>'Dergi','slug'=>'Dergi']);

        DB::table('kategori')->insert(['kategori_adi'=>'Kozmetik','slug'=>'Kozmetik']);

        DB::table('kategori')->insert(['kategori_adi'=>'Giyim','slug'=>'Giyim']);

        DB::table('kategori')->insert(['kategori_adi'=>'Bakım','slug'=>'Bakım']);
    }
}
