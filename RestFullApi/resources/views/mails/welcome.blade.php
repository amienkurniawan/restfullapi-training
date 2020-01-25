Hello, {{$user->name}}
Please verify this account by click this link :
{{Route('verify',$user->verification_token)}}