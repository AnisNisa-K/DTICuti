<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Cuti;
use Illuminate\Http\Request;

class LaporanCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staffs = Staff::all();
        $laporancuti = [];

        foreach ($staffs as $staff) {
            // Hitung jumlah cuti terpakai berdasarkan id_staff
            $cutiTerpakai = Cuti::where('id_staff', $staff->id)->count(); // Menghitung jumlah cuti terpakai

            $laporancuti[] = [
                'id_staff' => $staff->id,
                'nama' => $staff->nama,
                'posisi' => $staff->posisi,
                'kuota_cuti' => $staff->kuota_cuti,
                'cuti_terpakai' => $cutiTerpakai, // Menggunakan hasil hitungan cuti terpakai
                'sisa_cuti' => $staff->sisa_cuti,
            ];
        }

        return view('home.laporancuti.index', compact('laporancuti'));
    }
}

