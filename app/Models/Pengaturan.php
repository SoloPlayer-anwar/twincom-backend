<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cabang',
        'lat',
        'long',
        'radius',
        'user_id',
        'shift'
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function absensi() {
        return $this->hasManyThrough(Absensi::class, 'pengaturan_id', 'id');
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
