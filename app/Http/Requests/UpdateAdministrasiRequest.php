<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdministrasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sub_kegiatan_id' => ['required', 'integer', 'exists:sub_kegiatans,id'],
            'uraian_belanja' => ['required', 'string'],
            'tagihan' => ['required', 'numeric', 'min:0'],
            'tanggal_nota_persetujuan' => ['required', 'date'],
            'kode_rekening_id' => ['required', 'integer', 'exists:kode_rekenings,id'],
            'etalase_id' => [
                'required',
                'integer',
                Rule::exists('etalases', 'id')->where('kode_rekening_id', $this->input('kode_rekening_id')),
            ],
            'ppn' => ['nullable', 'numeric', 'min:0'],
            'pph23' => ['nullable', 'numeric', 'min:0'],
            'pph21' => ['nullable', 'numeric', 'min:0'],
            'keterangan' => ['nullable', 'string'],
            'penerima' => ['nullable', 'string', 'max:255'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $merge = [];
        foreach (['ppn', 'pph23', 'pph21'] as $key) {
            $v = $this->input($key);
            if ($v === '' || $v === null) {
                $merge[$key] = null;
            }
        }
        if ($merge !== []) {
            $this->merge($merge);
        }
    }
}
