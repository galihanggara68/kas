<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin | @yield('title')</title>
    <link href="{{asset('assets/img/favicon.ico')}}" rel="icon" type="image/ico">
    <!-- Custom fonts for this template-->
    <link href="{{asset('assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/datatables-bootstrap.min.css')}}" rel="stylesheet">

    <link href="{{asset('assets/vendor/uploadHBR/css/style.min.css')}}" rel="stylesheet">
    {{-- animate css --}}
    <link href="{{asset('assets/vendor/aos/css/aos.css')}}" rel="stylesheet">
    <style>

        body{
            font-family: 'Roboto', sans-serif;
        }
        label{
            font-weight: bolder;
        }



        label.active {
            color: #4285F4 !important;
        }

    </style>
</head>

<body id="page-top" class="">

    <!-- Page Wrapper -->
    <div id="wrapper">
        @include('admin.component.sidebar')
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                @include('admin.component.navbar')
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    {{-- <div class="d-sm-flex align-items-center justify-content-between mb-4"> --}}
                        {{-- <h1 class="h3 mb-0 text-gray-800">@yield('title')</h1> --}}
                        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>        --}}
                    {{-- </div> --}}

                    <!-- Content Row -->
                    <div class="row">
                        @include('admin.component.success')
                        @include('admin.component.error')
                        @yield('content')
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            @include('admin.component.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apakah anda yakin?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih tombol "Logout" untuk keluar. "Cancel" untuk batal keluar</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{route('logout')}}">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}" type="text/javascript"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{asset('assets/vendor/jquery-easing/jquery.easing.min.js')}}" type="text/javascript"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('assets/js/sb-admin-2.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/style.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/jquery-datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables-bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/vendor/uploadHBR/js/modernizr.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/vendor/uploadHBR/js/uploadHBR.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/vendor/aos/js/aos.js')}}" type="text/javascript"></script>
    @stack('scripts')
</body>
</html>
