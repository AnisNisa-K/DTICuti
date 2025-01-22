@extends('layouts.master')
@section('title', 'Cuti Tambah')
@section('content')

    <h2 class="card-title"> Halaman Tambah Data Cuti</h2>
    <a href="/cuti" class="btn btn-warning"><i class="bi bi-arrow-left"></i> Kembali</a>
    <br> <br>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-light shadow-sm components-section">
                <div class="card-body">
                    <form action="{{ route('cuti.store') }}" method="post">
                        @csrf
                        <!-- Tambah Nama Staff -->
                        <div class="mb-3">
                            <label for="id_staff" class="form-label">Nama Staff</label>
                            <input class="form-control" list="staff_list" id="id_staff" name="id_staff" placeholder="Masukkan ID atau Nama Staff" required>
                            <datalist id="staff_list">
                                @foreach ($staffList as $staff)
                                    <option value="{{ $staff->id }} - {{ $staff->nama }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                        <!-- Tambah Tanggal Mulai -->
                        <div class="mb-4">
                            <label for="tgl_mulai">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai" required>
                        </div>
                        <!-- Tambah Tanggal Selesai -->
                        <div class="mb-4">
                            <label for="tgl_selesai">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai" required>
                        </div>
                        <!-- Tambah Durasi -->
                        <div class="mb-4">
                            <label for="durasi">Durasi</label>
                            <input type="number" class="form-control" id="durasi" name="durasi" readonly required>
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const tglMulai = document.getElementById('tgl_mulai');
                                    const tglSelesai = document.getElementById('tgl_selesai');
                                    const durasi = document.getElementById('durasi');

                                    function hitungDurasi() {
                                        const startDate = new Date(tglMulai.value);
                                        const endDate = new Date(tglSelesai.value);

                                        if (tglMulai.value && tglSelesai.value && endDate >= startDate) {
                                            const timeDiff = endDate - startDate; // Selisih waktu dalam milidetik
                                            const daysDiff = timeDiff / (1000 * 60 * 60 * 24) + 1; // Konversi ke hari, +1 agar inklusif
                                            durasi.value = daysDiff; // Tampilkan hasil ke input durasi
                                        } else {
                                            durasi.value = ''; // Kosongkan durasi jika input tidak valid
                                        }
                                    }

                                    tglMulai.addEventListener('change', hitungDurasi);
                                    tglSelesai.addEventListener('change', hitungDurasi);
                                });
                            </script>
                        </div>
                        <!-- Tambah Alasan -->
                        <div class="mb-4">
                            <label for="alasan">Alasan
                                <select name="alasan" id="alasan" class="form-control">
                                    <option value="" disabled selected>Pilih Jenis Cuti</option>
                                    <option value="sakit">Cuti Sakit</option>
                                    <option value="pernikahan">Cuti Pernikahan</option>
                                    <option value="hamilmelahirkan">Cuti Hamil dan Melahirkan</option>
                                    <option value="kematian">Kematian Keluarga Dekat</option>
                                </select>
                            </label>
                        </div>
                        <div class="mb-4">
                            <label for="alasan_lain">Alasan Lain</label>
                            <input type="text" class="form-control" id="alasan_lain" name="alasan_lain">
                        </div>
                        <!-- Tombol Simpan -->
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@if ($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '{{ $errors->first() }}',
    });
</script>
@endif

@endsection
