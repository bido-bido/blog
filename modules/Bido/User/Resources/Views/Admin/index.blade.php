@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{route('categories.index')}}" title="دسته بندی ها">دسته بندی</a></li>
@endsection

@section('content')
    <div class="row no-gutters  ">
        <div class="col-12 margin-left-10 margin-bottom-15 border-radius-3">
            <p class="box__title">دسته بندی ها</p>
            <div class="table__box">
                <table class="table">
                    <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th>شناسه</th>
                        <th>نام و نام خانوادگی</th>
                        <th>ایمیل</th>
                        <th>شماره موبایل</th>
                        <th>سطح کاربری</th>
                        <th>تاریخ عضویت</th>
                        <th>آی پی</th>
                        <th>وضعیت حساب</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr role="row" class="">
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->mobile}}</td>
                            <td>
                                <ul>
                                    @foreach($user->roles as $userRole)
                                        <li>@lang($userRole->name)</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{$user->created_at}}</td>
                            <td>{{$user->ip}}</td>
                            <td class="confirmation_status" >{!! $user->hasVerifiedEmail()? "<span class='text-success'>تایید شده</span>": "<span class='text-error' >تایید نشده</span>"!!}</td>
                            <td>
                                <a href="" onclick="deleteItem(event, '{{route('users.destroy', $user->id)}}')"
                                   class="item-delete mlg-15" title="حذف"></a>
                                <a href="" onclick=" updateConfirmationStatus(event,'{{route('users.manualVerify', $user->id)}}', 'آیا از تایید این آیتم اطمینان دارید؟', 'تایید شده')" class="item-confirm mlg-15" title="تایید"></a>
                                <a href="{{route('users.edit', $user->id)}}" class="item-edit" title="ویرایش"></a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        @include('Common::layouts.feedbacks')
    </script>
@endsection


