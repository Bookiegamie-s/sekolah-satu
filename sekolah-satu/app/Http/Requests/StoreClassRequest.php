<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can("create", \App\Models\ClassModel::class);
    }

    public function rules(): array
    {
        return [
            "name" => ["required", "string", "max:100", "unique:classes,name"],
            "grade" => ["required", "integer", "min:1", "max:12"],
            "academic_year" => ["required", "string", "max:9", "regex:/^\d{4}\/\d{4}$/"],
            "max_students" => ["required", "integer", "min:1", "max:50"],
            "homeroom_teacher_id" => ["nullable", "exists:teachers,id"],
            "description" => ["nullable", "string", "max:500"],
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "Nama kelas harus diisi.",
            "name.unique" => "Nama kelas sudah ada.",
            "grade.required" => "Tingkat kelas harus diisi.",
            "grade.min" => "Tingkat kelas minimal 1.",
            "grade.max" => "Tingkat kelas maksimal 12.",
            "academic_year.required" => "Tahun ajaran harus diisi.",
            "academic_year.regex" => "Format tahun ajaran harus YYYY/YYYY (contoh: 2024/2025).",
            "max_students.required" => "Jumlah maksimal siswa harus diisi.",
            "max_students.min" => "Jumlah maksimal siswa minimal 1.",
            "max_students.max" => "Jumlah maksimal siswa maksimal 50.",
            "homeroom_teacher_id.exists" => "Wali kelas tidak valid.",
        ];
    }
}
