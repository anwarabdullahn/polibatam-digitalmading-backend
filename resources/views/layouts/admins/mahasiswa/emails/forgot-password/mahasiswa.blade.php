@component('mail::message')
  Hello  #{{ $name }} | {{$nim}},<br>

  You recently requested to reset your password, Click this button below to reset it.

  @component('mail::button', ['url' => $url, 'color' => 'blue'])
    Reset your password
  @endcomponent

  If the above button doesn't work for you, please click on the below link or copy paste it on to your browser

  {{ $url }}

  If you did not request a password reset, please ignore this email or reply to let us know.<br>

  This email has been generated automatically.<br>
  Thanks, {{ config('app.name') }}
@endcomponent
