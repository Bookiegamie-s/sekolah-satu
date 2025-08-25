<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can("create", \App\Models\Subject::class);
    }

    public function rules(): array
    {
        return [
            "code" => ["required", "string", "max:10", "unique:subjects,code"],
            "name" => ["required", "string", "max:100"],
            "description" => ["nullable", "string", "max:1000"],
            "category" => ["required", "in:core,elective,extracurricular"],
            "credits" => ["required", "integer", "min:1", "max:6"],
            "grade_level" => ["required", "integer", "min:1", "max:12"],
            "teachers" => ["array"],
            "teachers.*" => ["exists:teachers,id"],
        ];
    }

    public function messages(): array
    {
        return [
            "code.required" => "Kode mata pelajaran harus diisi.",
            "code.unique" => "Kode mata pelajaran sudah ada.",
            "name.required" => "Nama mata pelajaran harus diisi.",
            "category.required" => "Kategori mata pelajaran harus dipilih.",
            "category.in" => "Kategori mata pelajaran tidak valid.",
            "credits.required" => "Jumlah SKS harus diisi.",
            "credits.min" => "Jumlah SKS minimal 1.",
            "credits.max" => "Jumlah SKS maksimal 6.",
            "grade_level.required" => "Tingkat kelas harus diisi.",
            "grade_level.min" => "Tingkat kelas minimal 1.",
            "grade_level.max" => "Tingkat kelas maksimal 12.",
            "teachers.*.exists" => "Guru yang dipilih tidak valid.",
        ];
    }
}
