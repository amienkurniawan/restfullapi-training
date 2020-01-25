Hello, {{$user->name}}
You Change Your Email Account, Please verify this account by click this link :
{{Route('verify',$user->verification_token)}}