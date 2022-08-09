<?php

namespace App\Http\Controllers;

use App\DataTables\ReportDataTables;
use App\DataTables\Scopes\ReportScope;
use App\Exports\TransactionExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request, ReportDataTables $dataTable)
    {
        if ($request->has('start_date') && $request->has('end_date')) {
            $dataTable->addScope(new ReportScope(Carbon::parse($request->start_date)->format("Y-m-d 00:00:00"), Carbon::parse($request->end_date)->format("Y-m-d 23:59:59")));
        }
        return $dataTable->render("admin.report.index", ["title" => "Laporan"]);
    }

    public function exportDetail(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        $fileName = "Laporan-" . $request->start_date . "_" . $request->end_date . ".xlsx";
        return Excel::download(new TransactionExport($request->start_date, $request->end_date), $fileName);
    }
}
