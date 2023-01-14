<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
    }

    public function getUser(Request $request){
        $user = User::where(['email' => $request->email])->firstOrFail();

        return $user;
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (!Auth::attempt($request->only('email', 'password')))
        {
            return $this->failure('Unauthorized', []);
        }

        $user = $this->getUser($request);

        if ($user->verification) {
            try {
                // V1
                // $token = $user->createToken('auth_token')->plainTextToken;
                // return $this->success('login successfull',  [
                //     'user' => $user,
                //     'access_token' => $token,
                //     'token_type' => 'Bearer'
                // ]);

                $random_number = random_int(100000, 999999);

                $user->otp_code = $random_number;
                $user->otp_code_updated_at = Carbon::now()->format('Y-m-d H:i:s');
                $user->save();

                $user->sendOTPLoginNotification();

                return $this->success('login successfull, We send otp code to your email');

            } catch (\Throwable $th) {
                return $this->failure($th->getMessage(), []);
            }
        }

        return $this->failure('User not verification', []);
    }

    public function verificationOTPLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp_code' => 'required|exists:users,otp_code',
        ]);

        $validate = $request->only(['email', 'otp_code']);

        $user = User::where($validate)->first();

        if ($user) {
            try {
                $now = Carbon::parse(Carbon::now()->format('Y-m-d H:i:s'));
                $minutes = $now->diffInMinutes(Carbon::parse($user->otp_code_updated_at));

                if ($minutes > 60) {
                    return $this->failure('Otp code expired');
                }

                $token = $user->createToken('auth_token')->plainTextToken;
                
                return $this->success('Verification otp code successfully', [
                    'user' => $user,
                    'access_token' => $token,
                    'token_type' => 'Bearer'
                ]);

            } catch (\Throwable $th) {
                return $this->failure($th->getMessage());
            }
        }

        return $this->notFound('data user not found');
    }

    public function verification(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'token' => 'required|string',
        ]);

        $validate = $request->only(['email', 'token']);

        $validate = collect($validate)->except('token')->toArray();
        $validate = array_merge($validate, [
            'remember_token' => $request->token,
        ]);

        $user = User::where($validate)->first();

        if ($user) {
            try {
                $token = $user->createToken('auth_token')->plainTextToken;
                $user->verification = true;
                $user->save();

                return $this->success('Verification successfull', [
                    'user' => $user,
                    'access_token' => $token,
                    'token_type' => 'Bearer'
                ]);
            } catch (\Throwable $th) {
                return $this->failure($th->getMessage(), []);
            }
        }

        return $this->failure('Verification failed', []);
    }

}
