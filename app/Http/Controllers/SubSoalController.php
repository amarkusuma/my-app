<?php

namespace App\Http\Controllers;

use App\Models\SubSoal;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubSoalController extends Controller
{
    public function index($sub_soal_id)
    {
        return view('pages.sub_soal.dataTable', [
            'bank_soal_id' => $sub_soal_id
        ]);
    }

    public function getSubSoal(Request $request, $sub_soal_id)
    {
        if ($request->ajax()) {
            $data = SubSoal::where('bank_soal_id', $sub_soal_id)->orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('bank_soal_name', function($row){
                   return $row->bank_soal ? $row->bank_soal->name : null;
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<div class="d-flex justify-content-between"><a href="'.route('sub-soal.edit', [ 'id' => $row->id, 'bank_soal_id' => $row->bank_soal_id ]).'" class="edit btn btn-success btn-sm">Edit</a>
                    <a href="javascript:void(0)" onclick="deleteThis(event)" class="delete btn btn-danger btn-sm" data-id="'.$row->id.'">Delete</a></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'bank_soal_name'])
                ->make(true);
        }
    }

    public function create($bank_soal_id)
    {
        return view('pages.sub_soal.create', [
            'bank_soal_id' => $bank_soal_id
        ]);
    }

    public function checkValueAnswer(Request $request, String $answer) {
        if ($request->option_A == $answer) {
            return 'A';
        }else if ($request->option_B == $answer) {
            return 'B';
        }else if ($request->option_C == $answer) {
            return 'C';
        }else if ($request->option_D == $answer) {
            return 'D';
        }
    }


    public function store(Request $request)
    {
        $validate = $request->only(['bank_soal_id', 'question', 'correct_answer', 'option_A', 'option_B', 'option_C', 'option_D']);

        $request->validate([
          'bank_soal_id' => 'required|exists:bank_soal,id',
          'question' => 'required',
          'correct_answer' => 'required',
        ]);

        $validate = array_merge($validate, [ 'correct_option' => $this->checkValueAnswer($request, $request->correct_answer)]);

        SubSoal::create($validate);

        return redirect()->route('sub-soal.index', $request->bank_soal_id);
    }

    public function edit($id, $bank_soal_id)
    {
        $data = SubSoal::find($id);

        $options = [];
        $options[0]['id'] = 1;
        $options[0]['value'] = $data->option_A;
        $options[0]['text'] = $data->option_A;
        $options[1]['id'] = 2;
        $options[1]['value'] = $data->option_B;
        $options[1]['text'] = $data->option_B;
        $options[2]['id'] = 3;
        $options[2]['value'] = $data->option_C;
        $options[2]['text'] = $data->option_C;
        $options[3]['id'] = 4;
        $options[3]['value'] = $data->option_D;
        $options[3]['text'] = $data->option_D;
        
        return view('pages.sub_soal.edit', [
            'data' => $data,
            'bank_soal_id' => $bank_soal_id,
            'options' => $options,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validate = $request->only(['bank_soal_id', 'question', 'correct_answer', 'option_A', 'option_B', 'option_C', 'option_D']);

        $request->validate([
          'bank_soal_id' => 'required|exists:bank_soal,id',
          'question' => 'required',
          'correct_answer' => 'required',
        ]);

        $sub_soal = SubSoal::find($id);

        $validate = array_merge($validate, [ 'correct_option' => $this->checkValueAnswer($request, $request->correct_answer)]);
        
        $sub_soal->update($validate);

        return redirect()->route('sub-soal.index', $request->bank_soal_id);
    }

    public function destroy($id)
    {
        $sub_soal = SubSoal::find($id);

        if ($sub_soal) {
            $sub_soal->delete();
            return $this->success('delete data successfull', $sub_soal);
        }
        return $this->failure('delete data failed');
    }
}
