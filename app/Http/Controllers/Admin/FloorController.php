<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Floor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\FloorRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class FloorController extends Controller
{
     /**
     * Constructor.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:floors-list',  ['only' => ['index']]);
        $this->middleware('permission:floors-view',  ['only' => ['show']]);
        $this->middleware('permission:floors-create',['only' => ['create','store']]);
        $this->middleware('permission:floors-edit',  ['only' => ['edit','update']]);
        $this->middleware('permission:floors-delete',['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $floors = Floor::paginate();

        return view('admin.floor.index', compact('floors'))
            ->with('i', ($request->input('page', 1) - 1) * $floors->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $floor = new Floor();

        return view('admin.floor.create', compact('floor'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FloorRequest $request): RedirectResponse
    {
        Floor::create($request->validated());

        return Redirect::route('floors.index')
            ->with('success', 'Floor created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $floor = Floor::find($id);

        return view('admin.floor.show', compact('floor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $floor = Floor::find($id);

        return view('admin.floor.edit', compact('floor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FloorRequest $request, Floor $floor): RedirectResponse
    {
        $floor->update($request->validated());

        return Redirect::route('floors.index')
            ->with('success', 'Floor updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Floor::find($id)->delete();

        return Redirect::route('floors.index')
            ->with('success', 'Floor deleted successfully');
    }
}
