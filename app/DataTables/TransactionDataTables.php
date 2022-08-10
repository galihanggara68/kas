<?php

namespace App\DataTables;

use App\App\TransactionDataTable;
use App\Transaction;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;

class TransactionDataTables extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('images', function ($data) {
                if ($data->images && preg_match("/transaction/", $data->image)) {
                    $img = explode("/", $data->images);
                    return '<img src="' . route("image.displayImage", [$img[0], $img[1], true]) . '" />';
                } else {
                    return '<img width="120" src="' . asset("assets/img/no-image.png") . '" />';
                }
            })
            ->addIndexColumn()
            ->addColumn('action', 'admin.transaction.index-action')
            ->rawColumns(['action', 'images']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\TransactionDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Transaction $model)
    {
        $model = Transaction::with(['details', 'account'])->select("transactions.*");
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('transaction-table')
            ->columns($this->getColumns())
            ->parameters([
                "buttons" => [
                    [
                        "extend" => 'excel',
                        "text" => "Export Data Transaksi",
                        "className" => "btn btn-success",
                        "exportOptions" => [
                            "modifier" => [
                                "page" => 'all',
                                "search" => 'none'
                            ]
                        ]
                    ]
                ],
                "scrollX" => "true",
                "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "All"]]
            ])
            ->minifiedAjax()
            ->dom('Bf<"toolbar">lrtip')
            ->orderBy(4, "desc");
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('name')->title("Nama Transaksi")->width(200),
            Column::make('account.name')->title("Akun")->width(200),
            Column::make('amount')->title("Jumlah")->width(100),
            Column::make('description')->title("Deskripsi")->width(200),
            Column::make('created_at')->title("Tanggal Transaksi")->width(150),
            Column::make('action')->title("Action")->width(100)
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'TransactionDataTables_' . date('YmdHis');
    }
}
