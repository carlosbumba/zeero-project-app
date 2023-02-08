<?php

namespace App\Controllers\Requests;

use Zeero\Core\Validator\Form;

class AuthRequest extends Form
{
    protected $redirectTo = "/register";

    public function rules()
    {
        return [
            "name" => "required|min:6|pattern:pt_alfanum|unique:User,name",
            "password" => "required|min:6",
            "password-confirm" => "required|same:@password"
        ];
    }

    public function messages()
    {
        return [
            "required" => "preencha todos os campos",
            "name.pattern" => "nome contém símbolos",
            "name.unique" => "nome já registrado",
            "password.min" => "senha muito curta ( mínimo 6 caracteres )",
			"password-confirm.same" => "confirma corretamente a senha",
        ];
    }
}
