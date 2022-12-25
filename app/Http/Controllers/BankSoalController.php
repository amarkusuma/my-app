<?php

namespace App\Http\Controllers;

use App\Models\BankSoal;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BankSoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.bank_soal.dataTable');
    }

    public function getBankSoal(Request $request)
    {
        if ($request->ajax()) {
            $data = BankSoal::orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function($row){
                   $name = '<a href="'.route('sub-soal.index', $row->id).'">'.$row->name.'</a>';
                   return $name;
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<div class="d-flex justify-content-between"><a href="'.route('bank-soal.edit', $row->id).'" class="edit btn btn-success btn-sm">Edit</a>
                    <a href="javascript:void(0)" onclick="deleteThis(event)" class="delete btn btn-danger btn-sm" data-id="'.$row->id.'">Delete</a></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'name'])
                ->make(true);
        }
    }

    public function create()
    {
        return view('pages.bank_soal.create');
    }


    public function store(Request $request)
    {
        $validate = $request->only(['name']);

        $request->validate([
          'name' => 'required',
        ]);

        BankSoal::create($validate);

        return redirect()->route('bank-soal.index');
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
        $data = BankSoal::find($id);

        return view('pages.bank_soal.edit', [
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
        $validate = $request->only(['name']);

        $request->validate([
          'name' => 'required',
        ]);

        $bank_soal = BankSoal::find($id);
        $bank_soal->update($validate);

        return redirect()->route('bank-soal.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bank_soal = BankSoal::find($id);

        if ($bank_soal) {
            $bank_soal->delete();
            return $this->success('delete data successfull', $bank_soal);
        }
        return $this->failure('delete data failed');
    }
}
