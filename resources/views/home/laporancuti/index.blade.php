@extends('layouts.master')

@section('title', 'Laporan Cuti')

@section('content')
<div class="container mt-5">
    <div class="text-center mb-4">
        <h4 style="font-size: 24px; font-weight: bold; color: #000;">LAPORAN DATA CUTI</h4>
        <p style="font-size: 18px; font-weight: bold; color: #000;">PT DWIMETAL TEKNIK INDONESIA</p>
        <p style="font-size: 16px; color: #000;"><em>Tahun {{ date('Y') }}</em></p>
        <hr style="border: 2px solid #000;">
    </div>
    <table class="table table-bordered mt-4" style="font-size: 16px; border: 2px solid #000;">
        <thead>
            <tr style="background-color: #f0f0f0; color: #000; font-weight: bold;">
                <th>ID Staff</th>
                <th>Nama</th>
                <th>Posisi</th>
                <th>Kuota Cuti</th>
                <th>Cuti Terpakai</th>
                <th>Sisa Cuti</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporancuti as $laporancuti)
                <tr style="color: #000; font-weight: 500;">
                    <td>{{ $laporancuti['id_staff'] }}</td>
                    <td>{{ $laporancuti['nama'] }}</td>
                    <td>{{ $laporancuti['posisi'] }}</td>
                    <td>{{ $laporancuti['kuota_cuti'] }}</td>
                    <td>{{ $laporancuti['cuti_terpakai'] }}</td>
                    <td>{{ $laporancuti['sisa_cuti'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<style>
    @media print {
        /* Hanya elemen laporan yang terlihat saat mencetak */
        body * {
            visibility: hidden;
        }
        .container, .container * {
            visibility: visible;
        }
        .container {
            position: absolute;
            left: 0;
            top: 0;
        }
        /* Atur semua teks menjadi hitam penuh */
        h4, p, table, th, td {
            color: #000 !important;
        }
        th, td {
            border: 2px solid #000; /* Border tabel lebih tebal */
        }
        hr {
            border-color: #000; /* Border garis pemisah lebih tebal dan hitam */
        }
    }

    /* Gaya umum saat tampil di browser */
    h4, p {
        color: #000; /* Warna hitam penuh untuk teks */
    }
    table {
        border-collapse: collapse; /* Menghilangkan border ganda */
        border: 2px solid #000; /* Border tabel lebih tebal */
    }
    th, td {
        border: 2px solid #000; /* Border antar sel lebih tebal */
        padding: 10px; /* Padding sel tabel */
    }
</style>

<script>
    window.onload = function() {
        window.print(); // Langsung mencetak saat halaman dimuat
    };
</script>
@endsection
