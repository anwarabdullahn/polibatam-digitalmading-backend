@component('mail::message')

    {{$title}}.<br>

    Kategori {{$category}}

    {{$description}}

  Untuk info lebih lanjut silahkan lihat pada aplikasi "Digital Mading".

  This email has been generated automatically, please do not reply.<br>
  Thanks, {{ config('app.name') }}
@endcomponent
