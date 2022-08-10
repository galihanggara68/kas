@extends('admin.layouts')
@section('title','Tambah Transaksi')
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
            @if($errors->any())
                {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
            @endif
        </div>
        <div class="card-body">
            <form action="{{route('transaction.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" autocomplete="off" autofocus="" required="">
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                            <input type="hidden" name="transaction_type" value="{{$transaction_type}}" readonly="">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Jenis Akun</label>
                            <select name="account_id" class="form-control{{ $errors->has('account_id') ? ' is-invalid' : '' }}" value="{{ old('account_id') }}" required="">
                                @foreach ($accounts as $account)
                                    <option value="{{$account->id}}">{{title_case($account->name)}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('account_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('account_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" name="transaction_date" class="form-control{{ $errors->has('transaction_date') ? ' is-invalid' : '' }}" value="{{ old('transaction_date') }}" autocomplete="off" required="">
                            @if ($errors->has('transaction_date'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('transaction_date') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Jumlah</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                </div>
                                <input type="number" id="amount" name="amount" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" value="{{ old('amount') }}" aria-describedby="basic-addon1" require="" value="0" />
                                @if ($errors->has('amount'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ old('description') }}" rows="5"></textarea>
                            @if ($errors->has('description'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="withDetail" id="withDetail" />
                                Sertakan Detail Transaksi
                            </label>
                        </div>
                    </div>
                    <div class="transaction-details" id="transaction-details">
                        <div class="col-12">
                            <div class="form-group">
                                <label>List Detail Transaksi</label>
                                <button type="button" id="btnAddTrans" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></button>
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <div class="row" id="detail-0">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Nama Pemasukan / Produk</label>
                                                        <select name="detail_name[]" class="form-control select2" style="width: 100%">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Jumlah/Harga</label>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                                            </div>
                                                            <input type="number" name="detail_amount[]" class="form-control price" min="0" value="0" required/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group qty">
                                                        <label>Qty</label>
                                                        <input type="number" name="detail_qty[]" class="form-control qty" min="1" value="1" required/>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>

                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Gambar</label>
                            <input type="file" name="image" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-gorup">
                            <button type="submit" class="btn btn-primary btn-sm shadow-sm">Simpan</button>
                            <a class="btn btn-light btn-sm shadow-sm" href="{{route('transaction.index', $transaction_type)}}" data-dismiss="">Batal</a>
                            {{-- <a class="btn btn-light btn-sm shadow-sm" href="{{route('transaction.index')}}">Batal</a> --}}
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".transaction-details").hide();
            $("#withDetail").change(function(){
                if($(this).is(":checked")){
                    $("input#amount").attr("readonly", "");
                    $(".transaction-details").show();
                }else{
                    $("input#amount").removeAttr("readonly");
                    $(".transaction-details").hide();
                }
            });

            $("#btnAddTrans").click(function(e){
                e.preventDefault();
                var id = $(".list-group li").length;
                var html = '<li class="list-group-item">'+
                                '<div class="row">'+
                                    '<div class="col-md-2">'+
                                        '<button class="btn btn-sm btn-danger btnDeleteTrans"><i class="fa fa-minus"></i></button>'+
                                    '</div>'+
                                '<div class="row" id="detail-'+id+'">'+
                                    '<div class="col-6">'+
                                        '<div class="form-group">'+
                                            '<label>Nama Pemasukan / Produk</label>'+
                                            '<select name="detail_name[]" class="form-control select2" style="width: 100%">'+
                                            '</select>'+
                                        '</div>';
                html += '</div>';
                html += '<div class="col-6">';
                html += '<div class="form-group">';
                html += '<label>Jumlah/Harga</label>';
                html += `<div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                                            </div>
                                                            <input type="number" name="detail_amount[]" class="form-control price" min="0" value="0" required/>
                                                        </div>`;
                html += '</div>';
                html += '</div>';
                html += '<div class="col-6">';
                html += '<div class="form-group qty">';
                html += '<label>Qty</label>';
                html += '<input type="number" name="detail_qty[]" class="form-control form-control-sm qty" min="1" value="1" required/>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '</li>';
                $(".list-group").append(html);
                configSelect2();
            });

            $("#transaction-details ul").click("button.btnDeleteTrans", function(e){
                e.preventDefault();
                console.log(e.target.type);
                if(e.target.type == "submit"){
                    $(e.target).parent().parent().parent().remove();
                }
            });

            $("ul").change(".price, .qty", function(e){
                console.log($(e.target).val());
                recalculateAmount();
            });

            function recalculateAmount(){
                if($("#withDetail").is(":checked")){
                    var total = 0;
                    $(".price").each(function(i, v){
                        // console.log(v);
                        price = isNaN($("#detail-"+i+" > div:nth-child(2) > div input").val()) ? 0 : parseInt($("#detail-"+i+" > div:nth-child(2) > div input").val());
                        qty = isNaN($("#detail-"+i+" > div:nth-child(3) > div input").val()) ? 0 : parseInt($("#detail-"+i+" > div:nth-child(3) > div input").val());
                        total += qty * price;
                        console.log("Total", total);
                    });
                    $("input#amount").val(total);
                }
            }

            function configSelect2(){
                $(".select2").select2({
                    tags: true,
                    placeholder: "Pilih nama pemasukan / produk",
                    minimumInputLength: 3,
                    width: "resolve",
                    ajax: {
                        url: "{{route('product.products')}}",
                        dataType: 'json',
                        processResults: function (data) {
                            // Transforms the top-level key of the response object from 'items' to 'results'
                            return {
                                results: data.map(d => {
                                    return {
                                        id: d.id,
                                        text: d.name || d.text
                                    }
                                })
                            };
                        }
                    }
                }).on("change", (e) => {
                    var id = e.target.value;
                    $.ajax({
                        url: "{{route('product.ajax.product')}}",
                        data: {id: id, _token: "{{csrf_token()}}"},
                        type: "POST",
                        dataType: "json",
                        success: function(data){
                            let priceElem = $(e.target).parent().parent().parent().find("input.price");
                            if(data.price){
                                priceElem.attr("readonly", "");
                                console.log(priceElem);
                                priceElem.val(data.price);
                            }else{
                                priceElem.removeAttr("readonly");
                            }
                        }
                    });
                    recalculateAmount();
                });
            }
            configSelect2();

            uploadHBR.init({
                "target": "#uploads",
                "textNew": "Add Photo",
                // "textNew": "<i class='fa fa-plus'></i>",
                "max":1
            });
        });
    </script>
@endpush
