<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogLogin extends Model
{
    protected $table = 'log_login';
    protected $primaryKey = 'id_log';

    protected $fillable = [
        'user_id',
        'username',
        'role',
        'aktivitas',
        'waktu',
    ];

    public function getWaktuLaluAttribute()
    {
        return Carbon::parse($this->waktu)->diffForHumans();
    }
}
