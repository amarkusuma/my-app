<?php

namespace App\Http\Controllers\Api\Auth;

use App\Constants\ArrayConstant;
use App\Http\Controllers\Controller;
use App\Mail\VerificationMail;
use App\Models\Learns;
use App\Models\Member;
use App\Models\MemberLearn;
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

            $learn = Learns::get();
            $basic = collect($learn)->where('level', ArrayConstant::LEVEL[0]['value'])->first();
            
            $user = $this->create($request->all());
            
            if ($user) {
                $token = $user->createToken('auth_token')->plainTextToken;

                $member = Member::create([
                    'user_id' => $user->id,
                    'learn_id' => $basic->id,
                    'level' => 1,
                    'learn' => $basic->name,
                    'start_date' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                
                for ($i=0; $i < count($learn) ; $i++) { 
                    
                    $member_learn = MemberLearn::create([
                        'member_id' => $member->id,
                        'learn_id' => $learn[$i]['id'],
                        'start_date' => Carbon::now()->format('Y-m-d H:i:s'),
                    ]);
                }

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
