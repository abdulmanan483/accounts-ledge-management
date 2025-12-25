<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CityRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Interfaces\CityInterface;

class CityController extends Controller
{
    protected CityInterface $city;

    /**
     * Constructor.
     *
     * @param CityInterface $city
     */
    function __construct(CityInterface $city)
    {
        $this->city = $city;

        $this->middleware('permission:cities-list',  ['only' => ['index']]);
        $this->middleware('permission:cities-view',  ['only' => ['show']]);
        $this->middleware('permission:cities-create',['only' => ['create','store']]);
        $this->middleware('permission:cities-edit',  ['only' => ['edit','update']]);
        $this->middleware('permission:cities-delete',['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $pagination_mode = $request->input('pagination_mode','server');
        if($pagination_mode == 'client'){
            $cities = $this->city->all();
            return view('admin.city.index', compact('cities'));
        }
        $cities = $this->city->paginate();

        return view('admin.city.index', compact('cities'))
            ->with('i', ($request->input('page', 1) - 1) * $cities->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $city = new City();

        return view('admin.city.create', compact('city'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CityRequest $request): RedirectResponse
    {
        $this->city->create($request->validated());

        return Redirect::route('cities.index')
            ->with('success', 'City created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $city = $this->city->find($id);

        return view('admin.city.show', compact('city'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $city = $this->city->find($id);

        return view('admin.city.edit', compact('city'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CityRequest $request, City $city): RedirectResponse
    {
        $this->city->update($city, $request->validated());

        return Redirect::route('cities.index')
            ->with('success', 'City updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        $this->city->delete($id);

        return Redirect::route('cities.index')
            ->with('success', 'City deleted successfully');
    }
}
