<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunData extends Model
{
    use HasFactory;

    protected $table = 'web_tahun_data';
    protected $fillable = ['tahun_data'];
}
