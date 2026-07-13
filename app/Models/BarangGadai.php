<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangGadai extends Model
{
    protected $table = 'barang_gadai';

    protected $fillable = [
        'nama_barang',
        'kategori',
        'taksiran_nilai',
        'nama_nasabah',
        'no_hp',
        'tanggal_gadai',
        'status',
        'catatan',
    ];

    public const KATEGORI = ['elektronik', 'kendaraan'];
    public const STATUS = ['aktif', 'ditebus', 'lelang'];

    protected $casts = [
        'tanggal_gadai' => 'date',
        'taksiran_nilai' => 'decimal:2',
    ];
}
