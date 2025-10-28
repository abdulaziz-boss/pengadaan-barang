<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'category_id',
        'stok',
        'stok_minimal',
        'satuan',
        'harga_satuan',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
