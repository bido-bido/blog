@extends('User::Front.master')

@section('content')
    <form  action="{{ route('verification.resend') }}" class="form" method="POST">
        <a class="account-logo" href="index.html">
            <img src="/img/weblogo.png" alt="">
        </a>

        @csrf

        <div class="form-content form-account">
            @if (session('resent'))
                <div class="card-header" role="alert">
                    یک ایمیل تایید ایمیل جدید به ایمیلتان ارسال شد
                </div>
            @endif

            قبل از ادامه لطفا ایمیلتان را چک کنید.
            اگر ایمیلی دریافت نکرده اید درخواست ارسال مجدد فرم بدهید.

            <div class="center">
                <button type="submit" class="btn i-t">ارسال مجدد لینک تایید</button>
                <a href="/">بازگشت به صفحه اصلی</a>
            </div>
        </div>
    </form>
    <div class="form-footer">
        <a href="login.html">صفحه ثبت نام</a>
    </div>
@endsection