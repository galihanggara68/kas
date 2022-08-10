@extends('admin.layouts')
@section('title', 'Laporan Transaksi')
@section('content')
    <div class="col-lg-12">
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
            </div>
            <div class="card-body">
                <div class="card-header">
                    <form id="frm-export" action="{{ route('report.export.detail') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Dari Tanggal</label>
                                    <input type="date" name="start_date" id="from_date"
                                        class="form-control{{ $errors->has('start_date') ? ' is-invalid' : '' }}"
                                        autocomplete="off" required="">
                                    @if ($errors->has('start_date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('start_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Sampai Tanggal</label>
                                    <input type="date" name="end_date" id="to_date"
                                        class="form-control{{ $errors->has('end_date') ? ' is-invalid' : '' }}"
                                        autocomplete="off" required="">
                                    @if ($errors->has('end_date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('end_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                {!! $dataTable->table() !!}
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/js/sweet-alert.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    {{-- {!! $dataTable->scripts() !!} --}}
    <script>
        $(document).ready(function() {
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var min = $("#from_date").val();
                    var max = $("#to_date").val();
                    var date = new Date(data[5]);

                    if (
                        (min === null && max === null) ||
                        (min === null && date <= max) ||
                        (min <= date && max === null) ||
                        (min <= date && date <= max)
                    ) {
                        return true;
                    }
                    return false;
                }
            );

            $("#report-table").DataTable({
                "serverSide": true,
                "processing": true,
                "ajax": {
                    "url": "{{ route('report.index') }}",
                    "type": "GET",
                    "data": function(data) {
                        for (var i = 0, len = data.columns.length; i < len; i++) {
                            if (!data.columns[i].search.value)
                                delete data.columns[i].search;
                            if (data.columns[i].searchable === true)
                                delete data.columns[i].searchable;
                            if (data.columns[i].orderable === true)
                                delete data.columns[i].orderable;
                            if (data.columns[i].data === data.columns[i].name)
                                delete data.columns[i].name;
                        }
                        delete data.search.regex;
                    }
                },
                "columns": [{
                    "data": "name",
                    "name": "name",
                    "title": "Nama Transaksi",
                    "orderable": true,
                    "searchable": true,
                    "width": 200
                }, {
                    "data": "account.name",
                    "name": "account.name",
                    "title": "Akun",
                    "orderable": true,
                    "searchable": true,
                    "width": 150
                }, {
                    "data": "transaction_type",
                    "name": "transaction_type",
                    "title": "Tipe Transaksi",
                    "orderable": true,
                    "searchable": true,
                    "width": 100
                }, {
                    "data": "amount",
                    "name": "amount",
                    "title": "Jumlah",
                    "orderable": true,
                    "searchable": true,
                    "width": 100
                }, {
                    "data": "description",
                    "name": "description",
                    "title": "Deskripsi",
                    "orderable": true,
                    "searchable": true,
                    "width": 200
                }, {
                    "data": "transaction_date",
                    "name": "transaction_date",
                    "title": "Tanggal Transaksi",
                    "orderable": true,
                    "searchable": true,
                    "width": 100
                }, {
                    "data": "created_at",
                    "name": "created_at",
                    "title": "Tanggal Dibuat",
                    "orderable": true,
                    "searchable": true,
                    "width": 100
                }],
                "buttons": [{
                        "extend": "excel",
                        "text": "Export Excel <i class='fa fa-file-excel'></i>",
                        "className": "btn btn-success mt-4",
                        "exportOptions": {
                            "modifier": {
                                "page": "all",
                                "search": "none"
                            }
                        },
                        "customize": function(xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            var colCount = $("#report-table").DataTable().columns()
                                .header().length;
                            var rowCount = $("#report-table").DataTable().data().length +
                                1;
                            ["Pendapatan", "Pengeluaran"].map((d, di) => {
                                let newRow = `<row  r='${(rowCount+2+di)}'>`;
                                newRow +=
                                    `<c t='inlineStr' r='C${(rowCount+2+di)}' s='2'><is><t>Total ${d}</t></is></c>`;
                                for (let i = 68; i < 69; i++) {
                                    let col = (rowCount + 2 + di);
                                    let range =
                                        `${String.fromCharCode(i)}3:${String.fromCharCode(i)}${(rowCount+1)}`;
                                    let total = 0;
                                    for (let x = 3; x <= rowCount + 1; x++) {
                                        let cell = $(`c[r=${String.fromCharCode(i)}${x}] v`,
                                            sheet);
                                        let transType = $(`c[r=C${x}] t`, sheet);
                                        if (!isNaN(cell.text()) && cell.text() != '' &&
                                            transType.text().trim() == d) {
                                            total += parseInt(cell.text());
                                        }
                                    }
                                    newRow +=
                                        `<c t='n' r='${String.fromCharCode(i)}${col}' s='2'><v>${total}</v></c>`;
                                }
                                newRow += `</row>`;
                                $('sheetData', sheet).append(newRow);
                            });
                        }
                    },
                    {
                        "text": "Reset Filter",
                        "className": "btn btn-info mt-4",
                        "action": function(e, dt, node, config) {
                            $("#from_date").val('');
                            $("#to_date").val('');
                            dt.search('').draw();
                        }
                    }
                ],
                "scrollX": "true",
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "dom": "Bflrtip",
                "order": [
                    [0, "asc"]
                ]
            });


            $('#from_date, #to_date').on('change', function() {
                window.LaravelDataTables['report-table'].ajax.url(
                    `?start_date=${$('#from_date').val()}&end_date=${$('#to_date').val()}`).load();
            });

            function delay(callback, ms) {
                var timer = 0;
                return function() {
                    var context = this,
                        args = arguments;
                    clearTimeout(timer);
                    timer = setTimeout(function() {
                        callback.apply(context, args);
                    }, ms || 0);
                };
            }
            $('body').tooltip({
                selector: '[data-toggle="tooltip"]'
            });
        });
    </script>
@endpush
