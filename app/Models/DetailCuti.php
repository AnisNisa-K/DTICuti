<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailCuti extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_cuti',
        'id_staff',
        'tgl_mulai',
        'tgl_selesai',
        'durasi',
        'alasan',
        'alasan_lain',
    ];

    // Relasi ke model Cuti
    public function cuti()
    {
        return $this->belongsTo(Cuti::class, 'id_cuti', 'id');
    }

    // Relasi ke model Staff
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'id_staff', 'id');
    }
}

