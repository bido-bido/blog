@component('mail::message')
# کد فعال سازی شما در وبلاگ

این ایمیل به دلیل ثبت نام شما در وبلاگ ارسال شده است.**در صورتی که ثبت نام توسط شما انجام نشده است**. این ایمیل را نادیده بگیرید.


@component('mail::panel')
کدفعالسازی:{{$code}}
@endcomponent

با تشکر<br>
{{ config('app.name') }}
@endcomponent

