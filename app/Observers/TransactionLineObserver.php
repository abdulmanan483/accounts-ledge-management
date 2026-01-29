<?php

namespace App\Observers;

use App\Models\TransactionLine;
use Illuminate\Support\Facades\DB;

class TransactionLineObserver
{
    public function created(TransactionLine $line)
    {
        $this->recalculate($line);
    }

    public function updated(TransactionLine $line)
    {
        $this->recalculate($line);
    }

    public function deleted(TransactionLine $line)
    {
        $this->recalculate($line);
    }

    public function restored(TransactionLine $line)
    {
        $this->recalculate($line);
    }

    protected function recalculate(TransactionLine $line): void
    {
        DB::transaction(function () use ($line) {

            $header = $line->header;
            if (!$header) {
                return;
            }

            /** -------------------------
             * HEADER TOTALS
             * ------------------------ */
            $totalDebit  = $header->lines()->sum('debit');
            $totalCredit = $header->lines()->sum('credit');

            $header->updateQuietly([
                'total_debit'  => $totalDebit,
                'total_credit' => $totalCredit,
                'balance'      => $totalDebit - $totalCredit,
            ]);

            /** -------------------------
             * PERSON TOTALS
             * ------------------------ */
            if ($header->person) {
                $person = $header->person;

                $pDebit  = $person->transactionLines()->sum('debit');
                $pCredit = $person->transactionLines()->sum('credit');

                $person->updateQuietly([
                    'total_debit'     => $pDebit,
                    'total_credit'    => $pCredit,
                    'current_balance' => $pDebit - $pCredit,
                ]);
            }

            /** -------------------------
             * ACCOUNT TOTALS
             * ------------------------ */
            if ($header->account) {
                $account = $header->account;

                $aDebit  = $account->transactionLines()->sum('debit');
                $aCredit = $account->transactionLines()->sum('credit');

                $account->updateQuietly([
                    'total_debit'     => $aDebit,
                    'total_credit'    => $aCredit,
                    'current_balance' => $account->opening_balance + $aDebit - $aCredit,
                ]);
            }
        });
    }
}
