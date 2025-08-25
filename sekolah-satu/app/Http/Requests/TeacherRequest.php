<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeacherRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $teacherId = $this->route("teacher")?->id;
        $userId = $this->route("teacher")?->user_id;

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
            "employee_id" => [
                "required", 
                "string", 
                Rule::unique("teachers", "employee_id")->ignore($teacherId)
            ],
            "specialization" => ["nullable", "string", "max:255"],
            "max_jam_mengajar" => ["required", "integer", "min:1", "max:40"],
            "hire_date" => ["required", "date", "before_or_equal:today"],
            "salary" => ["nullable", "numeric", "min:0"],
            "qualifications" => ["nullable", "string"],
            "is_active" => ["boolean"]
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
            "employee_id.required" => "ID Karyawan wajib diisi.",
            "employee_id.unique" => "ID Karyawan sudah digunakan.",
            "max_jam_mengajar.required" => "Maksimal jam mengajar wajib diisi.",
            "max_jam_mengajar.min" => "Maksimal jam mengajar minimal 1 jam.",
            "max_jam_mengajar.max" => "Maksimal jam mengajar maksimal 40 jam.",
            "hire_date.required" => "Tanggal bergabung wajib diisi."
        ];
    }
}
