<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use Loggable;
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'nama',
        'deskripsi',
    ];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'category_id');
    }
}
