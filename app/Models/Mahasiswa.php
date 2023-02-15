<?php

namespace App\Models;

use App\Models\Jurusan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $table = 'mahasiswas';
    protected $fillable = ['nik', 'nama', 'jurusan_id', 'tempat_lahir', 'tanggal_lahir', 'alamat'];

    // relationship
    public function jurusan(){
    	return $this->belongsTo(Jurusan::class);
    }
}
