@component('mail::message')
# Atur Ulang Kata Sandi?<br>

Hai {{ $fullName }},<br>
Jika anda meminta pengaturan ulang kata sandi, klik tombol di bawah ini, atau abaikan jika anda tidak merasa mengajukan permintaan ini.

@component('mail::button', ['url' => $url, 'color' => 'blue'])
Atur Ulang Kata Sandi
@endcomponent

atau salin link berikut pada perambah anda :

{{ $url }}

Terimakasih telah menggunakan<br>
{{ config('app.name') }}
@endcomponent
