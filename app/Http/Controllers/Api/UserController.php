<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
