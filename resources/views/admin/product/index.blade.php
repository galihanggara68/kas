@extends('admin.layouts')
@section('title','Produk')
@section('content')
<div class="col-lg-12">
    <div class="card shadow-sm mb-4">
        <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
        </div>
        <div class="card-body">
            {!! $dataTable->table() !!}
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('assets/js/sweet-alert.min.js') }}"></script>
{!! $dataTable->scripts() !!}
<script>
$(document).ready(function () {

    $.fn.dataTable.ext.errMode = 'throw';

    $('#product-table_wrapper > div.toolbar').html(
                '<div class="row">'+
                '<div class="col-md-2">'+
                    '<a href="{{ route("product.create") }}" class="btn btn-primary shadow-sm float-left mb-4" data-toggle="tooltip" title="Tambah Data"><i class="fas fa-plus"></i></a>'+
                '</div>' +
                '</div>');

    function delay(callback, ms) {
        var timer = 0;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
                callback.apply(context, args);
            }, ms || 0);
        };
    }

    $(document).on('keyup','#search-box',delay(function(e){
        e.preventDefault();
        $table.search($(this).val()).draw();
    },500));


    $('#product-table').on('click','a.delete-data',function(e) {
        e.preventDefault();
        var delete_link = $(this).attr('href');
        swal({
            title: "Hapus Data ini?",
            text: "",
            icon: "error",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal({
                        title:"Data anda terhapus",
                        icon: "success"
                    })
                    .then(()=>{
                        fetch(delete_link);
                    })
                    .then(()=>{
                        $table.ajax.reload(null,false);
                    });
                } else {
                    swal({
                        title: "Data anda aman",
                        icon: "info"
                    });
                }
            });
    });

    $('body').tooltip({selector: '[data-toggle="tooltip"]'});
});
</script>
@endpush
