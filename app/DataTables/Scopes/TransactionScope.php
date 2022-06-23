<?php

namespace App\DataTables\Scopes;

use Yajra\DataTables\Contracts\DataTableScope;

class TransactionScope implements DataTableScope
{
    public function __construct($transactionType)
    {
        $this->transactionType = $transactionType;
    }

    /**
     * Apply a query scope.
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query
     * @return mixed
     */
    public function apply($query)
    {
        return !($this->transactionType) ? $query : $query->where("transaction_type", $this->transactionType);
    }
}
