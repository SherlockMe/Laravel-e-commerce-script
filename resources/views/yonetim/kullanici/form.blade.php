@extends('yonetim.layouts.master')
@section('title',"Kullanici Yönetimi Form")
@section('content')


<h1 class="sub-header">Kullanici Yönetimi</h1>
                <form method="POST" action="{{ route('yonetim.kullanici.kaydet', $entry->id) }}">
                {{ csrf_field() }}

                    <div class="pull-right">
                    <button type="submit" class="btn btn-primary">
                        {{ @$entry->id > 0 ? "Güncelle" : "Kaydet" }}
                        </button>
                    </div>

                    <h2 class="sub-header">
                        {{ @$entry->id > 0 ? "Düzenle" : "Ekle" }}
                    </h2>

                    <div class="pull-left">
                        @include('layouts.partials.errors')
                        @include('layouts.partials.alert')
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="adsoyad">Ad Soyad</label>
                                <input type="text" class="form-control" id="adsoyad" name="adsoyad" placeholder="adsoyad" value="{{ old('adsoyad', $entry->adsoyad) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email', $entry->email) }}">
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sifre">Şifre</label>
                                <input type="password" class="form-control" id="sifre" name="sifre" placeholder="sifre">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="adres">Adres</label>
                                <input type="text" class="form-control" id="adres" name="adres" placeholder="adres" value="{{ $entry->detay->adres }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="telefon">Telefon</label>
                                <input type="text" class="form-control" id="telefon" name="telefon" placeholder="Telefon" value="{{ $entry->detay->telefon }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="ceptelefonu">Cep Telefon</label>
                                <input type="text" class="form-control" id="ceptelefonu" name="ceptelefonu" placeholder="Cep Telefon" value="{{ $entry->detay->ceptelefonu }}">
                            </div>
                        </div>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="aktif_mi" value="1" {{ @$entry->aktif_mi > 0 ? "checked" : ""}}> Aktif Mi
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="yonetici_mi" value="1" {{ @$entry->yonetici_mi > 0 ? "checked" : ""}}> Yönetici Mi
                        </label>
                    </div>
                    
                </form>


@endsection
