<?php

namespace App\DataTables;

use App\Transaction;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class ReportDataTables extends DataTable
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
            ->addColumn('transaction_type', function ($data) {
                return $data->transaction_type == "income" ? "Pendapatan" : "Pengeluaran";
            })
            ->addColumn('transaction_date', function ($data) {
                $carbon = new Carbon($data->created_at);
                return $carbon->locale("id")->isoFormat("D MMMM YYYY");
            })
            ->addColumn('created_at', function ($data) {
                $carbon = new Carbon($data->created_at);
                return $carbon->locale("id")->isoFormat("D MMMM YYYY HH:mm:ss");
            })
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\DataWakaf $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Transaction $model)
    {
        $model = Transaction::with("account")->select("transactions.*");
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
            ->setTableId('report-table')
            ->columns($this->getColumns())
            ->parameters([
                "buttons" => [
                    [
                        "extend" => 'excel',
                        "text" => "Export Data",
                        "className" => "btn btn-success mt-4",
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
            ->minifiedAjax("", null, ["start_date" => request("start_date"), "end_date" => request("end_date")])
            ->dom('Bflrtip')
            ->orderBy(0, "asc");
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
            Column::make('account.name')->title("Akun")->width(150),
            Column::make('transaction_type')->title("Tipe Transaksi")->width(100),
            Column::make('amount')->title("Jumlah")->width(100),
            Column::make('description')->title("Deskripsi")->width(200),
            Column::make('transaction_date')->title("Tanggal Transaksi")->width(100),
            Column::make('created_at')->title("Tanggal Dibuat")->width(100)
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Report_' . date('YmdHis');
    }
}
