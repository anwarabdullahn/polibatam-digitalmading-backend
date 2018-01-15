@component('mail::message')
  Hello  #{{ $name }} | {{$nim}},<br>

  Please verify your email by tapping this button below. A verified email will make it easier for us to contact you.

  @component('mail::button', ['url' => $url, 'color' => 'blue'])
    Verify Now
  @endcomponent

  If the above button doesn't work for you, please click on the below link or copy paste it on to your browser

  {{ $url }}

  This email has been generated automatically, please do not reply.<br>
  Thanks, {{ config('app.name') }}
@endcomponent
