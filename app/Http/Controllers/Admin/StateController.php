<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StateRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Interfaces\StateInterface;

class StateController extends Controller
{
    protected StateInterface $state;

    /**
     * Constructor.
     *
     * @param StateInterface $state
     */
    function __construct(StateInterface $state)
    {
        $this->state = $state;

        $this->middleware('permission:states-list',  ['only' => ['index']]);
        $this->middleware('permission:states-view',  ['only' => ['show']]);
        $this->middleware('permission:states-create',['only' => ['create','store']]);
        $this->middleware('permission:states-edit',  ['only' => ['edit','update']]);
        $this->middleware('permission:states-delete',['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $pagination_mode = $request->input('pagination_mode','client');
        if($pagination_mode == 'client'){
            $states = $this->state->all();
            return view('admin.state.index', compact('states'));
        }
        $states = $this->state->paginate();

        return view('admin.state.index', compact('states'))
            ->with('i', ($request->input('page', 1) - 1) * $states->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $state = new State();

        return view('admin.state.create', compact('state'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StateRequest $request): RedirectResponse
    {
        $this->state->create($request->validated());

        return Redirect::route('states.index')
            ->with('success', 'State created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $state = $this->state->find($id);

        return view('admin.state.show', compact('state'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $state = $this->state->find($id);

        return view('admin.state.edit', compact('state'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StateRequest $request, State $state): RedirectResponse
    {
        $this->state->update($state, $request->validated());

        return Redirect::route('states.index')
            ->with('success', 'State updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        $this->state->delete($id);

        return Redirect::route('states.index')
            ->with('success', 'State deleted successfully');
    }
}
