@extends('yonetim.layouts.master')
@section('title',"Kullanici Yönetimi")
@section('content')


<h1 class="sub-header">
    <div class="btn-group pull-right">
        <a href="{{ route('yonetim.kullanici.yeni') }}" class="btn btn-primary">Yeni</a>
    </div>
    Kullanıcılar
</h1>
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
</div>


@endsection