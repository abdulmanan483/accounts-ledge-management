<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\AccountInterface;
use App\Interfaces\TransactionHeaderInterface;
use App\Interfaces\PersonInterface;
use App\Interfaces\TransactionCategoryInterface;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected TransactionHeaderInterface $transaction;
    protected PersonInterface $person;
    protected AccountInterface $account;

    public function __construct(
        TransactionHeaderInterface $transaction,
        PersonInterface $person,
        AccountInterface $account,
        TransactionCategoryInterface $transactionCategory
    ) {
        $this->transaction = $transaction;
        $this->person = $person;
        $this->account = $account;
        $this->transactionCategory = $transactionCategory;

        $this->middleware('permission:accounts-ledger-report', ['only' => ['accountsLedger', 'showAccountsLedgerForm']]);
    }

    /**
     * Accounts Ledger Report
     */
    public function accountsLedger(Request $request)
    {
        // Always eager load currency for accounts & transactions
        $request->merge(['with' => ['currency']]);

        // Fetch all accounts for dropdown
        $accounts = $this->account->all();

        // Get filters from GET query string
        $accountId = $request->query('account_id');
        $startDate = $request->query('from_date');
        $endDate   = $request->query('to_date');

        $transactions = collect();
        $totalDebit = $totalCredit = $finalBalance = 0;

        // Only fetch if any filter is applied
        if ($accountId || $startDate || $endDate) {

            // Build filters
            $filters = [];
            if ($accountId) {
                $filters['account_id'] = $accountId;
            }

            if ($startDate && $endDate) {
                $filters['txn_date'] = ['operator' => 'between', 'value' => [$startDate, $endDate]];
            } elseif ($startDate) {
                $filters['txn_date'] = ['operator' => '>=', 'value' => $startDate];
            } elseif ($endDate) {
                $filters['txn_date'] = ['operator' => '<=', 'value' => $endDate];
            }

            // Merge filters & relations for search
            $request->merge([
                'filters' => $filters,
                'with' => ['lines', 'currency', 'account', 'person', 'transaction_category'],
                'sort_by' => 'txn_date',
                'sort_order' => 'asc',
            ]);

            // Fetch filtered transactions
            $headers = $this->transaction->searchOrFilter($request);

            // Flatten lines with txn header info
            $transactions = collect($headers)
                ->flatMap(fn($h) => $h->lines->map(fn($l) => (object)[
                    'txn_id' => $h->txn_id,
                    'txn_date' => $h->txn_date,
                    'description' => $l->description,
                    'debit' => (float) $l->debit,
                    'credit' => (float) $l->credit,
                    'currency' => $h->currency,
                    'transaction_category' => $h->transaction_category,
                    'person' => $h->person,
                ]))
                ->sortBy([
                    ['txn_date', 'asc'],
                    ['txn_id', 'asc'],
                ])
                ->values();

            // Calculate totals & running balance
            $runningBalance = 0;
            $transactions->each(function ($t) use (&$runningBalance, &$totalDebit, &$totalCredit) {
                $runningBalance += $t->credit - $t->debit;
                $t->running_balance = $runningBalance;

                $totalDebit  += $t->debit;
                $totalCredit += $t->credit;
            });
            $finalBalance = $runningBalance;
        }

        return view('admin.reports.accounts_ledger', [
            'accounts' => $accounts,
            'transactions' => $transactions, // empty on first load
            'start_date' => $startDate,
            'end_date' => $endDate,
            'selected_account' => $accountId,
            'totalDebit' => $totalDebit,
            'totalCredit' => $totalCredit,
            'finalBalance' => $finalBalance,
        ]);
    }

    /**
     * Income vs Expense Ledger Report
     */
    public function incomeVsExpenseLedger(Request $request)
    {
        // Fetch accounts and categories for filters
        $accounts = $this->account->all();
        $categories = $this->transactionCategory->all();

        // Get query params
        $accountId = $request->query('account_id');
        $categoryId = $request->query('category_id'); // optional
        $startDate = $request->query('from_date');
        $endDate   = $request->query('to_date');

        $transactions = collect();
        $totalIncome = $totalExpense = $finalBalance = 0;
        $summary = [];

        if ($accountId || $categoryId || $startDate || $endDate) {
            $filters = [];

            if ($accountId) {
                $filters['account_id'] = $accountId;
            }
            if ($categoryId) {
                $filters['transaction_category_id'] = $categoryId;
            }

            if ($startDate && $endDate) {
                $filters['txn_date'] = [
                    'operator' => 'between',
                    'value'    => [$startDate, $endDate],
                ];
            } elseif ($startDate) {
                $filters['txn_date'] = [
                    'operator' => '>=',
                    'value'    => $startDate,
                ];
            } elseif ($endDate) {
                $filters['txn_date'] = [
                    'operator' => '<=',
                    'value'    => $endDate,
                ];
            }

            // Fetch transactions with relationships
            $request->merge([
                'filters' => $filters,
                'with' => ['lines', 'currency', 'account', 'person', 'transaction_category'],
                'sort_by' => 'txn_date',
                'sort_order' => 'asc',
            ]);

            $headers = $this->transaction->searchOrFilter($request);

            $transactions = collect($headers)
                ->flatMap(function ($h) {
                    return $h->lines->map(function ($l) use ($h) {
                        return (object)[
                            'txn_id'    => $h->txn_id,
                            'txn_date'    => $h->txn_date,
                            'description' => $l->description,
                            'debit'       => (float) $l->debit,
                            'credit'      => (float) $l->credit,
                            'currency'    => $h->currency,
                            'transaction_category' => $h->transaction_category,
                            'person' => $h->person,
                        ];
                    });
                })
                ->sortBy([
                    ['txn_date', 'asc'],
                    ['txn_id', 'asc'],
                ])
                ->values();

            $runningBalance = 0;
            $transactions->each(function ($t) use (&$runningBalance, &$totalIncome, &$totalExpense) {
                $runningBalance += $t->credit - $t->debit;
                $t->running_balance = $runningBalance;

                // Income / Expense summary
                if ($t->credit > 0) {
                    $totalIncome += $t->credit;
                }
                if ($t->debit > 0) {
                    $totalExpense += $t->debit;
                }
            });

            $finalBalance = $runningBalance;

            // Summary grouped by category
            $summary = $transactions->groupBy(fn($t) => $t->transaction_category?->name ?? 'Uncategorized')
                ->map(function ($group) {
                    return [
                        'total_debit'  => $group->sum('debit'),
                        'total_credit' => $group->sum('credit'),
                    ];
                });
        }

        // Calculate net profit/loss
        $netProfitLoss = $totalIncome - $totalExpense;

        return view('admin.reports.income_vs_expense', [
            'accounts' => $accounts,
            'categories' => $categories,
            'transactions' => $transactions,
            'summary' => $summary,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'selected_account' => $accountId,
            'selected_category' => $categoryId,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'netProfitLoss' => $netProfitLoss,
            'finalBalance' => $finalBalance,
        ]);
    }
    public function profitVsLossLedger(Request $request)
    {
        // Fetch accounts for optional filter dropdown (if needed)
        $accounts = $this->account->all();

        // Get query params
        $accountId = $request->query('account_id');
        $startDate = $request->query('from_date');
        $endDate   = $request->query('to_date');

        $transactions = collect();
        $summary = [];
        $totalIncome = 0;
        $totalExpense = 0;

        // Only fetch if any filter is present
        if ($accountId || $startDate || $endDate) {
            $filters = [];
            if ($accountId) $filters['account_id'] = $accountId;

            if ($startDate && $endDate) {
                $filters['txn_date'] = ['operator' => 'between', 'value' => [$startDate, $endDate]];
            } elseif ($startDate) {
                $filters['txn_date'] = ['operator' => '>=', 'value' => $startDate];
            } elseif ($endDate) {
                $filters['txn_date'] = ['operator' => '<=', 'value' => $endDate];
            }

            $request->merge([
                'filters' => $filters,
                'with' => ['lines', 'currency', 'transaction_category'],
                'sort_by' => 'txn_date',
                'sort_order' => 'asc',
            ]);

            $headers = $this->transaction->searchOrFilter($request);

            // Flatten transaction lines
            $transactions = collect($headers)
                ->flatMap(
                    fn($h) =>
                    $h->lines->map(fn($l) => (object)[
                        'txn_date'    => $h->txn_date,
                        'description' => $l->description,
                        'debit'       => (float)$l->debit,
                        'credit'      => (float)$l->credit,
                        'currency'    => $h->currency,
                        'transaction_category' => $h->transaction_category,
                    ])
                )
                ->sortBy(fn($t) => [$t->txn_date, $t->transaction_category?->id])
                ->values();

            // Prepare category summary
            foreach ($transactions as $t) {
                $catName = $t->transaction_category?->name ?? 'Uncategorized';
                if (!isset($summary[$catName])) {
                    $summary[$catName] = ['total_debit' => 0, 'total_credit' => 0];
                }

                $summary[$catName]['total_debit'] += $t->debit;
                $summary[$catName]['total_credit'] += $t->credit;

                $totalIncome  += $t->credit;
                $totalExpense += $t->debit;
            }

            $netProfit = $totalIncome - $totalExpense;
        } else {
            $netProfit = 0;
        }

        return view('admin.reports.profit_vs_loss', [
            'accounts' => $accounts,
            'transactions' => $transactions,
            'summary' => $summary,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'netProfit' => $netProfit,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'selected_account' => $accountId,
        ]);
    }
}
