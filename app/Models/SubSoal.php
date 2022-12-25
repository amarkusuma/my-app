<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubSoal extends Model
{
    use HasFactory;

    protected $table = 'sub_soal';

    protected $fillable = [
      'bank_soal_id', 'question', 'correct_answer', 'correct_option', 'option_A', 'option_B', 'option_C', 'option_D'
    ];

    public function bank_soal()
    {
        return $this->belongsTo(BankSoal::class, 'bank_soal_id');
    }
}
