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
        $accounts = $this->account->all();
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


        $transactions = [];
        $runningBalance = 0;
        $totalDebit = 0;
        $totalCredit = 0;
        $request->merge([
            'filters' => $filters,
            'with' => 'lines'
        ]);
        $linesQuery = $this->transaction->searchOrFilter($request);
        // Flatten transactions and calculate running balance
        foreach ($linesQuery as $header) {
            foreach ($header->lines as $line) {
                $runningBalance += $line->credit - $line->debit;
                $totalDebit += $line->debit;
                $totalCredit += $line->credit;

                $transactions[] = (object)[
                    'txn_date' => $header->txn_date,
                    'description' => $line->description,
                    'debit' => $line->debit,
                    'credit' => $line->credit,
                    'running_balance' => $runningBalance,
                ];
            }
        }

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
