@extends('admin.layouts')
@section('title','Tambah Data')
@section('content')
<div class="col-lg-12">
    {{-- <div class="card border-left-primary"> --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
        </div>
        <div class="card-body">
            <form action="{{route('product.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                        <label>Nama</label>
                            <input type="text" id="" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required="">
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Harga</label>
                            <input type="number" id="" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" name="price" value="{{ old('price') }}" required="">
                            @if ($errors->has('price'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Gambar</label>
                            <div id="uploads"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-gorup">
                            <button type="submit" class="btn btn-primary btn-sm shadow-sm">Simpan</button>
                            <a class="btn btn-light btn-sm shadow-sm" href="{{route('product.index')}}">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
$(document).ready(function () {
    uploadHBR.init({
        "target": "#uploads",
        "textNew": "Add Photo",
        // "textNew": "<i class='fa fa-plus'></i>",
        "max":1
    });

});
</script>
@endpush
