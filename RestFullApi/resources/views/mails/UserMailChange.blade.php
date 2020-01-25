@component('mail::message')
Hello, {{$user->name}}

You Change Your Email Account, Please verify this account by click this button :


@component('mail::button', ['url' => Route('verify',$user->verification_token)])
Verify Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent