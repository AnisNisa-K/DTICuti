<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Staff;
use App\Models\Cuti;
use App\Models\DetailCuti;
use App\Models\PengajuanCuti;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil jumlah cuti yang di-approve
        $approvedCuti = Cuti::where('status', 'approved')->count();

        // Mengambil jumlah cuti yang di-reject
        $rejectedCuti = Cuti::where('status', 'rejected')->count();

        $user = Auth::user();
        $totalUser = User::count();
        $totalStaff = Staff::count();
        $totalCuti = Cuti::count();
        $details = DetailCuti::all();

        // Load pengajuan cuti dengan relasi detailCuti dan staff
        $pengajuanCuti = Cuti::with(['detailCuti', 'staff'])->latest()->take(5)->get();

        return view('home.dashboard', compact('user','totalUser', 'totalStaff', 'totalCuti', 'pengajuanCuti', 'details',  'approvedCuti', 'rejectedCuti'));


    }

}
