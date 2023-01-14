<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function updateDataUser(Request $request)
    {
        $validate = $request->only(['name', 'email', 'username', 'position', 'level', 'phone_number', 'age', 'gender', 'city']);

        $user = Auth::user();

        $user = User::find($user->id);
 
        if($user) {
            try {
                $user->update($validate);
                
                return $this->success('updated user successfully', $user);
            } catch (\Throwable $th) {
               return $this->failure($th->getMessage());
            }
        }

        return $this->notFound();
    }

    public function updateDataUserById(Request $request,$user_id)
    {
        $validate = $request->only(['name', 'email', 'username', 'position', 'level', 'phone_number', 'age', 'gender', 'city']);

        $user = User::find($user_id);

        if($user) {
            try {
                $user->update($validate);
                return $this->success('updated user successfully', $user);
            } catch (\Throwable $th) {
                return $this->failure($th->getMessage());
            }
        }

        return $this->notFound();
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'email'      => 'required|email|exists:users,email',
            'old_password' => 'required',
            'new_password' => 'required',
            'password_confirmation' => 'required|same:new_password',
        ]);

        #Match The Old Password
        if(!Hash::check($request->old_password, auth()->user()->password)){
            return $this->failure('Old Password Doesnt match!');
        }

        $user = User::where('email', $request->input('email'))->first();

        try {
            $user->password = Hash::make($request->new_password);
            $user->save();
            
            return $this->success('change password successfully');
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
        
    }
}
