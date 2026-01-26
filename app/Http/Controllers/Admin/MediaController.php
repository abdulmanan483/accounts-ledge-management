<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medium;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\MediumRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Interfaces\MediumInterface;

class MediaController extends Controller
{
    protected MediumInterface $medium;

    /**
     * Constructor.
     *
     * @param MediumInterface $medium
     */
    function __construct(MediumInterface $medium)
    {
        $this->medium = $medium;

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
        $pagination_mode = $request->input('pagination_mode','client');
        if($pagination_mode == 'client'){
            $media = $this->medium->all();
            return view('admin.medium.index', compact('media'));
        }
        $media = $this->medium->paginate();

        return view('admin.medium.index', compact('media'))
            ->with('i', ($request->input('page', 1) - 1) * $media->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $medium = new Medium();

        return view('admin.medium.create', compact('medium'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MediumRequest $request): RedirectResponse
    {
        $this->medium->create($request->validated());

        return Redirect::route('media.index')
            ->with('success', 'Medium created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $medium = $this->medium->find($id);

        return view('admin.medium.show', compact('medium'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $medium = $this->medium->find($id);

        return view('admin.medium.edit', compact('medium'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MediumRequest $request, Medium $medium): RedirectResponse
    {
        $this->medium->update($medium, $request->validated());

        return Redirect::route('media.index')
            ->with('success', 'Medium updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        $this->medium->delete($id);

        return Redirect::route('media.index')
            ->with('success', 'Medium deleted successfully');
    }
}
