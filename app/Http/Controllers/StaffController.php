<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staff = Staff::all();
        return view('home.staff.index', compact('staff'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('home.staff.tambah');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'nama' => 'required',
        'posisi' => 'required',
        'kuota_cuti' => 'required|integer',
        'sisa_cuti' => 'required|integer',
    ]);

    // Generate ID baru
    $lastStaff = Staff::orderBy('id', 'desc')->first();
    $newId = $lastStaff ? (int)$lastStaff->id + 1 : 15000; // mulai dari 15000

    // Simpan staff baru
    Staff::create([
        'id' => $newId, // Tambahkan ID baru
        'nama' => $request->nama,
        'posisi' => $request->posisi,
        'kuota_cuti' => $request->kuota_cuti,
        'sisa_cuti' => $request->sisa_cuti,
    ]);

    return redirect('/staff')->with(['success' => 'Staff berhasil ditambahkan!']);
}



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $staff = Staff::find($id);
        return view('home.staff.edit', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi
        $request->validate([
            'nama' => 'required|string|max:255',
            'posisi' => 'required|string|max:255',
            'kuota_cuti' => 'required|integer|min:0',
        ]);

        // Update data staff
        $staff = Staff::find($id);
        $staff->update([
            'nama' => $request->nama,
            'posisi' => $request->posisi,
            'kuota_cuti' => $request->kuota_cuti,
            'sisa_cuti' => $request->sisa_cuti,
        ]);

        return redirect('/staff')->with(['success' => 'Data staff berhasil diperbarui.']);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Cari nama staff pake query
        $staffs = Staff::where('nama', 'LIKE', '%' . $query . '%')
            ->select('id', 'nama') // Pilih data yang akan ditampilkan
            ->get();

        return response()->json($staffs);
    }

    // Untuk menampilkan sisa cuti berdaarkan nama yg di input staff
    public function getSisaCuti($id)
    {
        // Mengambil data staff berdasarkan ID
        $staff = Staff::find($id);

        if ($staff) {
            // Asumsikan Anda memiliki atribut 'sisa_cuti' di model Staff
            return response()->json(['sisa_cuti' => $staff->sisa_cuti]);
        }

        return response()->json(['sisa_cuti' => 0], 404); // Jika staff tidak ditemukan
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $staff = Staff::find($id);
        $staff->delete();
        return redirect('/staff')->with(['success' => 'Data staff berhasil dihapus.']);
    }
}
