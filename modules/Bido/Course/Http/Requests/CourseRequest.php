<?php

namespace Bido\Course\Http\Requests;

use Bido\Course\Models\Course;
use Illuminate\Validation\Rule;
use Bido\Course\Rules\ValidTeacher;
use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() == true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rule =  [
            'title' => 'required|min:3|max:190',
            'slug' => 'required|min:3|max:190|unique:courses,slug',
            'priority' => 'nullable|numeric',
            'price' => 'required|numeric|min:0|max:10000000',
            'percent' => 'required|numeric|min:0|max:100',
            'teacher_id'=>['required','exists:users,id', new ValidTeacher()],
            'type'=>['required', Rule::in(Course::$types)],
            'status'=>['required', Rule::in(Course::$statuses)],
            "category_id" => "required|exists:categories,id",
            "image" => "required|mimes:jpg,png,jpeg",

        ];

        if(request()->method == 'PATCH'){
            $rule["image"] = "nullable|mimes:jpg,png,jpeg";
            $rule["slug"] = "required|min:3|max:190|unique:courses,slug,".request()->route('course');
        }

        return $rule;

    }
    public function attributes()
    {
        return [
            "price" => "قیمت",
            "slug" => "عنوان انگلیسی",
            "priority" => "ردیف دوره",
            "percent" => "درصد مدرس",
            "teacher_id" => "مدرس",
            "category_id" => "دسته بندی",
            "status" => "وضعیت",
            "type" => "نوع",
            "body" => "توضیحات",
            "image" => "بنر دوره",
        ];
    }

    public function messages()
    {
        return [];
    }
}
