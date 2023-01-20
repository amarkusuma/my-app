<?php

namespace App\Http\Controllers;

use App\Constants\ArrayConstant;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class UsersController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $you = auth()->user();
        $users = User::all();
        return view('dashboard.admin.usersList', compact('users', 'you'));
    }

    public function getUser(Request $request)
    {
        $you = auth()->user();

        if ($request->ajax()) {
            $data = User::orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('email_verified_at', function($row){
                    return Carbon::parse($row->email_verired_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('action', function($row) use($you){
                    $actionBtn = '<div class="d-flex justify-content-between"><a href="'.route('users.edit', $row->id).'" class="edit btn btn-success btn-sm">Edit</a>';
                    $button = null;
                    $role =  $you->menuroles;
                    $role =  explode(',', $role);
                    
                    if (in_array('admin', $role)) {
                        $button = $actionBtn;
                        $button = $button. ' <a href="javascript:void(0)" onclick="deleteThis(event)" class="delete btn btn-danger btn-sm" data-id="'.$row->id.'">Delete</a></div>';
                    }
                    if ($row->id == $you->id) {
                        $button = $actionBtn;
                        $button = $button. ' <a href="javascript:void(0)" onclick="deleteThis(event)" class="delete btn btn-danger btn-sm" data-id="'.$row->id.'">Delete</a></div>';
                    }
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        $roles = ArrayConstant::ROLES;
        return view('dashboard.admin.userCreateForm', [
            'menuroles' => $roles,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'menuroles' => 'nullable',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);
        
        $validate = $request->only(['email', 'name', 'menuroles']);

        $validate = array_merge($validate, [
            'password' => Hash::make('password'),
            'verification' => true,
        ]);

        $user = User::create($validate);
        $user->assignRole($user->menuroles);
        $request->session()->flash('message', 'Successfully create user');
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('dashboard.admin.userShow', compact( 'user' ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $menuroles = ArrayConstant::ROLES;

        return view('dashboard.admin.userEditForm', compact('user', 'menuroles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name'       => 'required|min:1|max:256',
            'email'      => 'required|email|max:256'
        ]);
        $user = User::find($id);
        $user->name       = $request->input('name');
        $user->email      = $request->input('email');
        $user->menuroles  = $request->menuroles ? $request->menuroles : $user->menuroles;
        $user->save();
        $user->syncRoles($user->menuroles);
        $request->session()->flash('message', 'Successfully updated user');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if($user){
            $user->delete();
        }
        return redirect()->route('users.index');
    }

    public function changePasswordForm()
    {
        return view('dashboard.admin.userChangePassword');
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'email'      => 'required|email|exists:users,email',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        try {
            $user->password = Hash::make($request->password);
            $user->save();
            
            return redirect('/');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->withErrors(['message' => $th->getMessage()]);
        }
        
    }

}
