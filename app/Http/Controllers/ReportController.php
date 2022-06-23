<?php

namespace App\Http\Controllers;

use App\DataTables\ReportDataTables;
use App\DataTables\Scopes\ReportScope;
use App\Exports\TransactionExport;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request, ReportDataTables $dataTable){
        if($request->has('start_date') && $request->has('end_date')){
            $dataTable->addScope(new ReportScope($request->start_date, $request->end_date));
        }
        return $dataTable->render("admin.report.index", ["title" => "Laporan"]);
    }

    public function exportDetail(Request $request){
        $trExport = new TransactionExport();
        $trExport->setDate($request->start_date, $request->end_date);
        $fileName = "export/Laporan-".Carbon::now()->format("Y-m-d").".xlsx";
        Excel::store($trExport, $fileName, 'public');
        return response()->download(storage_path($fileName));
    }
}
