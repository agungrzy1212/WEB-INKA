<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'course_name',
        'nama_lengkap',
        'tanggal_lahir',
        'alamat',
        'nomer_hp',
        'email',
        'ijazah_path',
        'ktp_path',
        'kk_path',
        'pas_foto_path',
        'payment_receipt_path',
        'status',
        'admin_notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
