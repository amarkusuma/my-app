<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberLearn extends Model
{
    use HasFactory;

    protected $table = 'member_learns';

    protected $fillable = [
      'member_id', 'learn_id', 'active', 'start_date', 'end_date'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
    
    public function learn()
    {
        $this->belongsTo(Learns::class, 'learn_id');
    }
}
