<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationMail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    protected function create(array $data)
    {
        $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'verification' => false,
            'remember_token' => Str::random(32),
            'menuroles' => 'user',
        ]);
        $user->assignRole('user');
        return $user;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function registered(Request $request, $user)
    {
        //
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();


        try {

            $user = $this->create($request->all());

            if ($user) {
                $token = $user->createToken('auth_token')->plainTextToken;

                $user->sendEmailVerificationNotification();

                return $this->success('Register successfull', [
                    'user' => $user,
                    'access_token' => $token,
                    'token_type' => 'Bearer'
                ]);
            }
        } catch (\Throwable $th) {
            return $this->failure($th->getMessage(), []);
        }

        return $this->failure('Register failed', []);
    }

}
