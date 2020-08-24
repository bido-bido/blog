<?php

namespace Bido\Course\Http\Controllers;

use Bido\Course\Models\Course;
use App\Http\Controllers\Controller;
use Bido\User\Repositories\UserRepo;
use Bido\Course\Repositories\CourseRepo;
use Bido\Media\Services\MediaFileService;
use Bido\Category\Responses\AjaxResponses;
use Bido\Category\Repositories\CategoryRepo;
use Bido\Course\Http\Requests\CourseRequest;

class CourseController extends Controller
{
    public function index(CourseRepo $courseRepo)
    {
        $courses = $courseRepo->paginate();
        return view('Courses::index', compact('courses'));
    }

    public function create(UserRepo $userRpo, CategoryRepo $categoryRepo)
    {

        $teachers = $userRpo->getTeachers();
        $categories = $categoryRepo->all();

        return view('Courses::create', compact('teachers', 'categories'));
    }

    public function store(CourseRequest $request, CourseRepo $courseRepo)
    {
        $request->request->add(['banner_id'=>MediaFileService::upload($request->file('image'))->id]);
        $course = $courseRepo->store($request);

        return redirect()->route('courses.index');
    }

    public function edit($id, CourseRepo $courseRepo, UserRepo $userRepo, CategoryRepo $categoryRepo)
    {
        $course = $courseRepo->findById($id);
        $teachers = $userRepo->getTeachers();
        $categories = $categoryRepo->all();

        return view('Courses::edit', compact('course', 'teachers', 'categories'));
    }

    public function update($id, CourseRequest $request, CourseRepo $courseRepo)
    {
        $course = $courseRepo->findById($id);
        if($request->hasFile('image')){
            $request->request->add(['banner_id'=>MediaFileService::upload($request->file('image'))->id]);
            if($course->banner){
                $course->banner->delete();
            }
        }else{
            $request->request->add(['banner_id'=>$course->banner_id]);
        }
        $courseRepo->update($id, $request);
        return redirect()->route('courses.index');
    }

    public function destroy($id, CourseRepo $courseRepo)
    {
        $course = $courseRepo->findById($id);
        if($course->banner){
            $course->banner->delete();
        }

        $course->delete();

        return AjaxResponses::successResponse();
    }

    public function accept($id, CourseRepo $courseRepo)
    {
        if($courseRepo->updateConfirmationStatus($id, Course::CONFIRMATION_STATUS_ACCEPTED)){
            return AjaxResponses::successResponse();
        }

        return AjaxResponses::failResponse();
    }

    public function reject($id, CourseRepo $courseRepo)
    {
        if($courseRepo->updateConfirmationStatus($id, Course::CONFIRMATION_STATUS_REJECTED)){
            return AjaxResponses::successResponse();
        }

        return AjaxResponses::failResponse();
    }

    public function lock($id, CourseRepo $courseRepo)
    {
        if($courseRepo->updateStatus($id, Course::STATUS_LOCKED)){
            return AjaxResponses::successResponse();
        }

        return AjaxResponses::failResponse();
    }
}