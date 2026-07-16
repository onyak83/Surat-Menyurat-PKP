 <!-- Sidebar -->
 <div class="sidebar" data-background-color="dark">
     <div class="sidebar-logo">
         <!-- Logo Header -->
         <div class="logo-header" data-background-color="dark">
             <a href="index.html" class="logo">
                 <img src="{{ asset('assets/img/logo_edit.png') }}" alt="navbar brand" class="navbar-brand"
                     height="50" />
             </a>

             <div class="nav-toggle">
                 <button class="btn btn-toggle toggle-sidebar">
                     <i class="gg-menu-right"></i>
                 </button>
                 <button class="btn btn-toggle sidenav-toggler">
                     <i class="gg-menu-left"></i>
                 </button>
             </div>
             <button class="topbar-toggler more">
                 <i class="gg-more-vertical-alt"></i>
             </button>
         </div>
         <!-- End Logo Header -->
     </div>

     <div class="sidebar-wrapper scrollbar scrollbar-inner">
         <div class="sidebar-content">
             <ul class="nav nav-secondary">
                 <li class="nav-item active">
                     <a href="{{ route('dashboard') }}" class="collapsed" aria-expanded="false">
                         <i class="fas fa-home"></i>
                         <p>Dashboard</p>
                     </a>
                 </li>
                 <li class="nav-section">
                     <span class="sidebar-mini-icon">
                         <i class="fa fa-ellipsis-h"></i>
                     </span>
                     <h4 class="text-section">Surat Menyurat</h4>
                 </li>

                 <li class="nav-item">
                     <a href="{{ route('index.Surat') }}">
                         <i class="fas fa-envelope"></i>
                         <p>Surat</p>
                     </a>
                 </li>


                 <li class="nav-item">
                     <a data-bs-toggle="collapse" href="#base">
                         <i class="fas fa-layer-group"></i>
                         <p>Laporan</p>
                         <span class="caret"></span>
                     </a>
                     <div class="collapse" id="base">
                         <ul class="nav nav-collapse">
                             <li>
                                 <a href="{{ route('index.AgendaSuratMasuk') }}">
                                     <span class="sub-item">Buku Agenda Surat Masuk</span>
                                 </a>
                             </li>
                             <li>
                                 <a href="components/avatars.html">
                                     <span class="sub-item">Buku Ekspedisi Surat Keluar</span>
                                 </a>
                             </li>
                             <li>
                                 <a href="components/buttons.html">
                                     <span class="sub-item">Rekapitulasi Surat</span>
                                 </a>
                             </li>
                             <li>
                                 <a href="{{ route('index.ArsipDigital') }}">
                                     <span class="sub-item">Arsip Surat Digital</span>
                                 </a>
                             </li>
                             <li>
                                 <a href="components/gridsystem.html">
                                     <span class="sub-item">Statistik Surat</span>
                                 </a>
                             </li>

                         </ul>
                     </div>
                 </li>

                 <li class="nav-section">
                     <span class="sidebar-mini-icon">
                         <i class="fa fa-ellipsis-h"></i>
                     </span>
                     <h4 class="text-section">Manajemen Data</h4>
                 </li>

                 <li class="nav-item">
                     <a href="{{ route('index.User') }}">
                         <i class="fas fa-users"></i>
                         <p>User</p>
                     </a>
                 </li>

                 <li class="nav-item">
                     <a href="{{ route('index.SifatSurat') }}">
                         <i class="far fa-envelope"></i>
                         <p>Sifat Surat</p>
                     </a>
                 </li>

                 <li class="nav-item">
                     <a href="{{ route('index.Instansi') }}">
                         <i class="fas fa-building"></i>
                         <p>Instansi</p>
                     </a>
                 </li>

                 <li class="nav-section">
                     <span class="sidebar-mini-icon">
                         <i class="fa fa-ellipsis-h"></i>
                     </span>
                     <h4 class="text-section">Logout</h4>
                 </li>

                 <li class="nav-item">
                     <a href="{{ route('logout') }}"
                         onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                         <i class="fas fa-sign-out-alt"></i>
                         <p>Keluar</p>
                     </a>

                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                         @csrf
                     </form>
                 </li>

             </ul>
         </div>
     </div>
 </div>
 <!-- End Sidebar -->
