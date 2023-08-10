<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seksi extends Model
{
    use HasFactory;

    protected $table = 'seksi';
    protected $fillable = [
        'nama_seksi'
    ];

    /**
     * Method One To Many 
     */
    public function pegawai()
    {
    	return $this->hasMany(Pegawai::class);
    }
}
