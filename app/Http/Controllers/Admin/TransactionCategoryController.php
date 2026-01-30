<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransactionCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\TransactionCategoryRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Interfaces\TransactionCategoryInterface;

class TransactionCategoryController extends Controller
{
    protected TransactionCategoryInterface $transactionCategory;

    /**
     * Constructor.
     *
     * @param TransactionCategoryInterface $transactionCategory
     */
    function __construct(TransactionCategoryInterface $transactionCategory)
    {
        $this->transactionCategory = $transactionCategory;

        $this->middleware('permission:transaction-categories-list',  ['only' => ['index']]);
        $this->middleware('permission:transaction-categories-view',  ['only' => ['show']]);
        $this->middleware('permission:transaction-categories-create',['only' => ['create','store']]);
        $this->middleware('permission:transaction-categories-edit',  ['only' => ['edit','update']]);
        $this->middleware('permission:transaction-categories-delete',['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $pagination_mode = $request->input('pagination_mode','client');
        if($pagination_mode == 'client'){
            $transaction_categories = $this->transactionCategory->all();
            return view('admin.transaction-category.index', compact('transaction_categories'));
        }
        $transaction_categories = $this->transactionCategory->paginate();

        return view('admin.transaction-category.index', compact('transaction_categories'))
            ->with('i', ($request->input('page', 1) - 1) * $transaction_categories->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $transaction_category = new TransactionCategory();

        return view('admin.transaction-category.create', compact('transaction_category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionCategoryRequest $request): RedirectResponse
    {
        $this->transactionCategory->create($request->validated());

        return Redirect::route('transaction-categories.index')
            ->with('success', 'TransactionCategory created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $transaction_category = $this->transactionCategory->find($id);

        return view('admin.transaction-category.show', compact('transaction_category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $transaction_category = $this->transactionCategory->find($id);

        return view('admin.transaction-category.edit', compact('transaction_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TransactionCategoryRequest $request, TransactionCategory $transaction_category): RedirectResponse
    {
        $this->transactionCategory->update($transaction_category, $request->validated());

        return Redirect::route('transaction-categories.index')
            ->with('success', 'TransactionCategory updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        $this->transactionCategory->delete($id);

        return Redirect::route('transaction-categories.index')
            ->with('success', 'TransactionCategory deleted successfully');
    }
}
