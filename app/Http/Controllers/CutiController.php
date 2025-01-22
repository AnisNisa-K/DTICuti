<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Cuti;
use App\Models\DetailCuti;
use Illuminate\Http\Request;

class CutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data cuti beserta relasi user dan staff
        $cuti = Cuti::with(['user', 'staff'])->get();
        return view('home.cuti.index', compact('cuti'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $staffList = Staff::all(['id', 'nama']);
        return view('home.cuti.tambah', compact('staffList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validasi
        $validatedData = $request->validate([
            'id_staff' => 'required|string',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'durasi' => 'required|integer|min:1',
            'alasan' => 'nullable|string',
            'alasan_lain' => 'nullable|string',
        ]);

        // Ekstrak ID Staff dari input
        $idStaffInput = $validatedData['id_staff'];
        $idStaff = explode(' - ', $idStaffInput)[0];

         // Ambil data staff
         $staff = Staff::find($idStaff);
         if (!$staff) {
             return redirect()->back()->with('error', 'Staff tidak ditemukan!');
         }

         // Hitung durasi dan alert
         $durasi = (new \DateTime($validatedData['tgl_selesai']))->diff(new \DateTime($validatedData['tgl_mulai']))->days + 1;
        if ($staff->sisa_cuti < $durasi) {
            return redirect()->back()->withErrors([
                'durasi' => 'Durasi cuti melebihi sisa cuti yang tersedia.',
            ]);
        }

        // Simpan  cuti
        $cuti = new Cuti();
        $cuti->id_user = auth()->user()->id;
        $cuti->id_staff = $idStaff;
        $cuti->status = 'Approved';
        $cuti->save();

        // Simpan detail
        $detail_cuti = new DetailCuti();
        $detail_cuti->id_user = auth()->user()->id;
        $detail_cuti->id_cuti = $cuti->id;
        $detail_cuti->id_staff = $idStaff;
        $detail_cuti->tgl_mulai = $validatedData['tgl_mulai'];
        $detail_cuti->tgl_selesai = $validatedData['tgl_selesai'];
        $detail_cuti->durasi = $validatedData['durasi'];
        $detail_cuti->alasan = $validatedData['alasan'] ?? null;
        $detail_cuti->alasan_lain = $validatedData['alasan_lain'] ?? null;
        $detail_cuti->save();

        // Kurangi sisa cuti di tabel staff
        $staff->sisa_cuti -= $validatedData['durasi'];
        $staff->save();

        return redirect ('/cuti')->with(['success' => 'Data cuti berhasil disimpan']);
    }

    public function bulkDelete(Request $request)
    {
        // Validasi bahwa ada data yang dipilih
        $validatedData = $request->validate([
            'selected' => 'required|array',
            'selected.*' => 'exists:cutis,id', // Pastikan ID
        ]);

        // Hapus detail cuti terlebih dahulu
        DetailCuti::whereIn('id_cuti', $validatedData['selected'])->delete();

        // Hapus data cuti
        Cuti::whereIn('id', $validatedData['selected'])->delete();

        return redirect()->route('cuti.index')->with(['success' => 'Data cuti yang dipilih berhasil dihapus.']);
    }

    public function show($id)
    {
        $cuti = Cuti::with(['user', 'staff', 'detailCuti'])->find($id);
        $detail_cuti = $cuti->detailCuti;

        return view('home.cuti.detail', compact('cuti', 'detail_cuti'));
    }

    public function destroy(string $id)
    {
        $cuti = Cuti::find($id);
        $cuti->delete();
        return redirect('/cuti')->with('success', 'Data berhasil dihapus.');
    }

}
