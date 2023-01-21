<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriData extends Model
{
    use HasFactory;

    protected $table = 'web_kategori_data';
    protected $fillable = ['web_jenis_data_id','nama_kategori_data'];

}
