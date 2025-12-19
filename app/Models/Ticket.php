<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'nim',
        'nama_mahasiswa',
        'kategori',
        'judul',
        'deskripsi',
        'status',
        'assigned_to',
    ];

    public const STATUS_BARU = 'baru';
    public const STATUS_PROSES = 'proses';
    public const STATUS_SELESAI = 'selesai';
    public const STATUS_DITOLAK = 'ditolak';

    public const KATEGORI_LUPA_SIAK = 'lupa_password_siak';
    public const KATEGORI_WIFI = 'gangguan_wifi';
    public const KATEGORI_EMAIL = 'email_kampus';
    public const KATEGORI_APLIKASI_LAIN = 'aplikasi_akademik_lain';

    public static function daftarStatus(): array
    {
        return [
            self::STATUS_BARU => 'Baru',
            self::STATUS_PROSES => 'Sedang Diproses',
            self::STATUS_SELESAI => 'Selesai',
            self::STATUS_DITOLAK => 'Ditolak',
        ];
    }

    public static function daftarKategori(): array
    {
        return [
            self::KATEGORI_LUPA_SIAK => 'Lupa Password SIAK',
            self::KATEGORI_WIFI => 'Gangguan WiFi Kampus',
            self::KATEGORI_EMAIL => 'Masalah Email Kampus',
            self::KATEGORI_APLIKASI_LAIN => 'Aplikasi Akademik Lainnya',
        ];
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}


