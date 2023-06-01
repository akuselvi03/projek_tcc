<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class guest extends Model
{
    protected $table = 'guests';
    protected $primarykey = 'id';
    public  $timestamps = true;
    protected $fillable = [
        'nama_tamu',
        'nomor_hp',
        'nomor_kamar',
        'tipe_kamar',
        'tanggal_booking',
        'metode_pembayaran',
        'harga',
    ];

}
