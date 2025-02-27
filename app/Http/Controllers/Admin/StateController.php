<?php
namespace App\Http\Controllers\Admin;

use App\Enums\Generic\DataSource;
use App\Enums\Setting\LocationSystem;
use App\Http\Controllers\Controller;
// use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Nnjeim\World\Models\State;

/**
 * Class StateController
 * @package App\Http\Controllers
 */
class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:states-list', ['only' => ['index']]);
        $this->middleware('permission:states-view', ['only' => ['show']]);
        $this->middleware('permission:states-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:states-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:states-delete', ['only' => ['destroy']]);
    }
    // public static function middleware(): array
    // {
    //     return [
    //         new Middleware('permission:states-list', only: ['index']),
    //         new Middleware('permission:states-view', only: ['show']),
    //         new Middleware('permission:states-create', only: ['create', 'store']),
    //         new Middleware('permission:states-edit', only: ['edit', 'update']),
    //         new Middleware('permission:states-delete', only: ['destroy']),
    //     ];
    // }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $default_country_id    = settings('default_country_id');

        $states  = State::where('country_id', $default_country_id)->paginate();

        return view('admin.state.index', compact('states'));
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $state = new State();

        return view('admin.state.create', compact('state'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $state = State::create($request->all());

        return redirect()->route('states.index')
            ->with('success', 'State created successfully.');
    }

    /**
     * Display the specified resource.
     * @param  int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $state = State::find($id);

        return view('admin.state.show', compact('state'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $state = State::find($id);

        return view('admin.state.edit', compact('state'));
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @param  State $state
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, State $state)
    {
        $state->update($request->all());

        return redirect()->route('states.index')
            ->with('success', 'State updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $state = State::find($id)->delete();

        return redirect()->route('states.index')
            ->with('success', 'State deleted successfully');
    }
}
