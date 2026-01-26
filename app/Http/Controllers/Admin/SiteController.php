<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Site;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\SiteRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class SiteController extends Controller
{
     /**
     * Constructor.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:sites-list',  ['only' => ['index']]);
        $this->middleware('permission:sites-view',  ['only' => ['show']]);
        $this->middleware('permission:sites-create',['only' => ['create','store']]);
        $this->middleware('permission:sites-edit',  ['only' => ['edit','update']]);
        $this->middleware('permission:sites-delete',['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $sites = Site::paginate();

        return view('admin.site.index', compact('sites'))
            ->with('i', ($request->input('page', 1) - 1) * $sites->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $site = new Site();

        return view('admin.site.create', compact('site'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SiteRequest $request): RedirectResponse
    {
        Site::create($request->validated());

        return Redirect::route('sites.index')
            ->with('success', 'Site created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $site = Site::find($id);

        return view('admin.site.show', compact('site'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $site = Site::find($id);

        return view('admin.site.edit', compact('site'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SiteRequest $request, Site $site): RedirectResponse
    {
        $site->update($request->validated());

        return Redirect::route('sites.index')
            ->with('success', 'Site updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Site::find($id)->delete();

        return Redirect::route('sites.index')
            ->with('success', 'Site deleted successfully');
    }
}
