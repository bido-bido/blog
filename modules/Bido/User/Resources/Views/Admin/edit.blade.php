@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{route('users.index')}}" title="کاربران">کاربران</a></li>
    <li><a href="#" title="ویرایش کاربر">ویرایش کاربر</a></li>
@endsection

@section('content')
    <div class="row no-gutters  ">
        <div class="col-12 bg-white">
            <p class="box__title">بروز رسانی کاربر </p>
            <form action="{{route('users.update', $user->id)}}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <x-input type="text" name="name" placeholder="نام کاربر" required value="{{$user->name}}"/>

                <x-input type="text" name="email" class="text-left " placeholder="ایمیل" required value="{{$user->email}}"/>
                <x-input type="text" name="username" class="text-left " placeholder="نام کاربری" value="{{$user->username}}"/>
                <x-input type="text" name="mobile" class="text-left " placeholder="موبایل" value="{{$user->mobile}}"/>
                <x-input type="text" name="headline" class="text-left " placeholder="عنوان" value="{{$user->headline}}"/>
                <x-input type="text" name="website" class="text-left " placeholder="وب سایت" value="{{$user->website}}"/>
                <x-input type="text" name="linkedin" class="text-left " placeholder="لینکدین" value="{{$user->linkedin}}"/>
                <x-input type="text" name="facebook" class="text-left " placeholder="فیسبوک" value="{{$user->facebook}}"/>
                <x-input type="text" name="twitter" class="text-left " placeholder="توییتر" value="{{$user->twitter}}"/>
                <x-input type="text" name="youtube" class="text-left " placeholder="یوتیوب" value="{{$user->youtube}}"/>
                <x-input type="text" name="instagram" class="text-left " placeholder="اینستاگرام" value="{{$user->instagram}}"/>
                <x-input type="text" name="telegram" class="text-left " placeholder="تلگرام" value="{{$user->telegram}}"/>

                <x-select name="status">
                    <option value="">وضعیت حساب</option>
                    @foreach(\Bido\User\Models\User::$statuses as $status)
                        <option value="{{$status}}" @if($status == $user->status) selected @endif >@Lang($status)</option>
                    @endforeach
                </x-select>


                <x-file placeholder="آپلود بنر کاربر" name="image" :value="$user->image" />
                <x-input type="password" name="password" class="text-left " placeholder="پسورد جدید" value=""/>

                <x-text-area placeholder="بیو" name="bio" value="{{$user->bio}}"/>
                <button class="btn btn-webamooz_net">بروزرسانی کاربر</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="/panel/js/tagsInput.js?v=19}"></script>
    <script>
        @include('Common::layouts.feedbacks')
    </script>
@endsection