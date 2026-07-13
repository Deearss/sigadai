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

    public function prepareForValidation()
    {
        if ($this->has('taksiran_nilai')) {
            $this->merge([
                'taksiran_nilai' => str_replace('.', '', $this->taksiran_nilai)
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'nama_barang' => ['required', 'string', 'max:255'],
            'kategori' => ['required', \Illuminate\Validation\Rule::in(\App\Models\BarangGadai::KATEGORI)],
            'taksiran_nilai' => ['required', 'integer', 'min:1'],
            'jangka_waktu' => ['required', 'integer', 'min:1'],
            'nama_nasabah' => ['required', 'string', 'max:255'],
            'no_hp'          => ['required', 'string', 'max:20'],
            'tanggal_gadai'  => ['required', 'date'],
            'status'         => ['required', \Illuminate\Validation\Rule::in(\App\Models\BarangGadai::STATUS)],
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
