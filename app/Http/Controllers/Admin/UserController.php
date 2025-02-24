<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:users-list',  ['only' => ['index']]);
        $this->middleware('permission:users-view',  ['only' => ['show']]);
        $this->middleware('permission:users-create',['only' => ['create','store']]);
        $this->middleware('permission:users-edit',  ['only' => ['edit','update']]);
        $this->middleware('permission:users-delete',['only' => ['destroy']]);
    }
    // public static function middleware(): array
    // {
    //     return [
    //         new Middleware('permission:users-list', only: ['index']),
    //         new Middleware('permission:users-view', only: ['show']),
    //         new Middleware('permission:users-create', only: ['create', 'store']),
    //         new Middleware('permission:users-edit', only: ['edit', 'update']),
    //         new Middleware('permission:users-delete', only: ['destroy']),
    //     ];
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $users = User::paginate();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $user = new User();

        return view('admin.users.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required',
            'email'            => 'required|email|unique:users,email',
            'password'         => 'required|same:confirm_password',
            'confirm_password' => 'required|same:password',
            'roles'            => 'required',
        ]);

        $user = User::create($request->all());
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $user     = User::find($id);
        $userRole = $user->roles->pluck('name', 'id')->all();

        return view('admin.users.edit', compact('user', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'same:confirm-password',
            'roles'    => 'required|array',       // Ensure it's an array
            'roles.*'  => 'integer|exists:roles,id' // Ensure each value is an integer and exists in the roles table
        ]);


        $input = $request->all();
        if (empty($input['password'])) {
            $input = Arr::except($input, ['password']);
        } else {
            $input['password'] = $input['new_password'];
        }

        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $user->id)->delete();
        $roles = Role::whereIn('id',$request->input('roles'))->pluck('id')->toArray();
        $user->assignRole($roles);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user->id == 1 || auth()->user()->id == $id) {
            return redirect()->back()->with('warning', 'You cannot delete this user.');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function profileEdit()
    {
        return view('admin.users.profile');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name'             => 'required',
            'email'            => 'required|email|unique:users,email,' . auth()->user()->id,
            'old_password'     => 'nullable|required_with:new_password',
            'new_password'     => 'nullable|min:8|max:12',
            'confirm_password' => 'nullable|min:8|max:12|required_with:new_password|same:new_password',
        ]);

        $input = $request->all();

        if (empty($input['new_password'])) {
            $input = Arr::except($input, ['password']);
        } else {
            $input['password'] = $input['new_password'];
        }
        auth()->user()->update($input);

        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    /**
     * Validate a resource.
     */
    public function checkEmail(Request $request)
    {
        $query = User::where('email', $request->email);
        if ($request->id) {$query->where('id', '!=', $request->id);}
        $user = $query->first();

        if ($user) {echo "false";} else {echo "true";}
    }

    /**
     * Validate a resource.
     */
    public function checkPassword(Request $request)
    {
        $user = User::find($request->id);
        if (! Hash::check($request->old_password, $user->password)) {echo "false";} else {echo "true";}
    }
}
