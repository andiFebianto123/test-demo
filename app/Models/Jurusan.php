<?php

namespace App\Models;

use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jurusan extends Model
{
    use HasFactory;
    protected $table = 'jurusans';
    protected $fillable = ['kode', 'nama'];

    // relationship
    public function mahasiswas(){
    	return $this->hasMany(Mahasiswa::class);
    }
}
