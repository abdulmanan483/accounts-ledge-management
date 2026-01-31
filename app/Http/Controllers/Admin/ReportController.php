<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\AccountInterface;
use App\Interfaces\TransactionHeaderInterface;
use App\Interfaces\PersonInterface;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected TransactionHeaderInterface $transaction;
    protected PersonInterface $person;
    protected AccountInterface $account;

    public function __construct(
        TransactionHeaderInterface $transaction,
        PersonInterface $person,
        AccountInterface $account
    ) {
        $this->transaction = $transaction;
        $this->person = $person;
        $this->account = $account;

        $this->middleware('permission:accounts-ledger-report', ['only' => ['accountsLedger', 'showAccountsLedgerForm']]);
    }

    /**
     * Show Accounts Ledger Filter Form
     */
    public function showAccountsLedgerForm()
    {
        request()->merge(input: ['with' => ['currency']]);
        $accounts = $this->account->all();

        return view('admin.reports.accounts_ledger', [
            'accounts' => $accounts,
            'transactions' => [],
            'start_date' => null,
            'end_date' => null,
            'selected_account' => null,
            'totalDebit' => 0,
            'totalCredit' => 0,
            'finalBalance' => 0,
        ]);
    }

    /**
     * Accounts Ledger Report
     */
    public function accountsLedger(Request $request)
    {
        // Fetch accounts for dropdown
        $request->merge(['with' => ['currency']]);
        $accounts = $this->account->searchOrFilter($request);
        $accountId = $request->input('account_id');
        $startDate = $request->input('from_date');
        $endDate   = $request->input('to_date');

        // Fetch transactions filtered by account and date
        $filters = [];
        if ($accountId) {
            $filters['account_id'] = $accountId;
        }

        if ($startDate) {
            $filters['txn_date'] = [
                'operator' => '>=',
                'value'    => $startDate,
            ];
        }

        if ($endDate) {
            $filters['txn_date'] = [
                'operator' => '<=',
                'value'    => $endDate,
            ];
        }
        if($startDate && $endDate) {
            $filters['txn_date'] = [
                'operator' => 'between',
                'value'    => [$startDate, $endDate],
            ];
        }
        $transactions = [];
        $runningBalance = 0;
        $totalDebit = 0;
        $totalCredit = 0;
        $request->merge([
            'filters' => $filters,
            'with' => ['lines', 'currency','account','person','transaction_category'],
            'sort_by' => 'txn_date',
            'sort_order' => 'asc',
        ]);
        $linesQuery = $this->transaction->searchOrFilter($request);
        $transactions = collect($linesQuery)
            ->flatMap(
                fn($h) =>
                $h->lines->map(fn($l) => (object)[
                    'txn_date'    => $h->txn_date,
                    'description' => $l->description,
                    'debit'       => (float) $l->debit,
                    'credit'      => (float) $l->credit,
                    'currency'    => $h->currency,
                    'transaction_category' => $h->transaction_category,
                    'person' => $h->person,
                ])
            )
            ->sortBy('txn_date')
            ->values();

        $runningBalance = $totalDebit = $totalCredit = 0;

        $transactions->each(function ($t) use (&$runningBalance, &$totalDebit, &$totalCredit) {
            $runningBalance += $t->credit - $t->debit;
            $t->running_balance = $runningBalance;

            $totalDebit  += $t->debit;
            $totalCredit += $t->credit;
        });


        return view('admin.reports.accounts_ledger', [
            'accounts' => $accounts,
            'transactions' => $transactions,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'selected_account' => $accountId,
            'totalDebit' => $totalDebit,
            'totalCredit' => $totalCredit,
            'finalBalance' => $runningBalance,
        ]);
    }
}
