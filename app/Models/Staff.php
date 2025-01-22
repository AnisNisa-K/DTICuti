<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    // PAKE UUID
    protected $table = 'staff';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'nama',
        'posisi',
        'kuota_cuti',
        'sisa_cuti'
    ];

    // Relasi ke Model Cuti
    public function cuti()
    {
        return $this->hasMany(Cuti::class, 'id_staff', 'id');
    }
    public function detailCuti()
    {
        return $this->hasMany(DetailCuti::class, 'id_staff', 'id');
    }

}
