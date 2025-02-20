<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // function __construct()
    // {
    //     $this->middleware('permission:roles-list',  ['only' => ['index']]);
    //     $this->middleware('permission:roles-view',  ['only' => ['show']]);
    //     $this->middleware('permission:roles-create',['only' => ['create','store']]);
    //     $this->middleware('permission:roles-edit',  ['only' => ['edit','update']]);
    //     $this->middleware('permission:roles-delete',['only' => ['destroy']]);
    // }
    public static function middleware(): array
    {
        return [
            new Middleware('permission:roles-list', only: ['index']),
            new Middleware('permission:roles-view', only: ['show']),
            new Middleware('permission:roles-create', only: ['create', 'store']),
            new Middleware('permission:roles-edit', only: ['edit', 'update']),
            new Middleware('permission:roles-delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $roles = Role::paginate();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $role            = new Role();
        $permissionGroup = [];
        foreach (Permission::get() as $permission) {
            $title                        = explode('-', $permission->name);
            $permissionGroup[$title[0]][] = ['id' => $permission->id, 'name' => $title[1]];
        }
        return view('admin.roles.create', compact('role', 'permissionGroup'));
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
            'name'       => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
        $role = Role::create(['name' => $request->input('name'), 'guard_name' => 'web']);
        $permissions = array_filter(array_map('intval', $request->get('permission')));
        $role->syncPermissions($permissions);
        return redirect()->route('roles.index')->with('success', 'Role created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $role            = Role::find($id);
        $permissionGroup = [];
        foreach (Permission::get() as $permission) {
            in_array($permission->name, $role->permissions->pluck('name')->toArray()) ? $exist = 'checked' : $exist = '';
            $title                                                                             = explode('-', $permission->name);
            $permissionGroup[$title[0]][]                                                      = ['id' => $permission->id, 'name' => $title[1], 'exist' => $exist];
        }

        return view('admin.roles.show', compact('role', 'permissionGroup'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $role            = Role::find($id);
        $permissionGroup = [];
        foreach (Permission::get() as $permission) {
            in_array($permission->name, $role->permissions->pluck('name')->toArray()) ? $exist = 'checked' : $exist = NULL;
            $title                                                                             = explode('-', $permission->name);
            $permissionGroup[$title[0]][]                                                      = ['id' => $permission->id, 'name' => $title[1], 'exist' => $exist];
        }
        return view('admin.roles.edit', compact('role', 'permissionGroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name'       => 'required',
            'permission' => 'required',
        ]);

        $role->name = $request->input('name');
        $role->save();
        $permissions = array_filter(array_map('intval', $request->input('permission')));
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        if (count(Role::get()) == 1 && $role->id == 1) {
            return redirect()->back()->with('warning', 'You cannot delete the last role.');
        }
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully');
    }
}
