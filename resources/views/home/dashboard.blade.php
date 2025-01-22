@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')

<main class="">

    <nav class="navbar navbar-top navbar-expand navbar-dashboard navbar-dark ps-0 pe-2 pb-0">
<div class="container-fluid px-0">
<div class="d-flex justify-content-between w-100" id="navbarSupportedContent">
    <div class="d-flex align-items-center">
        <div class="navbar-welcome">
            <h5 class="mb-0 text-primary fw-bold">Halo, {{ Auth::user()->username }}!</h5>
            <p class="mb-0 text-muted">Selamat datang di dashboard, semoga harimu menyenangkan!</p>
        </div>
    </div>
<!-- Navbar links -->
<ul class="navbar-nav align-items-center">
  <li class="nav-item dropdown">
    <a class="nav-link text-dark me-lg-3 icon-notifications dropdown-toggle" data-unread-notifications="true" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <span class="icon icon-sm">
        <span class="fas fa-envelope-open-text"></span>
        <span class="icon-badge rounded-circle unread-notifications"></span>
      </span>
    </a>
    <div class="dropdown-menu dashboard-dropdown dropdown-menu-lg dropdown-menu-center mt-2 py-0">
        <div class="list-group list-group-flush">
            <a href="#" class="text-center text-primary fw-bold border-bottom border-light py-3">Pengajuan Cuti</a>
            @forelse ($pengajuanCuti as $cuti)
                @foreach ($cuti->detailCuti as $detail)
                    <a href="{{ route('user.detail-pengajuan', $cuti->id) }}" class="list-group-item list-group-item-action border-bottom border-light">
                        <div class="row align-items-center">
                            <div class="col ps-0 ms-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="h6 mb-0 text-small">{{ $detail->staff->nama ?? 'Tidak Diketahui' }}</h4>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-danger">{{ $cuti->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                <p class="font-small mt-1 mb-0">
                                    Pengajuan cuti dari {{ $detail->tgl_mulai }} hingga {{ $detail->tgl_selesai }}.
                                    Durasi: {{ $detail->durasi }} hari. <br> Alasan: {{ $detail->alasan }}
                                </p>
                            </div>
                        </div>
                    </a>
                @endforeach
            @empty
                <a href="#" class="list-group-item list-group-item-action border-bottom border-light">
                    <div class="row align-items-center">
                        <div class="col">
                            <p class="text-center text-muted mb-0">Tidak ada pengajuan cuti saat ini.</p>
                        </div>
                    </div>
                </a>
            @endforelse
            <a href="{{ route('cuti.index') }}" class="dropdown-item text-center text-primary fw-bold rounded-bottom py-3">Lihat Semua</a>
        </div>
    </div>
  </li>
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle pt-1 px-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <div class="media d-flex align-items-center">
            <img class="user-avatar md-avatar rounded-circle"
                 src="{{ asset('assets/images/user.png') }}"
                 style="width: 50px; height: 50px;"> <!-- Ubah ukuran avatar -->
            <div class="media-body ms-2 text-dark align-items-center d-none d-lg-block">
                <span class="mb-0 font-small fw-bold" style="font-size: 1.2rem;">{{ $user->username }}</span> <!-- Ubah ukuran font -->
            </div>
        </div>

    </a>
    <div class="dropdown-menu dashboard-dropdown dropdown-menu-end mt-2 py-0">
        <a class="dropdown-item rounded-top fw-bold" href="/user/{{ $user->id }}/show"><span class="far fa-user-circle"></span>Profil Saya</a>
        <div role="separator" class="dropdown-divider my-0"></div>
        <a class="dropdown-item rounded-bottom fw-bold" href="{{ route('actionLogout') }}"><span class="fas fa-sign-out-alt text-danger"></span>Logout</a>
    </div>
  </li>
</ul>
</div>
</div>
</nav>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="btn-toolbar dropdown">
            {{-- <button class="btn btn-dark btn-sm me-2 dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="fas fa-plus me-2"></span>New Task
            </button> --}}
        </div>
        {{-- <div class="btn-group">
            <button type="button" class="btn btn-sm btn-outline-primary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-primary">Export</button>
        </div> --}}
    </div>
    <div class="row justify-content-md-center">
        <div class="col-12 mb-4">
            <div class="card bg-secondary-alt shadow-sm">
                <div class="card-header d-sm-flex flex-row align-items-center flex-0">
                    <div class="d-block mb-3 mb-sm-0">
                        <div class="h5 fw-normal mb-2">Trend Cuti Staff</div>
                        <h2 class="h3">PT. DWIMETAL TEKNIK INDONESIA</h2>
                        {{-- <div class="d-flex align-items-center mt-3">
                            <span class="fw-bold me-3">Pilih Tampilan:</span>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    Perbulan
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="#" data-value="monthly">Perbulan</a></li>
                                    <li><a class="dropdown-item" href="#" data-value="yearly">Pertahun</a></li>
                                </ul>
                            </div>
                        </div> --}}
                    </div>
                    {{-- <div class="d-flex ms-auto">
                        <a href="#" class="btn btn-secondary text-dark btn-sm me-2">Approve</a>
                        <a href="#" class="btn btn-dark btn-sm me-3">Rejected</a>
                    </div> --}}
                </div>
                <div class="card-body p-2">
                    <canvas id="leaveStatusChart" style="height: 300px; max-width: 100%;"></canvas> <!-- Mengatur tinggi dan lebar -->
                    <script>
                        const ctx = document.getElementById('leaveStatusChart').getContext('2d');
                        const leaveStatusChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ['Approved', 'Rejected'],
                                datasets: [{
                                    label: 'Jumlah Cuti',
                                    data: [{{ $approvedCuti }}, {{ $rejectedCuti }}], // Pastikan ini adalah angka total
                                    backgroundColor: [
                                        'rgba(75, 192, 192, 0.5)', // Warna untuk Approved
                                        'rgba(255, 99, 132, 0.5)'  // Warna untuk Rejected
                                    ],
                                    borderColor: [
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(255, 99, 132, 1)'
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false, // Membuat grafik responsif
                                scales: {
                                    y: {
                                        beginAtZero: true, // Mulai dari 0
                                        min: 0, // Nilai minimum
                                        ticks: {
                                            stepSize: 1 // Menentukan interval label
                                        },
                                        title: {
                                            display: true,
                                            text: 'Jumlah' // Judul sumbu Y
                                        }
                                    },
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Status Cuti' // Judul sumbu X
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: true,
                                        position: 'top' // Tempatkan legend di atas
                                    },
                                    title: {
                                        display: true,
                                        text: 'Grafik Status Cuti' // Judul grafik
                                    }
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-light shadow-sm">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon icon-shape icon-md icon-shape-primary rounded me-4 me-sm-0"><span class="fas fa-user-cog"></span></div>
                            {{-- <div class="d-sm-none">
                                <h2 class="h5">Admin</h2>
                                <h3 class="mb-1">345,678</h3>
                            </div> --}}
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h5">Jumlah Admin</h2>
                                <h3 class="mb-1">{{ $totalUser }}</h3>
                                Pengelola
                            </div>
                            {{-- <small>Feb 1 - Apr 1,  <span class="icon icon-small"><span class="fas fa-globe-europe"></span></span> WorldWide</small> --}}
                            <div class="small mt-2">
                                <span class="fas fa-angle-up text-success"></span>
                                <a href="" class=""></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-light shadow-sm">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon icon-shape icon-md icon-shape-secondary rounded me-4"><span class="fas fa-users"></span></div>
                            {{-- <div class="d-sm-none">
                                <h2 class="h5">Jumlah Staff</h2>
                                <h3 class="mb-1">{{ $totalStaff }}</h3>
                            </div> --}}
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h5">Jumlah Staff</h2>
                                <h3 class="mb-1">{{ $totalStaff }}</h3>
                                Aktif
                            </div>
                            {{-- <small>Feb 1 - Apr 1,  <span class="icon icon-small"><span class="fas fa-globe-europe"></span></span> Worldwide</small> --}}
                            <div class="small mt-2">
                                <span class="fas fa-angle-up text-success"></span>
                                <span class="text-success fw-bold"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-light shadow-sm">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="ct-chart-traffic-share ct-golden-section ct-series-a"></div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <h2 class="h5 mb-3">Jumlah Cuti</h2>
                            <h3 class="mb-1">{{ $totalCuti }}</h3> Terdata
                            <div class="small mt-2">
                                <span class="fas fa-angle-up text-success"></span>
                                <span class="text-success fw-bold"></span>
                            </div>
                            {{-- <h6 class="fw-normal text-gray"><span class="icon w-20 icon-xs icon-secondary me-1"><span class="fas fa-desktop"></span></span> Desktop <a href="#" class="h6">60%</a></h6>
                            <h6 class="fw-normal text-gray"><span class="icon w-20 icon-xs icon-primary me-1"><span class="fas fa-mobile-alt"></span></span> Mobile Web <a href="#" class="h6">30%</a></h6>
                            <h6 class="fw-normal text-gray"><span class="icon w-20 icon-xs icon-tertiary me-1"><span class="fas fa-tablet-alt"></span></span> Tablet Web <a href="#" class="h6">10%</a></h6> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: "{{ session('error') }}",
    });
</script>
@endif

</main>
@endsection
