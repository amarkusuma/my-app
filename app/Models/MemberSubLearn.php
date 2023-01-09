<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberSubLearn extends Model
{
    use HasFactory;

    protected $table = 'member_sub_learn';

    protected $fillable = [
      'user_id', 'learn_id', 'sub_learn_id', 'video_status', 'materi_status', 'exam_status', 'min_correct', 'corrected', 'finished',
    ];

    protected $with = [
        'user',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function learn()
    {
        $this->belongsTo(Learns::class, 'learn_id');
    }

    public function sub_learn()
    {
        $this->belongsTo(SubLearns::class, 'sub_learn_id');
    }

}
