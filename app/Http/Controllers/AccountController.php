<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function index()
    {
        return view('admin.account.index');
    }

    public function source(){
        $query= Account::query();
        return DataTables::eloquent($query)
        ->filter(function ($query) {
            if (request()->has('search')) {
                $query->where(function ($q) {
                    $q->where('name', 'LIKE', '%' . request('search')['value'] . '%');
                });
            }
            })
            ->addColumn('name', function ($data) {
                return Str::title($data->name);
            })
            ->addIndexColumn()
            ->addColumn('action', 'admin.account.index-action')
            ->rawColumns(['action'])
            ->toJson();
    }

    public function create()
    {
        return view('admin.account.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string'
        ]);
        DB::beginTransaction();
        try {
            $requset = $request->merge(['slug'=>$request->name]);
            Account::create($request->all());
            DB::commit();
            return redirect()->route('account.index')->with('success-message','Data telah disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error-message',$e->getMessage());
        }

    }

    public function show($id)
    {
        $data = Account::find($id);
        return $data;

    }

    public function edit($id)
    {
        $data = Account::find($id);
        return view('admin.account.edit',compact('data'));

    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string'
        ]);
        DB::beginTransaction();
        try {
            $request = $request->merge(['slug'=>$request->name]);
            Account::find($id)->update($request->all());
            DB::commit();
            return redirect()->route('account.index')->with('success-message','Data telah diubah');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error-message',$e->getMessage());
        }

    }

    public function destroy($id)
    {
        Account::destroy($id);
        return redirect()->route('account.index')->with('success-message','Data telah dihapus');
    }
}
