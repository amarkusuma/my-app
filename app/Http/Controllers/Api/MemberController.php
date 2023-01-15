<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MemberLearn;
use App\Models\MemberSubLearn;
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

    public function getMemberSubLearnByUser($user_id){
        $member_sub_learn = MemberSubLearn::where(['user_id' => $user_id])->get();

        return $this->success('get member sub learn successfully', $member_sub_learn);
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

        $member_sub_learn = MemberSubLearn::where(['user_id' => $user_id], ['sub_learn_id' => $sub_learn_id])->first();

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

    public function updateStatusMemberSubLearn(Request $request, $user_id, $learn_id)
    {
        $request->validate([
            'active' => 'nullable',
            'finished' => 'nullable',
        ]);

        $validate = $request->only(['active', 'finished']);

        $member_sub_learn = MemberSubLearn::where(['user_id' => $user_id, 'learn_id' => $learn_id]);

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
}
