<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateArtikelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Hanya admin yang bisa menggunakan fitur AI
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:255|min:5',
            'kategori_artikel_id' => 'nullable|exists:kategori_artikels,id',
            'min_words' => 'nullable|integer|min:200|max:2000',
            'custom_prompt' => 'nullable|string|max:1000'
        ];
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'judul.required' => 'Judul artikel wajib diisi untuk generate konten AI.',
            'judul.min' => 'Judul artikel minimal 5 karakter.',
            'judul.max' => 'Judul artikel maksimal 255 karakter.',
            'kategori_artikel_id.exists' => 'Kategori artikel tidak valid.',
            'min_words.integer' => 'Jumlah minimal kata harus berupa angka.',
            'min_words.min' => 'Minimal kata tidak boleh kurang dari 200.',
            'min_words.max' => 'Minimal kata tidak boleh lebih dari 2000.',
            'custom_prompt.max' => 'Prompt custom maksimal 1000 karakter.'
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Sanitize judul
        if ($this->has('judul')) {
            $this->merge([
                'judul' => strip_tags(trim($this->judul))
            ]);
        }
        
        // Sanitize custom_prompt
        if ($this->has('custom_prompt')) {
            $this->merge([
                'custom_prompt' => strip_tags(trim($this->custom_prompt))
            ]);
        }

        // Set default min_words jika tidak ada
        if (!$this->has('min_words') || empty($this->min_words)) {
            $this->merge([
                'min_words' => 500
            ]);
        }
    }
}
