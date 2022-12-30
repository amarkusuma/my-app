<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankSoal extends Model
{
    use HasFactory;

    protected $table = 'bank_soal';

    protected $fillable = [
      'name'
    ];

    public function sub_learn()
    {
      return $this->hasOne(SubLearns::class, 'bank_soal_id', 'id'); 
    }

    public function sub_soal()
    {
      return $this->hasMany(SubSoal::class, 'id'); 
    }
}
