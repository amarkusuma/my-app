<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
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
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
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
                // $token = $user->createToken('auth_token')->plainTextToken;
                $user->verification = true;
                $user->save();

                return view('pages.email.verify-email', [
                    'title' => 'Verification Successfull',
                    'message' => 'Selamat Akun anda sudah aktif, silahkan login melalui aplikasi autismart mobile',
                    'status' => true,
                ]);

            } catch (\Throwable $th) {
                return $this->failure($th->getMessage(), []);
            }
        }

        // elseif (Carbon::now() >= $user->expired) {
        //     return view('frontend::auth.resend-verify');
        //     // return redirect('/register')->with(['status' => 'token has been expired']);
        // }
        // else {
        //     return redirect('/register')->with(['status' => 'the user not verified']);
        // }

        return view('pages.email.verify-email', [
            'title' => 'Verification failed',
            'message' => 'Verifikasi gagal, silahkan verifikasi ulang, atau hubungi admin autismart mobile',
            'status' => false,
        ]);
    }
}
