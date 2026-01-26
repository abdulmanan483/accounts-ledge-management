<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\AccountRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Interfaces\AccountInterface;

class AccountController extends Controller
{
    protected AccountInterface $account;

    /**
     * Constructor.
     *
     * @param AccountInterface $account
     */
    function __construct(AccountInterface $account)
    {
        $this->account = $account;

        $this->middleware('permission:accounts-list',  ['only' => ['index']]);
        $this->middleware('permission:accounts-view',  ['only' => ['show']]);
        $this->middleware('permission:accounts-create',['only' => ['create','store']]);
        $this->middleware('permission:accounts-edit',  ['only' => ['edit','update']]);
        $this->middleware('permission:accounts-delete',['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $pagination_mode = $request->input('pagination_mode','client');
        if($pagination_mode == 'client'){
            $accounts = $this->account->all();
            return view('admin.account.index', compact('accounts'));
        }
        $accounts = $this->account->paginate();

        return view('admin.account.index', compact('accounts'))
            ->with('i', ($request->input('page', 1) - 1) * $accounts->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $account = new Account();

        return view('admin.account.create', compact('account'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccountRequest $request): RedirectResponse
    {
        $this->account->create($request->validated());

        return Redirect::route('accounts.index')
            ->with('success', 'Account created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $account = $this->account->find($id);

        return view('admin.account.show', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $account = $this->account->find($id);

        return view('admin.account.edit', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AccountRequest $request, Account $account): RedirectResponse
    {
        $this->account->update($account, $request->validated());

        return Redirect::route('accounts.index')
            ->with('success', 'Account updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        $this->account->delete($id);

        return Redirect::route('accounts.index')
            ->with('success', 'Account deleted successfully');
    }
}
