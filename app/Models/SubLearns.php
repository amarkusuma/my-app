<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SubLearns extends Model
{
    use HasFactory;

    const FILE_PATH = 'files/sub-learn/';
    const VIDEO_PATH = 'videos/sub-learn/';
    const SOAL_IMAGE_PATH = 'images/sub-learn/';

    protected $table = 'sub_learns';

    protected $fillable = [
      'learn_id', 'bank_soal_id', 'limit_soal', 'sub_name', 'min_correct', 'pdf', 'link_youtube', 'video', 'activated', 'images'
    ];

    protected $appends = [
       'pdf_url',
       'video_url',
    ];

    protected $casts = [
        'images' => 'array',
    ];


    public function getPdfUrlAttribute()
    {
        $status = Storage::disk('local')->exists(self::FILE_PATH . $this->pdf);
        if ($status && $this->pdf) {
            return asset('storage/'.self::FILE_PATH . $this->pdf);
        } else {
            return null;
        }
    }

    public function getSoalImageUrlAttribute($image)
    {
        $status = Storage::disk('local')->exists(self::SOAL_IMAGE_PATH . $image);
        if ($status && $image) {
            return asset('storage/'.self::SOAL_IMAGE_PATH . $image);
        } else {
            return null;
        }
    }

    public function getVideoUrlAttribute()
    {
        $status = Storage::disk('local')->exists(self::VIDEO_PATH . $this->video);
        if ($status && $this->video) {
            return asset('storage/'.self::VIDEO_PATH . $this->video);
        } else {
            return $this->link_youtube;
        }
    }

    public function learn()
    {
        return $this->belongsTo(Learns::class, 'learn_id');
    }

    public function bank_soal()
    {
        return $this->belongsTo(BankSoal::class, 'bank_soal_id');
    }

    // public function sub_soal()
    // {
    //     return $this->hasMany(SubSoal::class, 'bank_soal_id', 'id');
    // }
}
