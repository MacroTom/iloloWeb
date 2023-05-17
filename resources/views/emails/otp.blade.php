<x-mail::message>
<p>Hello user,</p>

Please enter the OTP below to reset your password.

<x-mail::panel>
    <h1>{{$data['otp']}}</h1>
</x-mail::panel>

<p><small>This code expires in 10 minutes and should not be shared with anybody.</small></p>

<small>For further assistance, contact us at <a href="mailto:info@ilolo.online">info@ilolo.online</a></small>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
