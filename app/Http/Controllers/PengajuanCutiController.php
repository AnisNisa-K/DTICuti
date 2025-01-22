<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\User;
use App\Models\Cuti;
use App\Models\DetailCuti;

class PengajuanCutiController extends Controller
{
    // Method untuk menangani pengiriman formulir pengajuan cuti (STORE NAMANYA)
    public function kirimPengajuanCuti(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_staff' => 'required|exists:staff,id',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'durasi' => 'nullable|integer|min:1',
            'alasan' => 'nullable|string',
            'alasan_lain' => 'nullable|string',
        ]);

        // Pastikan salah satu alasan diisi
        if (empty($request->alasan) && empty($request->alasan_lain)) {
            return redirect()->back()->withErrors(['alasan' => 'Harap isi salah satu alasan!']);
        }

        // Hitung durasi cuti
        $durasi = (new \DateTime($request->tgl_selesai))
            ->diff(new \DateTime($request->tgl_mulai))
            ->days + 1; // Menambahkan 1 untuk menghitung tanggal mulai

        // Ambil data staff
        $staff = Staff::find($request->id_staff);

        // Jika alasan_lain diisi, periksa kuota cuti
        $cutiToDeduct = 0;
        if (!empty($request->alasan_lain)) {
            $cutiToDeduct = $durasi; // Pengurangan jika alasan_lain diisi

            // Ini buat mengecek sisa cuti kalo ada pengurangan
            if ($staff->sisa_cuti < $cutiToDeduct) {
                return redirect()->back()->withErrors(['durasi' => 'Sisa cuti tidak mencukupi untuk pengajuan ini.']);
            }

            // Kurangi kuota cuti
            $staff->sisa_cuti -= $cutiToDeduct;
            $staff->save();
        }

        // Simpan data cuti
        $cuti = new Cuti();
        $cuti->id_user = auth()->user()->id;
        $cuti->id_staff = $request->id_staff;
        $cuti->status = 'Pending'; // Status awal
        $cuti->save();

        // Simpan detail cuti
        $detailCuti = new DetailCuti();
        $detailCuti->id_user = auth()->user()->id;
        $detailCuti->id_cuti = $cuti->id;
        $detailCuti->id_staff = $request->id_staff;
        $detailCuti->tgl_mulai = $request->tgl_mulai;
        $detailCuti->tgl_selesai = $request->tgl_selesai;
        $detailCuti->durasi = $durasi;
        $detailCuti->alasan = $request->alasan ?: $request->alasan_lain; // Prioritas ke alasan_lain jika ada
        $detailCuti->save();

        return redirect('/staff/pengajuancuti')->with(['success' => 'Pengajuan cuti berhasil dikirim!']);
    }

    public function index()
    {
        $pengajuanCuti = Cuti::with(['detailCuti', 'staff'])->where('status', 'Pending')->get();
        return view('home.user.pengajuan-cuti', compact('pengajuanCuti'));
    }


    // Menyetujui (Approve) pengajuan cuti
    public function approve($id)
    {
        // Ambil pengajuan cuti berdasarkan ID
        $cuti = Cuti::find($id);

        // Ambil detail cuti untuk mendapatkan durasi
        $detailCuti = DetailCuti::where('id_cuti', $cuti->id)->first();

        // Pastikan detail cuti ditemukan
        if (!$detailCuti) {
            return redirect()->back()->withErrors(['error' => 'Detail cuti tidak ditemukan.']);
        }

        // Ambil staff yang bersangkutan
        $staff = Staff::find($cuti->id_staff);

        // Hanya kurangi kuota jika alasan_lain diisi
        $cutiToDeduct = 0;
        if (!empty($detailCuti->alasan_lain)){
            $cutiToDeduct = $detailCuti->durasi;
        }
        // Cek sisa cuti
        if ($staff->sisa_cuti < $detailCuti->$cutiToDeduct) {
            return redirect()->back()->withErrors(['error' => 'Sisa cuti tidak mencukupi.']);
        }

        // Kurangi sisa cuti sesuai durasi dari detail cuti
        $staff->sisa_cuti -= $cutiToDeduct;
        $staff->save();

        // Update status pengajuan cuti
        $cuti->status = 'Approved'; // Ubah status menjadi approved
        $cuti->save();

        // Redirect dengan pesan sukses
        return redirect()->back()->with(['success' => 'Pengajuan cuti berhasil disetujui!']);
    }

    // Menolak (Reject) pengajuan cuti
    public function reject($id)
    {
        $cuti = Cuti::find($id);

        $cuti->status = 'Rejected';
        $cuti->save();

        return redirect('/dashboard')->with(['success' => 'Pengajuan cuti berhasil ditolak!']);
    }

    public function dashboard()
    {
        // Mengambil jumlah cuti yang di-approve
        $approvedCuti = Cuti::where('status', 'approved')->count();

        // Mengambil jumlah cuti yang di-reject
        $rejectedCuti = Cuti::where('status', 'rejected')->count();

        $pengajuanCuti = Cuti::with(['detailCuti', 'staff'])->where('status', 'Pending')->get();
        $details = DetailCuti::all(); // Ambil semua data DetailCuti

        // Hitung jumlah pengajuan cuti yang Pending
        $unreadCount = $pengajuanCuti->count();

        // Tampilin total user, total staff, total cuti di dashboard (lagi)
        $totalUser = User::count();
        $totalStaff = Staff::count();
        $totalCuti = Cuti::count();

        return view('home.dashboard', compact('pengajuanCuti', 'details', 'totalUser', 'totalStaff', 'totalCuti', 'unreadCount', 'approvedCuti', 'rejectedCuti'));
    }

    // Buat tampilan detail pengajuan cuti + ubah statusnya
    public function detail($id)
    {
        $pengajuanCuti = Cuti::with('detailCuti', 'staff')->find($id);

        if (!$pengajuanCuti) {
            return redirect()->back()->with(['error' => 'Pengajuan tidak ditemukan!']);
        }

        $detailCuti = $pengajuanCuti->detailCuti->first();

        return view('home.user.detail-pengajuan', compact('pengajuanCuti', 'detailCuti'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'status' => 'required|in:Approved,Rejected',
        ]);

        // Ambil data pengajuan cuti berdasarkan ID
        $cuti = Cuti::find($id);

        // Jika status Approved
        if ($request->status == 'Approved') {
            // Ambil detail cuti dan data staff
            $detailCuti = DetailCuti::where('id_cuti', $cuti->id)->first();

            $staff = Staff::find($cuti->id_staff);

        // Untuk memeriksa alasan_lain diisi
        $cutiToDeduct = 0;
        if (!empty($detailCuti->alasan_lain)) {
            $cutiToDeduct = $detailCuti->durasi;
        }

        // Cek sisa cuti
        if ($staff->sisa_cuti < $cutiToDeduct) {
            return redirect()->back()->withErrors(['error' => 'Sisa cuti tidak mencukupi untuk pengajuan cuti ini!.']);
        }

            // Kurangi sisa cuti staff
            $staff->sisa_cuti -= $cutiToDeduct;
            $staff->save();
        }

    // Update status pengajuan cuti
    $cuti->status = $request->status;
    $cuti->save();

    // Redirect kembali dengan pesan sukses
    return redirect()->back()->with('success', 'Status pengajuan cuti berhasil diperbarui!');
}



}
