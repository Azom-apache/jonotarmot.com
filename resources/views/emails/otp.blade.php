<x-mail::message>
    # OTP Mail

    Your OTP is: {{ $otp }}

    This OTP is valid for a limited time. Please do not share it with anyone.

    Thanks,
    {{ config('app.name') }}
</x-mail::message>
