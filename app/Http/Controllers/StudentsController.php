<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StudentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('admin');
    }

    public function index()
    {
        $you = auth()->user();
        $users = User::whereHas('roles', function($query){
            $query->where('name', 'guest');
        })
        ->get();
        
        return view('pages.students.dataTable', compact('users', 'you'));
    }

    public function getUser(Request $request)
    {
        $you = auth()->user();

        if ($request->ajax()) {
            $data = User::whereHas('roles', function($query){
                $query->where('name', 'guest');
            })
            ->orderBy('id', 'DESC')
            ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('email_verified_at', function($row){
                    return Carbon::parse($row->email_verired_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('action', function($row) use($you){
                    // $actionBtn = '<div class="d-flex justify-content-between"><a href="'.route('users.edit', $row->id).'" class="edit btn btn-success btn-sm">Edit</a>';
                    $actionBtn = '';
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
        return redirect()->route('students.index');
    }
}
