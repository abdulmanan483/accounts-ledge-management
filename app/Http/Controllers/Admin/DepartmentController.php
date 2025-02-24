<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\DepartmentRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class DepartmentController extends Controller
{
     /**
     * Constructor.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:departments-list',  ['only' => ['index']]);
        $this->middleware('permission:departments-view',  ['only' => ['show']]);
        $this->middleware('permission:departments-create',['only' => ['create','store']]);
        $this->middleware('permission:departments-edit',  ['only' => ['edit','update']]);
        $this->middleware('permission:departments-delete',['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $departments = Department::paginate();

        return view('admin.department.index', compact('departments'))
            ->with('i', ($request->input('page', 1) - 1) * $departments->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $department = new Department();

        return view('admin.department.create', compact('department'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentRequest $request): RedirectResponse
    {
        Department::create($request->validated());

        return Redirect::route('departments.index')
            ->with('success', 'Department created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $department = Department::find($id);

        return view('admin.department.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $department = Department::find($id);

        return view('admin.department.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentRequest $request, Department $department): RedirectResponse
    {
        $department->update($request->validated());

        return Redirect::route('departments.index')
            ->with('success', 'Department updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Department::find($id)->delete();

        return Redirect::route('departments.index')
            ->with('success', 'Department deleted successfully');
    }
}
