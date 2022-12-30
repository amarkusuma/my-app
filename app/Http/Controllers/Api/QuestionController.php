<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubLearns;
use App\Models\SubSoal;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function questionSubLearn(Request $request)
    {
        $sub_learn = SubLearns::with(['bank_soal'])->get();

        collect($sub_learn)->map(function($data){
            $data['sub_soal'] = SubSoal::where('bank_soal_id', $data->bank_soal_id)->get();
            return $data;
        });

        return $this->success('get question learn successfull', $sub_learn);
    }
}