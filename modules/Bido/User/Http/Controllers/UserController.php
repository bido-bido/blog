<?php

namespace Bido\User\Http\Controllers;

use Bido\User\Models\User;
use App\Http\Controllers\Controller;
use Bido\User\Repositories\UserRepo;
use Bido\Common\Responses\AjaxResponses;
use Bido\Media\Services\MediaFileService;
use Bido\User\Http\Requests\AddRoleRequest;
use Bido\User\Http\Requests\UpdateUserRequest;
use Bido\RolePermissions\Repositories\RoleRepo;

class UserController extends Controller
{
    /**
     * @var \Bido\User\Repositories\UserRepo
     */
    private $userRepo;

    public function __construct(UserRepo $userRepo)
    {

        $this->userRepo = $userRepo;
    }

    public function index(RoleRepo $rolRepo)
    {
        $this->authorize('index', User::class);
        $roles = $rolRepo->all();
        $users = $this->userRepo->paginate();

        return view('User::admin.index', compact('users', 'roles'));
    }

    public function edit($userId, RoleRepo $roleRepo)
    {
        $user = $this->userRepo->findById($userId);
        $roles = $roleRepo->all();
        return view('User::admin.edit' , compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, $userId)
    {
        $this->authorize('edit', User::class);
        $user = $this->userRepo->findById($userId);
        if($request->hasFile('image')){
            $request->request->add(['image_id'=>MediaFileService::upload($request->file('image'))->id]);
            if($user->banner){
                $user->banner->delete();
            }
        }else{
            $request->request->add(['image_id'=>$user->image_id]);
        }
        $this->userRepo->update($userId,$request);

        newFeedback();

        return redirect()->back();
    }

    public function destroy($userId)
    {
        $user = $this->userRepo->findById($userId);
        $user->delete();
        return AjaxResponses::successResponse();
    }

    public function manualVerify($userId)
    {
        $this->authorize('manualVerify', User::class);
        $user = $this->userRepo->findById($userId);
        $user->markEmailAsVerified();
        return AjaxResponses::successResponse();
    }

    public function addRole(AddRoleRequest $request, User $user)
    {
        $this->authorize('addRole', User::class);
        $user->assignRole($request->role);
        newFeedback('عملیات موفقیت آمیز', "نقش کاربری {$request->role} به کاربر {$user->name} داده شد." , 'success');
        return back();
    }

    public function removeRole($userId, $role)
    {
        $this->authorize('removeRole', User::class);
        $user = $this->userRepo->findById($userId);
        $user->removeRole($role);
        return AjaxResponses::successResponse();
    }
}