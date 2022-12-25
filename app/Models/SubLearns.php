<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubLearns extends Model
{
    use HasFactory;

    const FILE_PATH = 'files/sub-learn/';
    protected $table = 'sub_learns';

    protected $fillable = [
      'learn_id', 'bank_soal_id', 'sub_name', 'min_correct', 'pdf', 'link_youtube',
    ];

    protected $appends = [
       'pdf_url',
    ];

    public function getPdfUrlAttribute()
    {
        $status = file_exists(public_path() . '/storage/'.self::FILE_PATH . $this->pdf);
        if ($status && $this->pdf) {
            return asset('storage/'.self::FILE_PATH . $this->pdf);
        } else {
            return null;
        }
    }
}
