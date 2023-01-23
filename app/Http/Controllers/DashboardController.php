<?php

namespace App\Http\Controllers;

use App\Constants\ArrayConstant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        if (Auth::check()) {

            $user = User::whereHas('roles', function($query){
                $query->where('name', 'guest');
            })->get();

            $basic = User::whereHas('roles', function($query){
                $query->where('name', 'guest');
            })->whereHas('member_learn', function($query){
                $query->where('active', true);
                $query->whereHas('learn', function($query){
                   $query->where('level', ArrayConstant::LEVEL[0]['value']);
                });
            })->get('id');

            $intermediate = User::whereHas('roles', function($query){
                $query->where('name', 'guest');
            })->whereHas('member_learn', function($query){
                $query->where('active', true);
                $query->whereHas('learn', function($query){
                   $query->where('level', ArrayConstant::LEVEL[1]['value']);
                });
            })->get('id');

            $advanced = User::whereHas('roles', function($query){
                $query->where('name', 'guest');
            })->whereHas('member_learn', function($query){
                $query->where('active', true);
                $query->whereHas('learn', function($query){
                   $query->where('level', ArrayConstant::LEVEL[2]['value']);
                });
            })->get('id');

            return view('dashboard.homepage', [
                'user' => $user,
                'basic' => $basic,
                'intermediate' => $intermediate,
                'advanced' => $advanced,
            ]);
        }
        return view('auth.login');
    }
}
