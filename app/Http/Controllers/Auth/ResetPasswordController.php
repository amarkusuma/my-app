<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest');
    }

    public function formResetPassword(Request $request)
    {
        $validate = (object)$request->only(['token', 'email']);
        $user = User::where('email',$request->email)->first();

        try {
            if ($user) {
                if ($validate->email == $user->email && $validate->token == $user->remember_token) { 
                    return view('auth.passwords.reset-password', [
                        'email' => $user->email,
                    ]);
                }
                else {
                    return view('auth.passwords.reset-password-invalid', [
                        'title' => 'Reset Password Failed',
                        'message' => 'Reset password gagal, silahkan lakukan ulang permintaan reset password, atau hubungi admin autismart mobile'
                    ]);
                }
            }

            return view('auth.passwords.reset-password-invalid', [
                'title' => 'Reset Password Failed',
                'message' => 'Reset password gagal, silahkan lakukan ulang permintaan reset password, atau hubungi admin autismart mobile'
            ]);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }

    public function resetPassword(Request $request){
        $validate = $request->validate([
           'email' => 'required',
           'password' => 'required|min:8',
           'password_confirmation' => 'required|same:password',
        ]);

        $user = User::where('email',$request->email)->first();
        
        try {
            
            if ($user) {
                $user->password = Hash::make($request->password);
                $user->save();
                return redirect()->back()->with('status', 'Update password successfully');
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }
}
