<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BankSoal;
use App\Models\Learns;
use App\Models\MemberLearn;
use App\Models\MemberSubLearn;
use App\Models\SubLearns;
use App\Models\SubSoal;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function getMemberLearn()
    {
        $member_learn = MemberLearn::get();

        return $this->success('get member learn successfully', $member_learn);
    }

    public function getMemberSubLearn()
    {
        $member_sub_learn = MemberSubLearn::get();

        return $this->success('get member sub learn successfully', $member_sub_learn);
    }

    public function getMemberLearnByUser($user_id){
        $member_learn = MemberLearn::where(['user_id' => $user_id])->get();

        return $this->success('get member learn successfully', $member_learn);
    }

    public function getMemberSubLearnByUser($user_id, $learn_id){
        $member_sub_learn = MemberSubLearn::where(['user_id' => $user_id, 'learn_id' => $learn_id])->get();

        if (count($member_sub_learn) > 0) {

            try {
                collect($member_sub_learn)->map(function($data){
                    $learn = Learns::find($data->learn_id);
                    $sub_learn = SubLearns::find($data->sub_learn_id);
                    $bank_soal = BankSoal::find($sub_learn->bank_soal_id);

                    $limit_soal = $sub_learn->limit_soal ?? 10;
                    $sub_soal = SubSoal::where('bank_soal_id', $bank_soal->id)->inRandomOrder()->limit($limit_soal)->get();

                    $data['learns'] = $learn ?? null;
                    $data['sub_learns'] = $sub_learn ?? null;
                    $data['soal'] = $sub_soal ?? null;
                });

                return $this->success('get member sub learn successfully', $member_sub_learn);
            } catch (\Throwable $th) {
                return $this->failure($th->getMessage());
            }
        }

        return $this->notFound('get member sub learn not found');
    }

    public function updateMemberLearn(Request $request, $user_id, $learn_id)
    {
        $validate = $request->only(['level', 'learn', 'active', 'finished', 'start_date', 'end_date']);

        $member_learn = MemberLearn::where(['user_id' => $user_id], ['learn_id' => $learn_id])->first();

        try {
            
            if ($member_learn) {
                $member_learn->update($validate);

                return $this->success('update member learn successfully', $member_learn);
            }

            return $this->notFound();

        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }

        return $this->notFound();
    }

    public function updateMemberSubLearn(Request $request, $user_id, $sub_learn_id)
    {
        $validate = $request->only(['video_status', 'materi_status', 'exam_status', 'min_correct', 'corrected', 'finished']);

        $member_sub_learn = MemberSubLearn::where(['user_id' => $user_id, 'sub_learn_id' => $sub_learn_id])->first();

        try {
            
            if ($member_sub_learn) {
                $member_sub_learn->update($validate);

                return $this->success('update member sub learn successfully', $member_sub_learn);
            }

            return $this->notFound();

        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }

        return $this->notFound();
    }

    public function updateStatusMemberSubLearn(Request $request, $user_id, $sub_learn_id)
    {
        $request->validate([
            'active' => 'nullable',
            'finished' => 'nullable',
        ]);

        $validate = $request->only(['active', 'finished']);

        $member_sub_learn = MemberSubLearn::where(['user_id' => $user_id, 'sub_learn_id' => $sub_learn_id]);

        if (count($member_sub_learn->get()) > 0) {
            try {
                $member_sub_learn->update($validate);

                return $this->success('Update member sub learn successfully', [
                    'test' => $member_sub_learn->get(),
                ]);
            } catch (\Throwable $th) {
               return $this->failure($th->getMessage());
            }
        }

        return $this->notFound('Member sub learn not found');
    }

    public function generateMemberSubLearn(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:member_learns,user_id',
            'learn_id' => 'required|exists:learns,id',
        ]);

        $sub_learn = SubLearns::where('learn_id', $request->learn_id)->get();

        try {
            collect($sub_learn)->each(function($data) use($request){
                MemberSubLearn::create([
                    'user_id' => $request->user_id,
                    'learn_id' => $request->learn_id,
                    'sub_learn_id' => $data->id,
                ]); 
            });

            return $this->success('Generate member sub learn successfully');
        } catch (\Throwable $th) {
            return $this->failure($th->getMessage());
        }
    }
}
