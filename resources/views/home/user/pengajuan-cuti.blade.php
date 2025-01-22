@extends('layouts.master')
@section('title', 'Tampilan Pesan Masuk')
@section('content')
<h1>Pengajuan Cuti</h1>

<div class="inbox-container" style="display: flex; flex-direction: column; gap: 1rem; max-width: 600px; margin: auto;">
    @forelse ($pengajuanCuti as $cuti)
        <div class="inbox-item" style="display: flex; align-items: center; background: #f9f9f9; padding: 1rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <div class="inbox-details" style="flex: 1;">
                <p style="margin: 0;"><strong>{{ $cuti->staff->nama }}</strong></p>
                <p style="margin: 0;">{{ $cuti->detailCuti->alasan ?? 'Pengajuan cuti' }}</p>
                <span class="time" style="font-size: 0.8rem; color: #888;">{{ $cuti->formatted_time }}</span>
            </div>
        </div>
    @empty
        <p style="text-align: center;">Tidak ada pengajuan cuti masuk.</p>
    @endforelse
</div>

<a href="/user/pengajuan-cuti" class="view-all" style="display: block; text-align: center; margin: 1rem auto; color: #007bff; text-decoration: none;">View All</a>
@endsection
