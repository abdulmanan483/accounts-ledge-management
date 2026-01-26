<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Block;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\BlockRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class BlockController extends Controller
{
     /**
     * Constructor.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:blocks-list',  ['only' => ['index']]);
        $this->middleware('permission:blocks-view',  ['only' => ['show']]);
        $this->middleware('permission:blocks-create',['only' => ['create','store']]);
        $this->middleware('permission:blocks-edit',  ['only' => ['edit','update']]);
        $this->middleware('permission:blocks-delete',['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $blocks = Block::paginate();

        return view('admin.block.index', compact('blocks'))
            ->with('i', ($request->input('page', 1) - 1) * $blocks->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $block = new Block();

        return view('admin.block.create', compact('block'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlockRequest $request): RedirectResponse
    {
        Block::create($request->validated());

        return Redirect::route('blocks.index')
            ->with('success', 'Block created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $block = Block::find($id);

        return view('admin.block.show', compact('block'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $block = Block::find($id);

        return view('admin.block.edit', compact('block'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlockRequest $request, Block $block): RedirectResponse
    {
        $block->update($request->validated());

        return Redirect::route('blocks.index')
            ->with('success', 'Block updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Block::find($id)->delete();

        return Redirect::route('blocks.index')
            ->with('success', 'Block deleted successfully');
    }
}
