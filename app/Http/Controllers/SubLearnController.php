<?php

namespace App\Http\Controllers;

use App\Models\BankSoal;
use App\Models\SubLearns;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubLearnController extends Controller
{
    public function index($learn_id)
    {
        return view('pages.sub_learn.dataTable', [
            'learn_id' => $learn_id
        ]);
    }

    public function getSubLearn(Request $request, $learn_id)
    {
        if ($request->ajax()) {
            $data = SubLearns::where('learn_id', $learn_id)->orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('learn_name', function($row){
                   return $row->learn ? $row->learn->name : null;
                })
                ->addColumn('max_soal', function($row){
                    return $row->limit_soal ? $row->limit_soal.' Soal ':  null;
                 })
                ->addColumn('action', function($row){
                    $actionBtn = '<div class="d-flex justify-content-between"><a href="'.route('sub-learn.edit', [ 'id' => $row->id, 'learn_id' => $row->learn_id ]).'" class="edit btn btn-success btn-sm">Edit</a>
                    <a href="javascript:void(0)" onclick="deleteThis(event)" class="delete btn btn-danger btn-sm" data-id="'.$row->id.'">Delete</a></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'learn_name', 'max_soal'])
                ->make(true);
        }
    }

    public function create($learn_id)
    {
        $bank_soal = BankSoal::get();
        return view('pages.sub_learn.create', [
            'learn_id' => $learn_id,
            'bank_soal' => $bank_soal,
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->only(['learn_id', 'sub_name', 'min_correct', 'pdf', 'link_youtube', 'bank_soal_id', 'limit_soal', 'activated']);

        $request->validate([
          'learn_id' => 'required|exists:learns,id',
          'sub_name' => 'required',
          'pdf' => 'nullable|max:51200|mimes:pdf,PDF',
          'video' => 'nullable',
        ]);
        
        if ($request->hasFile('pdf')) {

            $pdfPath = $request->file('pdf')->store(SubLearns::FILE_PATH, 'local');
            // Storage::disk('public')->put(Equitment::pdf.'/'.$pdfName, $request->file('pdf'));

            $filename  = pathinfo($pdfPath, PATHINFO_FILENAME);
            $extension = pathinfo($pdfPath, PATHINFO_EXTENSION);
            $pdfName = $filename . '.' . $extension;

            $validate = array_merge($validate, [
                'pdf' => $pdfName,
            ]);
        }

        if ($request->has('video')) {
            $videoPath = $request->file('video')->store(SubLearns::VIDEO_PATH, 'local');
            
            $filename  = pathinfo($videoPath, PATHINFO_FILENAME);
            $extension = pathinfo($videoPath, PATHINFO_EXTENSION);
            $videoName = $filename . '.' . $extension;
           
            $validate = array_merge($validate, [
                'video' => $videoName,
            ]);
        }

        $validate = array_merge($validate, [
            'activated' => $request->activated ? true : false,
        ]);

        SubLearns::create($validate);

        return redirect()->route('sub-learn.index', $request->learn_id);
    }

    public function edit($id, $learn_id)
    {
        $data = SubLearns::find($id);
        $bank_soal = BankSoal::get();
        
        return view('pages.sub_learn.edit', [
            'data' => $data,
            'learn_id' => $learn_id,
            'bank_soal' => $bank_soal,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validate = $request->only(['learn_id', 'sub_name', 'min_correct', 'pdf', 'link_youtube', 'bank_soal_id', 'limit_soal', 'activated']);

        $request->validate([
          'learn_id' => 'required|exists:learns,id',
          'sub_name' => 'required',
          'pdf' => 'nullable|max:51200|mimes:pdf,PDF',
          'video' => 'nullable',
        ]);

        $sub_learn = SubLearns::find($id);

        if ($request->hasFile('pdf')) {
            $pdfPath = $request->file('pdf')->store(SubLearns::FILE_PATH, 'local');

            $file = public_path('/storage/'.SubLearns::FILE_PATH.$sub_learn->pdf);
            if (file_exists($file) && !empty($sub_learn->pdf)) {
                unlink($file);
            }

            $filename  = pathinfo($pdfPath, PATHINFO_FILENAME);
            $extension = pathinfo($pdfPath, PATHINFO_EXTENSION);
            $pdfName = $filename . '.' . $extension;

            $validate = array_merge($validate, [
                'pdf' => $pdfName,
            ]);
        }

        if ($request->has('video')) {
            $videoPath = $request->file('video')->store(SubLearns::VIDEO_PATH, 'local');
            
            $file = public_path('/storage/'.SubLearns::VIDEO_PATH.$sub_learn->video);
            if (file_exists($file) && !empty($sub_learn->video)) {
                unlink($file);
            }

            $filename  = pathinfo($videoPath, PATHINFO_FILENAME);
            $extension = pathinfo($videoPath, PATHINFO_EXTENSION);
            $videoName = $filename . '.' . $extension;
           
            $validate = array_merge($validate, [
                'video' => $videoName,
            ]);
        }

        $validate = array_merge($validate, [
            'activated' => $request->activated ? true : false,
        ]);

        $sub_learn->update($validate);

        return redirect()->route('sub-learn.index', $request->learn_id);
    }

    public function destroy($id)
    {
        $sub_learn = SubLearns::find($id);

        if ($sub_learn) {

            $file = public_path('/storage/'.SubLearns::FILE_PATH.$sub_learn->pdf);
            if (file_exists($file) && !empty($sub_learn->pdf)) {
                unlink($file);
            }

            $file = public_path('/storage/'.SubLearns::VIDEO_PATH.$sub_learn->video);
            if (file_exists($file) && !empty($sub_learn->video)) {
                unlink($file);
            }

            $sub_learn->delete();
            return $this->success('delete data successfull', $sub_learn);
        }
        return $this->failure('delete data failed');
    }
}
