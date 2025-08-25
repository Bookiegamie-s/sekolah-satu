<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $studentId = $this->route("student")?->id;
        $userId = $this->route("student")?->user_id;

        return [
            "name" => ["required", "string", "max:255"],
            "email" => [
                "required", 
                "email", 
                Rule::unique("users", "email")->ignore($userId)
            ],
            "password" => [
                $this->isMethod("POST") ? "required" : "nullable",
                "string", 
                "min:8",
                "confirmed"
            ],
            "phone" => ["nullable", "string", "max:20"],
            "address" => ["nullable", "string"],
            "birth_date" => ["required", "date", "before:today"],
            "gender" => ["required", "in:male,female"],
            "class_id" => ["required", "exists:classes,id"],
            "student_id" => [
                "required", 
                "string", 
                Rule::unique("students", "student_id")->ignore($studentId)
            ],
            "parent_name" => ["required", "string", "max:255"],
            "parent_phone" => ["required", "string", "max:20"],
            "parent_address" => ["nullable", "string"],
            "enrollment_date" => ["required", "date", "before_or_equal:today"],
            "status" => ["in:active,graduated,dropout,transferred"]
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Nama wajib diisi.",
            "email.required" => "Email wajib diisi.",
            "email.email" => "Format email tidak valid.",
            "email.unique" => "Email sudah digunakan.",
            "password.required" => "Password wajib diisi.",
            "password.min" => "Password minimal 8 karakter.",
            "password.confirmed" => "Konfirmasi password tidak sesuai.",
            "birth_date.required" => "Tanggal lahir wajib diisi.",
            "birth_date.before" => "Tanggal lahir harus sebelum hari ini.",
            "gender.required" => "Jenis kelamin wajib dipilih.",
            "class_id.required" => "Kelas wajib dipilih.",
            "class_id.exists" => "Kelas tidak ditemukan.",
            "student_id.required" => "NIS wajib diisi.",
            "student_id.unique" => "NIS sudah digunakan.",
            "parent_name.required" => "Nama orang tua wajib diisi.",
            "parent_phone.required" => "No HP orang tua wajib diisi.",
            "enrollment_date.required" => "Tanggal masuk wajib diisi."
        ];
    }
}
