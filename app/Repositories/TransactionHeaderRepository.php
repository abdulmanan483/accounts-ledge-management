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
                'reference' => $data['reference'],
                'person_id' => $data['person_id'] ?? null,
                'txn_date' => $data['txn_date'],
                'txn_id' => \Illuminate\Support\Str::uuid(),
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
}
