<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TransactionRequest;
use App\Interfaces\AccountInterface;
use App\Interfaces\TransactionHeaderInterface;
use App\Models\Person;
use App\Models\TransactionHeader;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\PersonRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Interfaces\PersonInterface;
use App\Interfaces\TransactionCategoryInterface;

class TransactionController extends Controller
{
    protected TransactionHeaderInterface $transaction;


    /**
     * Constructor.
     *
     * @param TransactionHeaderInterface $transaction
     */
    function __construct(TransactionHeaderInterface $transaction, PersonInterface $person,AccountInterface $account,TransactionCategoryInterface $transaction_category)
    {
        $this->transaction = $transaction;
        $this->person = $person;
        $this->account = $account;
        $this->transaction_category = $transaction_category;
        $this->middleware('permission:transactions-list',  ['only' => ['index']]);
        $this->middleware('permission:transactions-view',  ['only' => ['show']]);
        $this->middleware('permission:transactions-create',['only' => ['create','store']]);
        $this->middleware('permission:transactions-edit',  ['only' => ['edit','update']]);
        $this->middleware('permission:transactions-delete',['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $pagination_mode = $request->input('pagination_mode','client');
        $request->merge(['with' => 'account,person,transaction_category']);
        if($pagination_mode == 'client'){
            $transactions = $this->transaction->all();
            return view('admin.transaction.index', compact('transactions'));
        }
        $transactions = $this->transaction->paginate();

        return view('admin.transaction.index', compact('transactions'))
            ->with('i', ($request->input('page', 1) - 1) * $transactions->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $persons = $this->person->all();
        $accounts = $this->account->all();
        $transaction_categories = $this->transaction_category->all();
        $transaction =  $this->transaction->new();

        return view('admin.transaction.create', compact('transaction','persons','accounts','transaction_categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionRequest $request): RedirectResponse
    {
        $this->transaction->create($request->validated());

        return Redirect::route('transactions.index')
            ->with('success', 'Transaction created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $transaction = $this->transaction->find($id);

        return view('admin.transaction.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $transaction = $this->transaction->find($id);

        return view('admin.transaction.edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($request, $transaction): RedirectResponse
    {
        $this->transaction->update($transaction, $request->validated());

        return Redirect::route('transactions.index')
            ->with('success', 'Transaction updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        $this->transaction->delete($id);

        return Redirect::route('transactions.index')
            ->with('success', 'Transaction deleted successfully');
    }
}
