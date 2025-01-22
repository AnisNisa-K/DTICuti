@extends('layouts.master')
@section('title', 'Detail Cuti')
@section('content')

<div class="card mx-auto" style="max-width: 500px; margin-top: 20px;">
    <div class="card-header text-center">
        <h4>Detail Cuti</h4>
    </div>
    <div class="card-body">
        <p><strong>ID Cuti:</strong> {{ $cuti->id }}</p>
        <p><strong>Nama Admin:</strong> {{ $cuti->user->name }}</p>
        <p><strong>Nama Staff:</strong> {{ $cuti->staff->nama }}</p>
        <p><strong>Status:</strong> {{ $cuti->status }}</p>
        @foreach ($cuti->detailCuti as $detail_cuti)
        <p><strong>Tanggal Mulai:</strong> {{ $detail_cuti->tgl_mulai }}</p>
        <p><strong>Tanggal Selesai:</strong> {{ $detail_cuti->tgl_selesai }}</p>
        <p><strong>Durasi:</strong> {{ $detail_cuti->durasi }} hari</p>
        <p><strong>Alasan:</strong> {{ $detail_cuti->alasan }}</p>
        <p><strong>Alasan Lain:</strong> {{ $detail_cuti->alasan_lain }}</p>
        @endforeach

        <a href="{{ route('cuti.index') }}" class="btn btn-primary d-block mt-3">Kembali</a>
    </div>
</div>

@endsection
