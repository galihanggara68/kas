<?php

namespace App\Http\Controllers;

use App\Account;
use App\DataTables\Scopes\TransactionScope;
use App\DataTables\TransactionDataTables;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Product;
use Illuminate\Support\Str;

class TransactionController extends Controller
{

    public function __construct()
    {
        $this->transaction = new Transaction();
    }

    public function index(Request $request, TransactionDataTables $dataTable, $transaction_type)
    {
        if ($transaction_type) {
            $dataTable->addScope(new TransactionScope($transaction_type));
        }
        $accounts = Account::all();
        return $dataTable->render("admin.transaction.index", ['transaction_type' => $transaction_type, 'accounts' => $accounts]);
    }

    // halaman buat transaksi
    public function create($transaction_type)
    {
        $accounts = Account::all();
        return view('admin.transaction.create', compact(['transaction_type', 'accounts']));
    }

    // simpan transaksi
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'account_id' => 'required',
            'description' => 'required',
            'transaction_type' => 'required',
            'transaction_date' => 'required',
            'amount' => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();
        try {
            if ($request->has('image')) {
                $fileName = Str::uuid();

                $img = $request->image->storeAs(
                    'public/image/transaction',
                    $fileName . '.' . $request->image->extension()
                );
                $request->merge([
                    'images' => preg_replace("/public\/image\//", "", $img)
                ]);
            }
            $request->merge([
                'slug' => Str::slug($request->name)
            ]);
            $trans = $this->transaction->create($request->all());
            if ($request->withDetail == "on") {
                for ($i = 0; $i < count($request->detail_name); $i++) {
                    // $data = [];
                    if (is_numeric($request->detail_name[$i])) {
                        $product = Product::find($request->detail_name[$i]);
                        $data = [
                            "product_id" => $request->detail_name[$i],
                            "name" => $product->name,
                            "price" => $product->price,
                            "qty" => $request->detail_qty[$i],
                            "amount" => $request->detail_qty[$i] * $product->price
                        ];
                    } else {
                        $data = [
                            "name" => $request->detail_name[$i],
                            "price" => $request->detail_amount[$i],
                            "qty" => $request->detail_qty[$i],
                            "amount" => $request->detail_qty[$i] * $request->detail_amount[$i]
                        ];
                    }
                    $trans->details()->create($data);
                }
            }
            DB::commit();
            return redirect()->back()->with('success-message', 'Data telah disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error-message', $e->getMessage());
        }
    }

    // detail transaksi
    public function show($id)
    {
        $data = Transaction::find($id);
        $accounts = Account::all();
        return view('admin.transaction.show', compact(['data', 'accounts']));
    }

    // halaman edit transaksi
    public function edit($id)
    {
        $data = Transaction::find($id);
        $accounts = Account::all();
        return view('admin.transaction.edit', compact(['data', 'accounts']));
    }

    // update transaksi
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'account_id' => 'required',
            'description' => 'required',
            'transaction_type' => 'required',
            'transaction_date' => 'required',
            'amount' => 'required|numeric|min:1'
        ]);
        DB::beginTransaction();
        try {
            if ($request->has('image')) {
                $fileName = Str::uuid();

                $img = $request->image->storeAs(
                    'public/image/transaction',
                    $fileName . '.' . $request->image->extension()
                );
                $request->merge([
                    'images' => preg_replace("/public\/image\//", "", $img)
                ]);
            }
            $this->transaction->find($id)->update($request->all());

            DB::commit();
            return redirect()->route('transaction.index', $this->transaction->find($id)->transaction_type)->with('success-message', 'Data telah d irubah');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error-message', $e->getMessage());
        }
    }

    // hapus transaksi
    public function destroy($id)
    {
        $this->transaction->destroy($id);
        return redirect()->back()->with('success-message', 'Data telah dihapus');
    }
}
