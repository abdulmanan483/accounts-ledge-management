<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\PersonRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Interfaces\PersonInterface;

class PersonController extends Controller
{
    protected PersonInterface $person;

    /**
     * Constructor.
     *
     * @param PersonInterface $person
     */
    function __construct(PersonInterface $person)
    {
        $this->person = $person;

        $this->middleware('permission:persons-list',  ['only' => ['index']]);
        $this->middleware('permission:persons-view',  ['only' => ['show']]);
        $this->middleware('permission:persons-create',['only' => ['create','store']]);
        $this->middleware('permission:persons-edit',  ['only' => ['edit','update']]);
        $this->middleware('permission:persons-delete',['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $pagination_mode = $request->input('pagination_mode','client');
        if($pagination_mode == 'client'){
            $persons = $this->person->all();
            return view('admin.person.index', compact('persons'));
        }
        $persons = $this->person->paginate();

        return view('admin.person.index', compact('persons'))
            ->with('i', ($request->input('page', 1) - 1) * $persons->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $person = new Person();

        return view('admin.person.create', compact('person'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PersonRequest $request): RedirectResponse
    {
        $this->person->create($request->validated());

        return Redirect::route('persons.index')
            ->with('success', 'Person created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $person = $this->person->find($id);

        return view('admin.person.show', compact('person'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $person = $this->person->find($id);

        return view('admin.person.edit', compact('person'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PersonRequest $request, $person): RedirectResponse
    {
        $this->person->update($person, $request->validated());

        return Redirect::route('persons.index')
            ->with('success', 'Person updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        $this->person->delete($id);

        return Redirect::route('persons.index')
            ->with('success', 'Person deleted successfully');
    }
}
