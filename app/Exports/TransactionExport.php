<?php
namespace App\Exports;

use App\Transaction;
use App\TransactionDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionExport implements FromCollection, WithMapping
{
    private $startDate;
    private $endDate;

    public function setDate($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Transaction::query()->with("account", "details")->whereBetween("transaction_date", [$this->startDate, $this->endDate])->get();
    }

    public function map($transaction): array
    {
        return [
            $transaction->id,
            $transaction->account->name,
            $transaction->description,
            $transaction->transaction_date,
            $transaction->amount,
            $transaction->details->map(function ($detail) {
                return [
                    $detail->name,
                    $detail->qty,
                    $detail->price,
                    $detail->amount
                ];
            })
        ];
    }
}
