<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataUtama extends Model
{
    use HasFactory;

    protected $table = 'web_data_utama';
    protected $fillable = ['nama_data'];
    
    public function jenis_data()
    {
       return $this->hasOne(JenisData::class);
    }
}
