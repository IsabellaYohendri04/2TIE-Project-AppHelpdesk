<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'nim',
        'nama_mahasiswa',
        'category_id',   // ⬅️ GANTI dari 'kategori'
        'judul',
        'deskripsi',
        'status',
        'assigned_to',
    ];

    public const STATUS_BARU = 'baru';
    public const STATUS_PROSES = 'proses';
    public const STATUS_SELESAI = 'selesai';
    public const STATUS_DITOLAK = 'ditolak';

    public static function daftarStatus(): array
    {
        return [
            self::STATUS_BARU    => 'Baru',
            self::STATUS_PROSES  => 'Sedang Diproses',
            self::STATUS_SELESAI => 'Selesai',
            self::STATUS_DITOLAK => 'Ditolak',
        ];
    }

    // relasi ke staff
    public function staff()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
