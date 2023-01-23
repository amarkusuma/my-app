<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberLearn extends Model
{
    use HasFactory;

    protected $table = 'member_learns';

    protected $fillable = [
      'user_id', 'learn_id', 'active', 'start_date', 'end_date', 'level', 'learn', 'finished', 'generated'
    ];

    protected $with = [
        'user'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function learn()
    {
       return  $this->belongsTo(Learns::class, 'learn_id');
    }
}
