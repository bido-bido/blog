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
                <x-input type="text" name="telegram" class="text-left " placeholder="تلگرام" value="{{$user->telegram}}"/>

                <x-select name="status" required>
                    <option value="">وضعیت حساب</option>
                    @foreach(\Bido\User\Models\User::$statuses as $status)
                        <option value="{{$status}}" @if($status == $user->status) selected @endif >@Lang($status)</option>
                    @endforeach
                </x-select>

                <x-select name="role" >
                    <option value="">یک نقش کاربری انتخاب کنید</option>
                    @foreach($roles as $role)
                        <option value="{{$role->name}}" {{$user->hasRole($role->name) ? 'selected': ''}} >@Lang($role->name)</option>
                    @endforeach
                </x-select>


                <x-file placeholder="آپلود بنر کاربر" name="image" :value="$user->image" />
                <x-input type="password" name="password" class="text-left " placeholder="پسورد جدید" value=""/>

                <x-text-area placeholder="بیو" name="bio" value="{{$user->bio}}"/>
                <button class="btn btn-webamooz_net">بروزرسانی کاربر</button>
            </form>
        </div>
    </div>

    <div class="main-content font-size-13">
        <div class="row no-gutters bg-white margin-bottom-20">
            <div class="col-12">
                <p class="box__title">ایجاد کاربر</p>
                <form action="" class="padding-30" method="post">
                    <input type="text" class="text" placeholder="نام و نام خانوادگی">
                    <input type="text" class="text" placeholder="ایمیل">
                    <input type="text" class="text" placeholder="شماره موبایل">
                    <input type="text" class="text" placeholder="آی پی">
                    <select name="" id="">
                        <option value="0">سطح کاربری</option>
                        <option value="1">کاربر عادی</option>
                        <option value="2">مدرس</option>
                        <option value="3">نویسنده</option>
                        <option value="4">مدیر</option>
                    </select>
                    <button class="btn btn-webamooz_net">ایجاد کاربر</button>
                </form>

            </div>
        </div>
        <div class="row no-gutters">
            <div class="col-6 margin-left-10 margin-bottom-20">
                <p class="box__title">درحال یادگیری</p>
                <div class="table__box">
                    <table class="table">
                        <thead role="rowgroup">
                        <tr role="row" class="title-row">
                            <th>شناسه</th>
                            <th>نام دوره</th>
                            <th>نام مدرس</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr role="row" class="">
                            <td><a href="">1</a></td>
                            <td><a href="">دوره لاراول</a></td>
                            <td><a href="">صیاد اعظمی</a></td>
                        </tr>
                        <tr role="row" class="">
                            <td><a href="">1</a></td>
                            <td><a href="">دوره لاراول</a></td>
                            <td><a href="">صیاد اعظمی</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-6 margin-bottom-20">
                <p class="box__title">دوره های مدرس</p>
                <div class="table__box">
                    <table class="table">
                        <thead role="rowgroup">
                        <tr role="row" class="title-row">
                            <th>شناسه</th>
                            <th>نام دوره</th>
                            <th>نام مدرس</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($user->courses as $course)
                            <tr role="row" class="">
                                <td><a href="">{{$course->id}}</a></td>
                                <td><a href="">{{$course->title}}</a></td>
                                <td><a href="">{{$course->teacher->name}}</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="/panel/js/tagsInput.js?v=19}"></script>
    <script>
        @include('Common::layouts.feedbacks')
    </script>
@endsection