<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rejected_transaction extends Model
{
    use HasFactory;

    protected $table = 'rejected_transactions';

    protected $fillable = [
        'id',
        'tanggal',
        'jenis',
        'kategori',
        'jumlah',
        'keterangan',
        'gambar',
    ];
}
