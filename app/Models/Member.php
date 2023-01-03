<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';

    protected $fillable = [
      'user_id', 'learn_id', 'prov_id', 'city_id', 'level', 'learn', 'start_date', 'end_date', 'active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function learn()
    {
        $this->belongsTo(Learns::class, 'learn_id');
    }
}
