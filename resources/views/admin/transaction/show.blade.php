@extends('admin.layouts')
@section('title','Detail Transaksi')
@section('content')
<style>
    #transaction-details .btnDeleteTrans i{
        pointer-events: none;
    }
</style>
<div class="col-lg-12">
    <div class="card mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" disabled name="name" class="form-control" autocomplete="off" value="{{$data->name}}" autofocus="" required="">
                        <input type="hidden" name="transaction_type" value="{{$data->transaction_type}}" readonly="">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Jenis Akun</label>
                        <select name="account_id" class="form-control" disabled>
                            @foreach ($accounts as $account)
                                <option {{$data->account->id == $account->id ? "selected" : null}} value="{{$account->id}}">{{title_case($account->name)}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" disabled name="transaction_date" class="form-control" autocomplete="off" value="{{$data->transaction_date}}" required="">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Jumlah</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                            </div>
                            <input type="number" disabled id="amount" name="amount" class="form-control" aria-describedby="basic-addon1"  require="" value="{{$data->amount}}" {{count($data->details) > 0 ? "readonly" : null}}/>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" disabled class="form-control" rows="5">{{$data->description}}</textarea>
                    </div>
                </div>

                @if(count($data->details) > 0)
                    <div class="col-12">
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="withDetail" id="withDetail" {{count($data->details) > 0 ? "disabled" : null}} readonly />
                                Sertakan Detail Transaksi
                            </label>
                        </div>
                    </div>
                    <div class="transaction-details" id="transaction-details">
                        <div class="col-12">
                            <div class="form-group">
                                <label>List Detail Transaksi</label>
                                    <ul class="list-group">
                                        @foreach ($data->details as $detail)
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>Nama Pemasukan / Produk</label>
                                                            <input type="text" value="{{$detail->name}}" class="form-control" style="width: 100%" readonly />
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>Jumlah/Harga</label>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                                                </div>
                                                                <input type="number" value="{{$detail->price}}" class="form-control price" min="0" value="0" readonly/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group qty">
                                                            <label>Qty</label>
                                                            <input type="number" value="{{$detail->qty}}" class="form-control qty" min="0" value="0" readonly/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-12">
                    <div class="form-group">
                        <label>Gambar</label>
                        <img width="200" src="{{$data->images ? route('image.displayImage', [$data->images, true]) : asset("assets/img/no-image.png")}}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-gorup">
                        <a href="{{route('transaction.index', $data->transaction_type)}}" type="button" class="btn btn-success btn-sm shadow-sm" href="#" data-dismiss="">Kembali</a>
                        {{-- <a class="btn btn-light btn-sm shadow-sm" href="{{route('transaction.index')}}">Batal</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            uploadHBR.init({
                "target": "#uploads",
                "textNew": "Add Photo",
                // "textNew": "<i class='fa fa-plus'></i>",
                "max":1
            });
        });
    </script>
@endpush
