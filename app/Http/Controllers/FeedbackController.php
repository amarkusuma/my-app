<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Feedback::orderBy('id', 'DESC')->get();

        return view('pages.feedback.dataTable',[
            'data' => $data
        ]);
    }

    public function getFeedback(Request $request)
    {
        // return $dataTable->render('pages.news_category.dataTable');
        if ($request->ajax()) {
            $data = Feedback::orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function($row){
                    $user = $row->user ? $row->user->name : '';
                    return $user;
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<div class="d-flex justify-content-between"><a href="'.route('feedback.edit', $row->id).'" class="edit btn btn-success btn-sm">Edit</a>
                    <a href="javascript:void(0)" onclick="deleteThis(event)" class="delete btn btn-danger btn-sm" data-id="'.$row->id.'">Delete</a></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        return view('pages.feedback.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->only(['comment']);
        $user = Auth::user();

        $request->validate([
        //   'user_id' => 'required|exists:users,id',
          'comment' => 'required',
        ]);

        $validate = array_merge($validate, [
           'user_id' => $user->id,
        ]);

        Feedback::create($validate);

        return redirect()->route('feedback.index');
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
        $data = Feedback::find($id);

        return view('pages.feedback.edit', [
            'data' => $data,
        ]);
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
        $validate = $request->only(['comment']);
        $user = Auth::user();

        $request->validate([
        //   'user_id' => 'required|exists:users,id',
          'comment' => 'required',
        ]);

        $validate = array_merge($validate, [
            'user_id' => $user->id,
        ]);

        $feedback = Feedback::find($id);
        $feedback->update($validate);

        return redirect()->route('feedback.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $feedback = Feedback::find($id);

        if ($feedback) {
            $feedback->delete();
            return $this->success('delete data successfull', $feedback);
        }
        return $this->failure('delete data failed');
    }

    public function feedbackStore(Request $request)
    {
        $validate = $request->only(['comment', 'user_id']);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'comment' => 'required',
        ]);

        $feedback = Feedback::create($validate);

        if ($feedback) {
            return $this->success('Input feeback successfully', $feedback);
        } 
        return $this->failure('Input feedback failed');
    }
}
