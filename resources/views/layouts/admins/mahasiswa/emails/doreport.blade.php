@component('mail::message')
  {{ $who }} | {{$email}},<br>

  {{$what}}
@endcomponent
