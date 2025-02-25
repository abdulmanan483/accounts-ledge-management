<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\LocationRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Nnjeim\World\Models\City;

class LocationController extends Controller
{
     /**
     * Constructor.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:locations-list',  ['only' => ['index']]);
        $this->middleware('permission:locations-view',  ['only' => ['show']]);
        $this->middleware('permission:locations-create',['only' => ['create','store']]);
        $this->middleware('permission:locations-edit',  ['only' => ['edit','update']]);
        $this->middleware('permission:locations-delete',['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $locations = Location::paginate();

        return view('admin.location.index', compact('locations'))
            ->with('i', ($request->input('page', 1) - 1) * $locations->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $location = new Location();

        return view('admin.location.create', compact('location'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LocationRequest $request): RedirectResponse
    {
        Location::create($request->validated());

        return Redirect::route('locations.index')
            ->with('success', 'Location created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $location = Location::find($id);

        return view('admin.location.show', compact('location'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $location = Location::find($id);

        return view('admin.location.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LocationRequest $request, Location $location): RedirectResponse
    {
        $location->update($request->validated());

        return Redirect::route('locations.index')
            ->with('success', 'Location updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Location::find($id)->delete();

        return Redirect::route('locations.index')
            ->with('success', 'Location deleted successfully');
    }
}
