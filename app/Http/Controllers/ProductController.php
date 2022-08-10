<?php

namespace App\Http\Controllers;

use App\DataTables\ProductDatatables;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ProductDatatables $dataTables)
    {
        return $dataTables->render("admin.product.index");
    }

    public function select2Products(Request $request)
    {
        $products = Product::where('name', 'like', '%' . $request->q . '%')->get();
        return response()->json($products ?? []);
    }

    public function ajaxProduct(Request $request)
    {
        $product = Product::find($request->id);
        return response()->json($product ? $product->only(['id', 'name', 'price']) : null);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'price' => 'required|numeric'
        ]);
        DB::beginTransaction();
        try {
            $data = $request->all();
            if ($request->has('image')) {
                $fileName = Str::uuid();

                $img = $request->image->storeAs(
                    'public/image/product',
                    $fileName . '.' . $request->image->extension()
                );
                $image = preg_replace("/public\/image\//", "", $img);
                $data['image'] = $image;
            }
            $data['slug'] = Str::slug($request->name);
            Product::create($data);
            DB::commit();
            return redirect()->back()->with('success-message', 'Data telah disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error-message', $e->getMessage());
        }
    }

    public function show($id)
    {
        $data = Product::find($id);
        return $data;
    }

    public function edit($id)
    {
        $data = Product::find($id);
        return view('admin.product.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'price' => 'required|numeric'
        ]);
        DB::beginTransaction();
        try {
            $request = $request->merge(['slug' => $request->name]);
            $data = $request->all();
            if ($request->has('image')) {
                $fileName = Str::uuid();

                $img = $request->image->storeAs(
                    'public/image/product',
                    $fileName . '.' . $request->image->extension()
                );
                $image = preg_replace("/public\/image\//", "", $img);
                $data['image'] = $image;
            }
            Product::find($id)->update($data);
            DB::commit();
            return redirect()->route('product.index')->with('success-message', 'Data telah d irubah');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error-message', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        Product::destroy($id);
        return redirect()->route('product.index')->with('success-message', 'Data telah dihapus');
    }
}
