<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UserRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Interfaces\UserInterface;

class UserController extends Controller
{
    protected UserInterface $user;

    /**
     * Constructor.
     *
     * @param UserInterface $user
     */
    function __construct(UserInterface $user)
    {
        $this->user = $user;

        $this->middleware('permission:users-list',  ['only' => ['index']]);
        $this->middleware('permission:users-view',  ['only' => ['show']]);
        $this->middleware('permission:users-create',['only' => ['create','store']]);
        $this->middleware('permission:users-edit',  ['only' => ['edit','update']]);
        $this->middleware('permission:users-delete',['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $pagination_mode = $request->input('pagination_mode','client');
        if($pagination_mode == 'client'){
            $users = $this->user->all();
            return view('admin.user.index', compact('users'));
        }
        $users = $this->user->paginate();

        return view('admin.user.index', compact('users'))
            ->with('i', ($request->input('page', 1) - 1) * $users->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $user = new User();

        return view('admin.user.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request): RedirectResponse
    {
        $this->user->create($request->validated());

        return Redirect::route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $user = $this->user->find($id);

        return view('admin.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $user = $this->user->find($id);

        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $this->user->update($user, $request->validated());

        return Redirect::route('users.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        $this->user->delete($id);

        return Redirect::route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
