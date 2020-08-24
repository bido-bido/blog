@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{route('categories.index')}}" title="دسته بندی ها">دسته بندی</a></li>
    <li><a href="#" title="ویرایش دسته بندی">ویرایش دسته بندی</a></li>
@endsection

@section('content')
    <div class="row no-gutters  ">
        <div class="col-4 bg-white">
            <p class="box__title">بروز رسانی دسته بندی </p>
            <form action="{{route('categories.update', $category->id)}}" method="post" class="padding-30">
                @csrf
                @method('patch')
                <input type="text" name="title" required placeholder="نام دسته بندی" class="text" value="{{$category->title}}">
                @error('title')
                <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
                @enderror

                <input type="text" name="slug" required placeholder="نام انگلیسی دسته بندی" class="text" value="{{$category->slug}}">
                @error('slug')
                <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
                @enderror

                <p class="box__title margin-bottom-15">انتخاب دسته پدر</p>
                @error('parent_id')
                <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
                @enderror
                <select name="parent_id" id="parent_id">
                    <option value="">ندارد</option>
                    @foreach($categories as $categoryItem)
                        <option value="{{$categoryItem->id}}" @if($categoryItem->id == $category->parent_id) selected @endif>{{$categoryItem->title}}</option>
                    @endforeach
                </select>
                <button class="btn btn-webamooz_net">بروز رسانی</button>
            </form>
        </div>
    </div>
@endsection