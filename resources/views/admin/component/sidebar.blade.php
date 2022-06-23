<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-left justify-content-left" href="#">
        <div class="sidebar-brand-icon">
                <img width="30" src="{{asset('assets/img/favicon.ico')}}" />
        </div>
        <div class="sidebar-brand-text">{{App\Setting::where('slug','nama-toko')->get()->first()->description}}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Menu
    </div>

    <li class="nav-item {{active('dashboard')}}">
        <a class="nav-link" href="{{route('dashboard')}}">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>
        <!-- Divider -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Transaksi
    </div>
    <li class="nav-item {{active(route('transaction.index','income'))}}">
        <a class="nav-link" href="{{route('transaction.index','income')}}">
            <i class="fas fa-fw fa-download"></i>
            <span>Pendapatan</span>
        </a>
    </li>
    <li class="nav-item {{active(route('transaction.index','expense'))}}">
        <a class="nav-link" href="{{route('transaction.index','expense')}}">
            <i class="fas fa-fw fa-upload"></i>
            <span>Pengeluaran</span>
        </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Master Data & Laporan
    </div>
    <li class="nav-item {{active('report.index')}}">
        <a class="nav-link" href="{{route('report.index')}}">
            <i class="fas fa-fw fa-file"></i>
            <span>Laporan</span>
        </a>
    </li>
    @if (Auth::user()->role->slug == 'super-admin')
    <li class="nav-item {{active('account.index')}}">
        <a class="nav-link" href="{{route('account.index')}}">
            <i class="fas fa-fw fa-file-invoice"></i>
            <span>Akun</span>
        </a>
    </li>
    <li class="nav-item {{active('product.index')}}">
        <a class="nav-link" href="{{route('product.index')}}">
            <i class="fas fa-fw fa-box"></i>
            <span>Produk</span>
        </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Setting & User
    </div>
    <li class="nav-item {{active('setting.index')}}">
        <a class="nav-link" href="{{route('setting.index')}}">
            <i class="fas fa-fw fa-cog"></i>
            <span>Setting</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{is_active('user.index') || is_active('role.index') ? '':'collapsed'}}" href="#" data-toggle="collapse" data-target="#user" aria-expanded="true" aria-controls="user">
            <i class="fas fa-fw fa-user"></i>
            <span>User</span>
        </a>
        <div id="user" class="collapse {{is_active('user.index') || is_active('role.index')  ? 'show':''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item {{active('user.index')}}" href="{{route('user.index')}}">Pengguna</a>
            <a class="collapse-item {{active('role.index')}}" href="{{route('role.index')}}">Hak Akses</a>
            </div>
        </div>
    </li>
    @endif
</ul>
<!-- End of Sidebar -->
