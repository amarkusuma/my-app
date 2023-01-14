<?php

namespace App\Http\Controllers\Api\Auth;

use App\Constants\ArrayConstant;
use App\Http\Controllers\Controller;
use App\Mail\VerificationMail;
use App\Models\Learns;
use App\Models\Member;
use App\Models\MemberLearn;
use App\Models\MemberSubLearn;
use App\Models\SubLearns;
use App\Models\User;
use Carbon\Carbon;
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
        $user->assignRole('guest');
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
            $learn = Learns::get();
            $basic = collect($learn)->where('level', ArrayConstant::LEVEL[0]['value'])->first();
            
            $user = $this->create($request->all());
            
            if ($user) {
                collect($learn)->each(function($data) use($user){
                    MemberLearn::create([
                        'user_id' => $user->id,
                        'learn_id' => $data->id,
                        'start_date' => null,
                        'learn' => $data->name,
                        'level' => $data->level,
                    ]);
                });

                // $token = $user->createToken('auth_token')->plainTextToken;
                // $member_sub_learn = MemberLearn::where(['user_id' => $user->id], ['learn_id' => $basic->id])->first();

                $sub_learn = SubLearns::whereHas( 'learn', function($query){
                    $query->where('level', ArrayConstant::LEVEL[0]['value']);
                })->get();

                collect($sub_learn)->each(function($data) use($user, $basic){
                    MemberSubLearn::create([
                        'user_id' => $user->id,
                        'learn_id' => $basic->id,
                        'sub_learn_id' => $data->id,
                    ]); 
                });

                $user->sendEmailVerificationNotification();

                return $this->success('Register successfull', [
                    'user' => $user,
                    // 'access_token' => $token,
                    // 'token_type' => 'Bearer'
                ]);
            }
        } catch (\Throwable $th) {
            return $this->failure($th->getMessage(), []);
        }

        return $this->failure('Register failed', []);
    }

}
