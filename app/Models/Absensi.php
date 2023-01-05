<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;


     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'pengaturan_id',
        'waktu_id',
        'keterangan_id',
        'tanggal',
        'status',
        'shift',
        'time'
    ];

    public function user () {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function pengaturan() {
        return $this->belongsTo(Pengaturan::class, 'pengaturan_id', 'id');
    }

    public function waktu() {
        return $this->belongsTo(Waktu::class, 'waktu_id', 'id');
    }

    public function keterangan() {
        return $this->belongsTo(Keterangan::class, 'keterangan_id', 'id');
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
