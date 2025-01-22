@extends('layouts.master')
@section('title', 'Staff Edit')
@section('content')

    <h2 class="card-title"> Halaman Edit Data Staff</h2>
    <a href="/staff" class="btn btn-warning"><i class="bi bi-arrow-left"></i> Kembali</a>
    <br> <br>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-light shadow-sm components-section">
                <div class="card-body">
                    <form action="/staff/{{ $staff->id }}/update" method="post">
                        @csrf
                        <!-- Edit Nama -->
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input class="form-control" type="text" value="{{ $staff->nama }}" id="nama" name="nama">
                        </div>
                        <!-- Edit Posisi -->
                        <div class="mb-4">
                            <label for="posisi">Posisi</label>
                            <input type="text" class="form-control" value="{{ $staff->posisi }}"id="posisi" name="posisi" required>
                        </div>
                        <!-- Edit Kuota Cuti -->
                        <div class="mb-4">
                            <label for="kuota_cuti">Kuota Cuti</label>
                            <input type="number" class="form-control" value="{{ $staff->kuota_cuti }}"id="kuota_cuti" name="kuota_cuti" required>
                        </div>
                        <!-- Edit Sisa Cuti -->
                        <div class="mb-4">
                            <label for="sisa_cuti">Sisa Cuti</label>
                            <input type="number" class="form-control" value="{{ $staff->sisa_cuti }}" id="sisa_cuti" name="sisa_cuti" required>
                        </div>
                        <!-- Tombol Simpan Update-->
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
