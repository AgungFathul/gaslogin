<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
     protected $table = 'tournaments';
    protected $fillable = [
        'nama', 'url', 'jadwal_mulai', 'jadwal_selesai', 'deskripsi', 'tipe', 'alamat', 'hadiah', 'rules'
    ];
    
    //Contoh relasi dengan User, jika ada
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
