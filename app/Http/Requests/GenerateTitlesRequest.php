<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateTitlesRequest extends FormRequest
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
            'topik' => 'required|string|max:255|min:3',
            'kategori_artikel_id' => 'nullable|exists:kategori_artikels,id'
        ];
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'topik.required' => 'Topik artikel wajib diisi untuk generate judul.',
            'topik.min' => 'Topik artikel minimal 3 karakter.',
            'topik.max' => 'Topik artikel maksimal 255 karakter.',
            'kategori_artikel_id.exists' => 'Kategori artikel tidak valid.'
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Sanitize topik
        if ($this->has('topik')) {
            $this->merge([
                'topik' => strip_tags(trim($this->topik))
            ]);
        }
    }
}
