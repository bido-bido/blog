<?php

namespace Bido\Category\Http\Controllers;

use Illuminate\Http\Response;
use Bido\Category\Models\Category;
use App\Http\Controllers\Controller;
use Bido\Category\Responses\AjaxResponses;
use Bido\Category\Repositories\CategoryRepo;
use Bido\Category\Http\Requests\CourseRequest;
use Bido\Category\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    private $repo;

    public function __construct(CategoryRepo $categoryRepo)
    {
        $this->repo = $categoryRepo;
    }

    public function index()
    {
        $categories = $this->repo->all();

        return view('Categories::index', compact('categories'));
    }

    public function store(CategoryRequest $request)
    {
        $this->repo->store($request);
        return back();
    }

    public function edit($categoryId)
    {
        $category = $this->repo->findById($categoryId);

        $categories = $this->repo->allExceptById($categoryId);

        return view('Categories::edit', compact('category', 'categories'));
    }

    public function update(CategoryRequest $request, $categoryId)
    {
        $this->repo->update($categoryId, $request);

        return back();
    }

    public function destroy($categoryId)
    {
        $this->repo->delete($categoryId);

        return AjaxResponses::successResponse();
    }
}