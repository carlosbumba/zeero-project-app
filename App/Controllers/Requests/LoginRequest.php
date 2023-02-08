<?php

namespace App\Controllers\Requests;

use Zeero\Core\Validator\Form;

class LoginRequest extends Form
{
    protected $redirectTo = "/login";

    public function rules()
    {
        return [
            "name" => "required|pattern:pt_alfanum",
            "password" => "required|min:6"
        ];
    }

    public function messages()
    {
        return [
            "required" => "preencha todos os campos",
            "name.pattern" => "nome inválido",
            "password.min" => "a senha deve ter no mínimo {min} caracteres"
        ];
    }
}
