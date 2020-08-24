@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{route('courses.index')}}" title="دوره ها">دوره</a></li>
    <li><a href="#" title="ویرایش دوره">ویرایش دوره</a></li>
@endsection

@section('content')
    <div class="row no-gutters  ">
        <div class="col-12 bg-white">
            <p class="box__title">بروز رسانی دوره </p>
            <form action="{{route('courses.update', $course->id)}}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <x-input type="text" name="title" placeholder="عنوان دوره" required value="{{$course->title}}"/>

                <x-input type="text" name="slug" class="text-left " placeholder="نام انگلیسی دوره" required value="{{$course->title}}"/>

                <div class="d-flex multi-text">
                    <x-input type="text" name="priority" class="text-left mlg-15" placeholder="ردیف دوره" value="{{$course->priority}}"/>
                    <x-input type="text" name="price" placeholder="مبلغ دوره" class="text-left mlg-15" required value="{{$course->price}}"/>
                    <x-input type="number" name="percent" placeholder="درصد مدرس" class="text-left" required value="{{$course->percent}}"/>
                </div>

                <x-select name="teacher_id" required>
                    <option value="">انتخاب مدرس دوره</option>
                    @foreach($teachers as $teacher)
                        <option value="{{$teacher->id}}" @if($teacher->id == $course->teacher_id) selected @endif >{{$teacher->name}}</option>
                    @endforeach
                </x-select>

                <x-tag-select name="tags"/>

                <x-select name="type" required>
                    <option value="">نوع دوره</option>
                    @foreach(\Bido\Course\Models\Course::$types as $type)
                        <option value="{{$type}}" @if($type == $course->type) selected @endif >@Lang($type)</option>
                    @endforeach
                </x-select>

                <x-select name="status" required>
                    <option value="">وضعیت دوره</option>
                    @foreach(\Bido\Course\Models\Course::$statuses as $status)
                        <option value="{{$status}}" @if($status == $course->status) selected @endif >@Lang($status)</option>
                    @endforeach
                </x-select>

                <x-select name="category_id" required>
                    <option value="">دسته بندی</option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}" @if($category->id == $course->category_id) selected @endif >{{$category->title}}</option>
                    @endforeach
                </x-select>

                <x-file placeholder="آپلود بنر دوره" name="image" :value="$course->banner" />

                <x-text-area placeholder="توضیحات دوره" name="body" value="{{$course->body}}"/>
                <button class="btn btn-webamooz_net">بروزرسانی دوره</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="/panel/js/tagsInput.js?v=19}"></script>
@endsection