<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CurrencyRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Interfaces\CurrencyInterface;

class CurrencyController extends Controller
{
    protected CurrencyInterface $currency;

    /**
     * Constructor.
     *
     * @param CurrencyInterface $currency
     */
    function __construct(CurrencyInterface $currency)
    {
        $this->currency = $currency;

        $this->middleware('permission:currencies-list',  ['only' => ['index']]);
        $this->middleware('permission:currencies-view',  ['only' => ['show']]);
        $this->middleware('permission:currencies-create',['only' => ['create','store']]);
        $this->middleware('permission:currencies-edit',  ['only' => ['edit','update']]);
        $this->middleware('permission:currencies-delete',['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $pagination_mode = $request->input('pagination_mode','client');
        if($pagination_mode == 'client'){
            $currencies = $this->currency->all();
            return view('admin.currency.index', compact('currencies'));
        }
        $currencies = $this->currency->paginate();

        return view('admin.currency.index', compact('currencies'))
            ->with('i', ($request->input('page', 1) - 1) * $currencies->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $currency = new Currency();

        return view('admin.currency.create', compact('currency'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CurrencyRequest $request): RedirectResponse
    {
        $this->currency->create($request->validated());

        return Redirect::route('currencies.index')
            ->with('success', 'Currency created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $currency = $this->currency->find($id);

        return view('admin.currency.show', compact('currency'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $currency = $this->currency->find($id);

        return view('admin.currency.edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CurrencyRequest $request, Currency $currency): RedirectResponse
    {
        $this->currency->update($currency, $request->validated());

        return Redirect::route('currencies.index')
            ->with('success', 'Currency updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        $this->currency->delete($id);

        return Redirect::route('currencies.index')
            ->with('success', 'Currency deleted successfully');
    }
}
