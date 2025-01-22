<?php

namespace App\Models;

use App\Models\DetailCuti;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    protected $fillable = [
        'id_user',
        'id_staff',
        'status'
    ];

    // Relasi ke Model User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relasi ke Model Staff
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'id_staff', 'id');
    }

    public function detailCuti()
    {
        return $this->hasMany(DetailCuti::class, 'id_cuti', 'id'); 
    }

}
