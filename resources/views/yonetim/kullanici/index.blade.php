@extends('yonetim.layouts.master')
@section('title',"Kullanici Yönetimi")
@section('content')


<h3 class="sub-header">Kullanıcılar</h3>
<div class="well">
    <div class="btn-group pull-right">
        <a href="{{ route('yonetim.kullanici.yeni') }}" class="btn btn-primary">Yeni</a>
    </div>
    <form method="POST" action="{{ route('yonetim.kullanici') }}" class="form-inline">
        {{ csrf_field() }}
        <div class="form-group">
        <label for="aranan">Ara</label>
        <input type="text" class="form-control form-control-sm" name="aranan" id="aranan" placeholder="Ad email ara" value="{{ old('aranan')}}">
        </div>
        <button type="submit" class="btn btn-primary">ara</button>
        <a href="{{ route('yonetim.kullanici')}}" class="btn btn-primary">Temizle</a>
    </form>
</div>
    
 @include('layouts.partials.alert')
<div class="table-responsive">
    <table class="table table-hover table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Adsoyad</th>
                <th>Email</th>
                <th>Aktif mi</th>
                <th>Yönetici mi</th>
                <th>Kayıt Tarihi</th>
                <th>Düzenle</th>
            </tr>
        </thead>
        <tbody>
            
                @foreach ($list as $item)
                <tr>
                <td>{{ $item->id}}</td>
                <td>{{ $item->adsoyad}}</td>
                <td>{{ $item->email}}</td>
                <td>
                @if ($item->aktif_mi)
               <span class="label label-success">Aktif</span>
                @else
               <span class="label label-danger">Pasif</span>
                @endif
                </td>
                <td>
                    @if ($item->yonetici_mi)
                   <span class="label label-success">Yönetici</span>
                    @else
                   <span class="label label-danger">Kullanıcı</span>
                    @endif
                    </td>
                <td>{{ $item->created_at}}</td>

                <td style="width: 100px">
                    <a href="{{ route('yonetim.kullanici.duzenle', $item->id) }}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Tooltip on top">
                        <span class="fa fa-pencil"></span>
                    </a>
                    <a href="{{ route('yonetim.kullanici.sil', $item->id) }}" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Tooltip on top" onclick="return confirm('Kayıt Silinecek emin misiniz?')">
                        <span class="fa fa-trash"></span>
                    </a>
                </td>
            </tr>
                @endforeach
        </tbody>
    </table>
    {{ $list->appends('aranan', old('aranan'))->links() }}
</div>


@endsection