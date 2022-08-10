<?php

namespace App\DataTables;

use App\Product;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductDatatables extends DataTable
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
            ->addColumn('image', function ($data) {
                if ($data->image && preg_match("/product/", $data->image)) {
                    $img = explode("/", $data->image);
                    return '<img src="' . route("image.displayImage", [$img[0], $img[1], true]) . '" />';
                } else {
                    return '<img width="120" src="' . asset("assets/img/no-image.png") . '" />';
                }
            })
            ->addColumn('action', 'admin.product.index-action')
            ->rawColumns(['action', 'image']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\ProductDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Product $model)
    {
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
            ->setTableId('product-table')
            ->columns($this->getColumns())
            ->parameters([
                "scrollX" => "true",
                "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "All"]]
            ])
            ->minifiedAjax()
            ->dom('Bf<"toolbar">lrtip')
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
            Column::make('name')->title("Nama Produk")->width(300),
            Column::make('price')->title("Harga")->width(250),
            Column::make('image')->title("Gambar")->width(220),
            Column::make('action')->title("Action")->width(150)
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'ProductDatatables_' . date('YmdHis');
    }
}
