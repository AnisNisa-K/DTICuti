@extends('layouts.master')

@section('title', 'Detail Pengajuan Cuti')

@section('content')
<div class="container mt-5">

    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Informasi Pengajuan Cuti</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Nama Staff</th>
                    <td>{{ $pengajuanCuti->staff->nama }}</td>
                </tr>

                {{-- Ambil detail cuti pertama dari koleksi --}}
                @if($pengajuanCuti->detailCuti->isNotEmpty())
                    @php $detailCuti = $pengajuanCuti->detailCuti->first(); @endphp
                    <tr>
                        <th>Tanggal Mulai</th>
                        <td>{{ $detailCuti->tgl_mulai }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Selesai</th>
                        <td>{{ $detailCuti->tgl_selesai }}</td>
                    </tr>
                    <tr>
                        <th>Durasi</th>
                        <td>{{ $detailCuti->durasi }} hari</td>
                    </tr>
                    <tr>
                        <th>Alasan</th>
                        <td>{{ $detailCuti->alasan ?? 'Tidak ada alasan.' }}</td>
                    </tr>
                @else
                    <tr>
                        <th colspan="2" class="text-center">Detail cuti tidak ditemukan.</th>
                    </tr>
                @endif

                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge
                            @if($pengajuanCuti->status === 'Pending') bg-warning
                            @elseif($pengajuanCuti->status === 'Approved') bg-success
                            @elseif($pengajuanCuti->status === 'Rejected') bg-danger
                            @endif">
                            {{ $pengajuanCuti->status }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="text-center mt-4">
        <form action="{{ route('user.pengajuan.update', $pengajuanCuti->id) }}" method="POST" class="d-inline-block">
            @csrf
            <button type="submit" name="status" value="Approved" class="btn btn-success mx-2">
                <i class="fas fa-check-circle"></i> Approve
            </button>
            <button type="submit" name="status" value="Rejected" class="btn btn-danger mx-2">
                <i class="fas fa-times-circle"></i> Reject
            </button>
        </form>
    </div>
</div>
@endsection
