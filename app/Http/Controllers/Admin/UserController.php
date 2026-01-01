<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    protected UserRepository $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->middleware('permission:users-list',  ['only' => ['index']]);
        $this->middleware('permission:users-view',  ['only' => ['show']]);
        $this->middleware('permission:users-create',['only' => ['create','store']]);
        $this->middleware('permission:users-edit',  ['only' => ['edit','update']]);
        $this->middleware('permission:users-delete',['only' => ['destroy']]);

        $this->userRepo = $userRepo;
    }

    public function index(Request $request)
    {
        $pagination_mode = $request->input('pagination_mode','client');
        if($pagination_mode == 'client'){
            $request->merge([
                'with' => ['roles', 'media'],
            ]);
            $users = $this->userRepo->all();
            return view('admin.users.index', compact('users'));
        }
        $users = $this->userRepo->paginate();

        return view('admin.users.index', compact('users'))
            ->with('i', ($request->input('page', 1) - 1) * $users->perPage());
    }

    public function create()
    {
        $user = $this->userRepo->new(); // empty model instance
        return view('admin.users.create', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required',
            'email'            => 'required|email|unique:users,email',
            'password'         => 'required|same:confirm_password',
            'confirm_password' => 'required|same:password',
            'roles'            => 'required',
        ]);

        $this->userRepo->create($request->all());

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    public function show($id)
    {
        $user = $this->userRepo->find($id);
        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user     = $this->userRepo->find($id);
        $userRole = $user->roles->pluck('name', 'id')->all();
        return view('admin.users.edit', compact('user', 'userRole'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,' . $id,
            'roles'    => 'required|array',
            'roles.*'  => 'integer|exists:roles,id'
        ]);

        $this->userRepo->update($id, $request->all());

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        if (! $this->userRepo->safeDelete($id, auth()->id())) {
            return redirect()->back()->with('warning', 'You cannot delete this user.');
        }

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

    public function profileEdit()
    {
        return view('admin.users.profile');
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name'             => 'required',
            'email'            => 'required|email|unique:users,email,' . auth()->id(),
            'old_password'     => 'nullable|required_with:new_password',
            'new_password'     => 'nullable|min:8|max:12',
            'confirm_password' => 'nullable|min:8|max:12|required_with:new_password|same:new_password',
        ]);
        $this->userRepo->update(auth()->id(), $request->all());

        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    public function checkEmail(Request $request)
    {
        $available = $this->userRepo->isEmailAvailable($request->email, $request->id ?? null);
        echo $available ? "true" : "false";
    }

    public function checkPassword(Request $request)
    {
        $valid = $this->userRepo->verifyPassword($request->id, $request->old_password);
        echo $valid ? "true" : "false";
    }
}
