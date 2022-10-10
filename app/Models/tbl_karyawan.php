<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_karyawan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "tbl_karyawan";
    protected $fillable = ['nama_karyawan', 'jabatan', 'umur', 'alamat', 'foto'];
}
