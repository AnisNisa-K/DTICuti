@extends('layouts.master')
@section('title', 'Staff Tambah')
@section('content')

    <h2 class="card-title"> Halaman Tambah Data Staff</h2>
    <a href="/staff" class="btn btn-warning"><i class="bi bi-arrow-left"></i> Kembali</a>
    <br> <br>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-light shadow-sm components-section">
                <div class="card-body">
                    <form action="/staff/simpan" method="post" enctype="multipart/form-data">
                        @csrf
                        <!-- Tambah Nama -->
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input class="form-control" type="text" id="nama" name="nama">
                        </div>
                        <!-- Posisi -->
                        <div class="mb-4">
                            <label for="posisi">Posisi</label>
                            <input type="text" class="form-control" id="posisi" name="posisi" required>
                        </div>
                        <!-- Kuota CUTI -->
                        <div class="mb-4">
                            <label for="kuota_cuti">Kuota Cuti</label>
                            <input type="number" class="form-control" id="kuota_cuti" name="kuota_cuti" required>
                        </div>
                        <!-- Tambah Sisa Cuti -->
                        <div class="mb-4">
                            <label for="sisa_cuti">Sisa Cuti</label>
                            <input type="number" class="form-control" id="sisa_cuti" name="sisa_cuti" required>
                        </div>
                        <!-- Tombol Simpan -->
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
