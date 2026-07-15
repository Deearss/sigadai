<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangGadai extends Model
{
    use HasFactory;
    protected $table = 'barang_gadai';

    protected $fillable = [
        'nama_barang',
        'kategori',
        'taksiran_nilai',
        'jangka_waktu',
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
        'tanggal_jatuh_tempo' => 'date',
        'taksiran_nilai' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (BarangGadai $barang) {
            $barang->tanggal_jatuh_tempo = $barang->tanggal_gadai?->copy()->addDays((int) $barang->jangka_waktu);
        });
    }

    public function getStatusTampilanAttribute(): string
    {
        if ($this->status === 'aktif'
            && $this->tanggal_jatuh_tempo
            && $this->tanggal_jatuh_tempo->isPast()) {
            return 'jatuh_tempo';
        }
        return $this->status;
    }
}
