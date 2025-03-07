<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\MediaRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class MediaController extends Controller
{
     /**
     * Constructor.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:media-list',  ['only' => ['index']]);
        $this->middleware('permission:media-view',  ['only' => ['show']]);
        $this->middleware('permission:media-create',['only' => ['create','store']]);
        $this->middleware('permission:media-edit',  ['only' => ['edit','update']]);
        $this->middleware('permission:media-delete',['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $media = Media::paginate();

        return view('admin.media.index', compact('media'))
            ->with('i', ($request->input('page', 1) - 1) * $media->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $medium = new Media();

        return view('admin.media.create', compact('medium'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MediaRequest $request): RedirectResponse
    {
        Media::create($request->validated());

        return Redirect::route('media.index')
            ->with('success', 'Medium created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $medium = Media::find($id);

        return view('admin.media.show', compact('medium'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $medium = Media::find($id);

        return view('admin.media.edit', compact('medium'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MediaRequest $request, Media $media): RedirectResponse
    {
        $media->update($request->validated());

        return Redirect::route('media.index')
            ->with('success', 'Medium updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Media::find($id)->delete();

        return Redirect::route('media.index')
            ->with('success', 'Medium deleted successfully');
    }
}
