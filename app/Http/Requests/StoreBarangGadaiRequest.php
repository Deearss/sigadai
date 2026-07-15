<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBarangGadaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_barang' => ['required', 'string', 'max:255'],
            'kategori' => ['required', \Illuminate\Validation\Rule::in(\App\Models\BarangGadai::KATEGORI)],
            'taksiran_nilai' => ['required', 'integer', 'min:100', 'multiple_of:100'],
            'jangka_waktu' => ['required', 'integer', 'min:1'],
            'nama_nasabah' => ['required', 'string', 'max:255'],
            'no_hp'          => ['required', 'string', 'max:20'],
            'tanggal_gadai'  => ['required', 'date'],
            'status'         => [
                'required', 
                \Illuminate\Validation\Rule::in(\App\Models\BarangGadai::STATUS),
                function (string $attribute, mixed $value, \Closure $fail) {
                    if ($value === 'lelang' && $this->tanggal_gadai && $this->jangka_waktu) {
                        try {
                            $jatuhTempo = \Carbon\Carbon::parse($this->tanggal_gadai)
                                ->addDays((int) $this->jangka_waktu)
                                ->startOfDay();
                                
                            if ($jatuhTempo->isFuture() || $jatuhTempo->isToday()) {
                                $fail('Status lelang hanya untuk barang yang sudah melewati jatuh tempo.');
                            }
                        } catch (\Exception $e) {
                            // Let the date validation handle invalid dates
                        }
                    }
                }
            ],
            'catatan'        => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa teks.',
            'max' => ':attribute maksimal :max karakter.',
            'numeric' => ':attribute harus berupa angka.',
            'min' => ':attribute minimal bernilai :min.',
            'multiple_of' => ':attribute harus kelipatan Rp 100 (tidak boleh ada pecahan uang koin di bawah 100).',
            'date' => ':attribute harus berupa tanggal yang valid.',
            'in' => ':attribute pilihan tidak valid.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama_barang' => 'Nama barang',
            'kategori' => 'Kategori',
            'taksiran_nilai' => 'Taksiran nilai',
            'jangka_waktu' => 'Jangka waktu',
            'nama_nasabah' => 'Nama nasabah',
            'no_hp' => 'Nomor HP',
            'tanggal_gadai' => 'Tanggal gadai',
            'status' => 'Status',
            'catatan' => 'Catatan',
        ];
    }
}
