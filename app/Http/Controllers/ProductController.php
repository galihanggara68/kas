<?php

namespace App\Http\Controllers;

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
    public function index()
    {
        return view("admin.product.index");
    }

    public function select2Products(Request $request){
        $products = Product::where('name', 'like', '%'.$request->q.'%')->get();
        return response()->json($products ?? []);
    }

    public function ajaxProduct(Request $request){
        $product = Product::find($request->id);
        return response()->json($product ? $product->only(['id', 'name', 'price']) : null);
    }

    public function source(){
        $query= Product::query();
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
            ->addColumn('price', function ($data) {
                return Str::title($data->price);
            })
            ->addColumn('image', function ($data) {
                $img = explode("/", $data->image);
                return '<img src="'.route("image.displayImage", [$img[0], $img[1], true]).'" />';
            })
            ->addIndexColumn()
            ->addColumn('action', 'admin.product.index-action')
            ->rawColumns(['action', 'image'])
            ->toJson();
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
            if($request->has('image')){
                $fileName = Str::uuid();

                $request->image->storeAs(
                    'public/image/product',$fileName.'.'.$request->image->extension()
                );
                $image = 'product/'.$fileName.'.'.$request->image->getClientOriginalExtension();
                $data['image'] = $image;
            }
            $data['slug'] = Str::slug($request->name);
            Product::create($data);
            DB::commit();
            return redirect()->back()->with('success-message','Data telah disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error-message',$e->getMessage());
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
        return view('admin.product.edit',compact('data'));

    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'price' => 'required|numeric'
        ]);
        DB::beginTransaction();
        try {
            $request = $request->merge(['slug'=>$request->name]);
            Product::find($id)->update($request->all());
            DB::commit();
            return redirect()->route('product.index')->with('success-message','Data telah d irubah');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error-message',$e->getMessage());
        }

    }

    public function destroy($id)
    {
        Product::destroy($id);
        return redirect()->route('product.index')->with('success-message','Data telah dihapus');
    }
}
