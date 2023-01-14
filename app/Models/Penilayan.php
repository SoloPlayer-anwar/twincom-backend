<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilayan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name_pemberi',
        'jabatan_pemberi',
        'cabang_pemberi',
        'pemahaman_tugas',
        'kecekatan_bekerja',
        'kreatifitas_bekerja',
        'pengambil_keputusan',
        'kejujuran',
        'kedewasaan_berpikir',
        'tanggung_jawab',
        'kemandirian',
        'disiplin',
        'antusias',
        'komunikasi',
        'kerjasama_team',
        'empati',
        'tanggal',
    ];

    public function user () {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }
}
