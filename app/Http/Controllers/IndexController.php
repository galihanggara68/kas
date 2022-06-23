<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;
use App\Transaction;
use Illuminate\Filesystem\Filesystem;

class IndexController extends Controller
{
    public function __construct()
    {
        $this->transaction = new Transaction();
    }

    public function index(){
        $transaction  = $this->transaction;
        $income_transaction =$this->transaction->where('transaction_type','income')->get();
        $expense_transaction =$this->transaction->where('transaction_type','expense')->get();
        $saldo = $income_transaction->sum('amount') - $expense_transaction->sum('amount');

        return view('admin.dashboard.index',compact(['transaction','income_transaction','expense_transaction','saldo']));
    }

    public function displayImage($filetype, $filename, $resize = false){
        $path = storage_path('app/public/image/' . $filetype . "/" . $filename);
        $fs = new Filesystem();
        if (!$fs->exists($path)) {
            abort(404);
        }

        if($resize){
            $response = $this->resize_image($path);
        }else{
            $file = $fs->get($path);
            $response = response()->make($file, 200);
        }

        $type = $fs->mimeType($path);
        $response->header("Content-Type", $type);
        return $response;
    }

    private function resize_image($filename){
        $image_resize = Image::make($filename);
        $image_resize->resize(200, 200, function($constraint){
            $constraint->aspectRatio();
        });
        return $image_resize->response("jpg");
    }
}
