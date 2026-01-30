<?php

namespace App\Repositories;

use App\Interfaces\TransactionHeaderInterface;
use App\Models\TransactionHeader;
use Illuminate\Support\Facades\DB;

class TransactionHeaderRepository extends BaseRepository implements TransactionHeaderInterface
{
    public function __construct(TransactionHeader $model)
    {
        parent::__construct($model);
    }
    /**
     * Create a transaction header with its lines
     *
     * @param array $data
     * @return TransactionHeader
     */
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {

            // 1️⃣ Create the Transaction Header
            $header = $this->model->create([
                'account_id' => $data['account_id'],
                'transaction_category_id' => $data['transaction_category_id'],
                'reference' => $data['reference'],
                'person_id' => $data['person_id'] ?? null,
                'txn_date' => $data['txn_date'],
                'txn_id' => self::generateTxnId($data['txn_date'] ?? null),
            ]);

            // 2️⃣ Create the Transaction Lines
            if (!empty($data['lines'])) {
                foreach ($data['lines'] as $line) {
                    $header->lines()->create([
                        'description' => $line['description'] ?? null,
                        'debit' => max(0, floatval($line['debit'] ?? 0)),   // prevent negative
                        'credit' => max(0, floatval($line['credit'] ?? 0)), // prevent negative
                    ]);
                }
            }

            return $header;
        });
    }
    public static function generateTxnId($txnDate = null)
    {
        $date = $txnDate ? \Carbon\Carbon::parse($txnDate) : now();
        $datePart = $date->format('Ymd');

        // Count existing transactions for this date
        $count = TransactionHeader::whereDate('txn_date', $date)->count() + 1;

        // Pad number to 4 digits
        $number = str_pad($count, 4, '0', STR_PAD_LEFT);

        return "TXN-{$datePart}-{$number}";
    }
}
