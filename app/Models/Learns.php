<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learns extends Model
{
    use HasFactory;

    protected $table = 'learns';

    protected $fillable = [
      'name', 'level', 'price', 'discount'
    ];

}
