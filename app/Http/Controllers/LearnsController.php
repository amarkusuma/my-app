<?php

namespace App\Http\Controllers;

use App\Constants\ArrayConstant;
use App\Models\Learns;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LearnsController extends Controller
{

    public function index()
    {
        return view('pages.learns.dataTable');
    }

    public function getLearns(Request $request)
    {
        if ($request->ajax()) {
            $data = Learns::orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('discount', function($row){
                   return $row->discount ? $row->discount.' % ' : null;
                })
                ->editColumn('name', function($row){
                    $name = '<a href="'.route('sub-learn.index', $row->id).'">'.$row->name.'</a>';
                    return $name;
                 })
                ->editColumn('level', function($row){
                    $level = '';
                    for ($i=0; $i < count(ArrayConstant::LEVEL) ; $i++) {
                        if ($row->level == ArrayConstant::LEVEL[$i]['value']) {
                            $level = ArrayConstant::LEVEL[$i]['label'];
                        }
                    }

                    if ($row->level == ArrayConstant::LEVEL[0]['value']) {
                        return '<span class="badge badge-pill badge-warning">'.$level.'</span>';
                    }
                    if ($row->level == ArrayConstant::LEVEL[1]['value']) {
                        return '<span class="badge badge-pill badge-success">'.$level.'</span>';
                    }
                    if ($row->level == ArrayConstant::LEVEL[2]['value']) {
                        return '<span class="badge badge-pill badge-primary">'.$level.'</span>';
                    }
                    return '<span class="badge badge-pill badge-secondary">'.$level.'</span>';
                })
                ->editColumn('price', function($row){
                    return number_format($row->price,2,",",".");
                 })
                ->addColumn('action', function($row){
                    $actionBtn = '<div class="d-flex justify-content-between"><a href="'.route('learns.edit', $row->id).'" class="edit btn btn-success btn-sm">Edit</a>
                    <a href="javascript:void(0)" onclick="deleteThis(event)" class="delete btn btn-danger btn-sm" data-id="'.$row->id.'">Delete</a></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'discount', 'price', 'level', 'name'])
                ->make(true);
        }
    }

    public function create()
    {
        $level = ArrayConstant::LEVEL;
        return view('pages.learns.create', [
            'level' => $level,
        ]);
    }


    public function store(Request $request)
    {
        $validate = $request->only(['name', 'level', 'price', 'discount', 'activated']);

        $request->validate([
          'name' => 'required',
          'level' => 'required',
          'price' => 'required',
          'discount' => 'nullable',
        ]);

        $validate = array_merge($validate, [
            'activated' => $request->activated ? true : false,
        ]);

        Learns::create($validate);

        return redirect()->route('learns.index');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $data = Learns::find($id);
        $level = ArrayConstant::LEVEL;
        return view('pages.learns.edit', [
            'data' => $data,
            'level' => $level,
        ]);
    }


    public function update(Request $request, $id)
    {
        $validate = $request->only(['name', 'level', 'price', 'discount', 'activated']);
        
        $request->validate([
            'name' => 'required',
            'level' => 'required',
            'price' => 'required',
            'discount' => 'nullable',
        ]);

        $validate = array_merge($validate, [
            'activated' => $request->activated ? true : false,
        ]);

        $learn = Learns::find($id);
        $learn->update($validate);

        return redirect()->route('learns.index');
    }


    public function destroy($id)
    {
        $learn = Learns::find($id);

        if ($learn) {
            $learn->delete();
            return $this->success('delete data successfull', $learn);
        }
        return $this->failure('delete data failed');
    }
}
