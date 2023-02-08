<?php

namespace App\Controllers;

use App\Controllers\Requests\AuthRequest;
use App\Controllers\Requests\LoginRequest;
use App\Models\User;
use Zeero\Core\Crypto\Hashing;
use Zeero\facades\Flash;
use Zeero\facades\Session;

/**
 * Authentication Controller
 * 
 * used to make user registration, login and logout and retrieve current user informations
 * 
 * @author zeero
 */
class AuthController
{
    protected $afterLogin = "/";
    protected $afterRegister = "/login";

    /**
     * Make User Login
     *
     * @param LoginRequest $request
     * @return array
     */
    public function login(LoginRequest $request)
    {
        $new_token = base64_encode(random_bytes(23));

        // validate the data
        if ($request->validator->fail()) {
            Flash::set('_csrf_token', $new_token);
            return ['error' => $request->validator->errors(false), 'token' => $new_token];
        }

        // get the form data
        $data = $request->form;

        // check if exists a user with the name given
        if (User::has('name = ?', [$data->get('name')])) {
            // find the user by name
            $user = User::findOne('name = ?', [$data->get('name')]);

            // verify the hash with password
            if (Hashing::verify_hash($data->get('password'), $user->password) == false) {
                Flash::set('_csrf_token', $new_token);
                return ['error' => 'Palavra-Passe incorreta', 'token' => $new_token];
            }

            if (!((int) $user->state)) {
                Flash::set('_csrf_token', $new_token);
                return ['error' => 'Conta Temporariamente Bloqueada', 'token' => $new_token];
            }

            // update the user state
            $user->update(['login_at' => timer()->now()]);

            $return = [];
            $return['message'] = 'logado com sucesso';

            // set the user id
            Session::set('user_id', $user->uuid);

            return $return;
        } else {
            Flash::set('_csrf_token', $new_token);
            return ['error' => 'usuário não encontrado', 'token' => $new_token];
        }
    }


    /**
     * Make the User Register
     *
     * @param AuthRequest $request
     * @return array
     */
    public function register(AuthRequest $request)
    {
        $new_token = base64_encode(random_bytes(23));

        if ($request->validator->fail() and count($request->validator->errors(false))) {
            Flash::set('_csrf_token', $new_token);
            return ['error' => $request->validator->errors(false), 'token' => $new_token];
        }

        $name = $request->form->filter_post('name');
        $password = $request->form->filter_post('password');

        $id = Hashing::random_id();

        $data = [];
        $data['uuid'] = $id;
        $data['name'] = $name;
        $data['password'] = Hashing::hash($password);
        $data['online'] = 1;
        $data['level'] = 1;
        $data['created_at'] = timer()->now();

        if (User::create($data)) {
            return ['message' => 'conta criada com sucesso'];
        }

        return ['error' => 'erro ao criar conta'];
    }
}
