<?php

namespace Bido\User\Http\Controllers;

use Bido\User\Models\User;
use App\Http\Controllers\Controller;
use Bido\User\Repositories\UserRepo;
use Bido\User\Http\Requests\AddRoleRequest;
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

    public function addRole(AddRoleRequest $request, User $user)
    {
        $this->authorize('addRole', User::class);
        $user->assignRole($request->role);
        newFeedback('عملیات موفقیت آمیز', "نقش کاربری {$request->role} به کاربر {$user->name} داده شد." , 'success');
        return back();
    }
}