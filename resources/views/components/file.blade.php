<div class="file-upload">
    <div class="i-file-upload">
        <span>{{$placeholder}}</span>
        <input type="file" class="file-upload" id="files" name="{{$name}}" {{$attributes }}/>
        <x-validation-error field="{{$name}}"/>
    </div>
    <span class="filesize"></span>
    @if($value)

        <span class="selectedFiles">
        <img width="150" src="{{$value->thumb}}" alt="">
    </span>
    @else
        <span class="selectedFiles">فایلی انتخاب نشده است</span>
    @endif

</div>