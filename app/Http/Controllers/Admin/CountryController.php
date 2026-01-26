<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CountryRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Interfaces\CountryInterface;

class CountryController extends Controller
{
    protected CountryInterface $country;

    /**
     * Constructor.
     *
     * @param CountryInterface $country
     */
    function __construct(CountryInterface $country)
    {
        $this->country = $country;

        $this->middleware('permission:countries-list',  ['only' => ['index']]);
        $this->middleware('permission:countries-view',  ['only' => ['show']]);
        $this->middleware('permission:countries-create',['only' => ['create','store']]);
        $this->middleware('permission:countries-edit',  ['only' => ['edit','update']]);
        $this->middleware('permission:countries-delete',['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $pagination_mode = $request->input('pagination_mode','client');
        if($pagination_mode == 'client'){
            $countries = $this->country->all();
            return view('admin.country.index', compact('countries'));
        }
        $countries = $this->country->paginate();
        return view('admin.country.index', compact('countries'))
            ->with('i', ($request->input('page', 1) - 1) * $countries->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $country = new Country();

        return view('admin.country.create', compact('country'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CountryRequest $request): RedirectResponse
    {
        $this->country->create($request->validated());

        return Redirect::route('countries.index')
            ->with('success', 'Country created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $country = $this->country->find($id);

        return view('admin.country.show', compact('country'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $country = $this->country->find($id);

        return view('admin.country.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CountryRequest $request, Country $country): RedirectResponse
    {
        $this->country->update($country, $request->validated());

        return Redirect::route('countries.index')
            ->with('success', 'Country updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        $this->country->delete($id);

        return Redirect::route('countries.index')
            ->with('success', 'Country deleted successfully');
    }
}
