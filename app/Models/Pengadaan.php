<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengadaan extends Model
{
    use Loggable;
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'kode_pengadaan',
        'pengaju_id',
        'total_harga',
        'status',
        'alasan_penolakan',
        'tanggal_pengajuan',
        'tanggal_disetujui',
        'tanggal_selesai',
        'bukti_pembelian',
    ];

    // Relasi ke tabel users
    public function pengaju()
    {
        return $this->belongsTo(User::class, 'pengaju_id');
    }

    public function items()
    {
        return $this->hasMany(PengadaanItem::class);
    }

}
