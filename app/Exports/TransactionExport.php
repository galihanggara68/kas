<?php
namespace App\Exports;

use App\Transaction;
use App\TransactionDetail;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionExport implements FromQuery
{
    private $startDate;
    private $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {
        $transaction = Transaction::query()->whereBetween('transaction_date', [$this->startDate, $this->endDate]);
        return TransactionDetail::query()->with('transaction')->whereIn('transaction_id', $transaction->pluck('id'))->select("*");
    }
}
