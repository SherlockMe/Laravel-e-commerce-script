{{config('app.name')}}<br>
{{ $kullanici->adsoyad }} Kaydınız Başarıyla Oluşturuldu

<br>

Lütfen aktivasyon işlemini tamamlamak için <a href="{{ config('app_url')}}/kullanici/aktiflestir/{{ $kullanici->aktivasyon_anahtari}}">Link</a> tıklayınız.