@component('mail::message')
Hello, {{$user->name}}

Please verify this account by click this link :


@component('mail::button', ['url' => Route('verify',$user->verification_token)])
Verify Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent