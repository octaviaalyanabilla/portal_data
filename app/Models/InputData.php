<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InputData extends Model
{
    use HasFactory;

    protected $table = 'web_input_data';
    protected $fillable = ['web_data_utama_id', 'web_jenis_data_id','web_kategori_data_id', 'jumlah_data', 'web_tahun_data_id'];
    
    public function data_utama()
    {
        return $this->belongsTo(DataUtama::class, 'web_data_utama_id', 'id');
    }

    public function jenis_data()
    {
        return $this->belongsTo(JenisData::class, 'web_jenis_data_id', 'id');
    }

    public function kategori_data()
    {
        return $this->belongsTo(KategoriData::class, 'web_kategori_data_id', 'id');
    }

    public function tahun_data()
    {
        return $this->belongsTo(TahunData::class, 'web_tahun_data_id', 'id');
    }
}
