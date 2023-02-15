<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    function index(){
        $mahasiswa = Mahasiswa::get();
        return view('admin/index', ['mahasiswas' => $mahasiswa]);
    }

    private function jurusan_options(){
        $datas = Jurusan::get();
        $results = [];
        foreach($datas as $data){
            $results[] = ['value' => $data->id, 'text' => $data->nama];
        }
        return $results;
    }

    function select_kota($id){
        $province_id = $id;
        $city_options = [];
        $response = Http::get('https://api.sevenmediatech.com/kota', [
            'province_id' => $province_id
        ]);
        if($response->status() == 200){
            $cities = $response->json();
            foreach($cities['content'] as $city){
                $city_options[] = ['value' => $city['name'], 'text' => $city['name']];
            }
        }else {
            return response()->json([
                'status' => false,
                'results' => [],
                'message' => 'Server is error' 
            ], 200);
        }
        return response()->json([
            'status' => true,
            'results' => $city_options, 
        ], 200);
    }

    function create(){
        $province_options = [];
        $response = Http::get('https://api.sevenmediatech.com/provinsi', []);
        if($response->status() == 200){
            $provinces = $response->json();
            foreach($provinces['content'] as $province){
                $province_options[] = ['value' => $province['id'], 'text' => $province['name']];
            }
        }
        return view('admin/create', [
            'province_options' => $province_options,
            'jurusan_options' => $this->jurusan_options(),
        ]);        
    }

    function store(Request $req){
        $validator = Validator::make($req->all(), [
            'nim' => 'required',
            'nama' => 'required',
            'tanggal_lahir' => 'required',
            'jurusan' => 'required',
            'provinsi' => 'required',
            'kota' => 'required',
            'alamat' => 'required',
        ]);
        if($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->back()->withErrors($errors);
        }
        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = $req->nim;
        $mahasiswa->nama = $req->nama;
        $mahasiswa->tanggal_lahir = $req->tanggal_lahir;
        $mahasiswa->provinsi_id = $req->provinsi;
        $mahasiswa->tempat_lahir = $req->kota;
        $mahasiswa->jurusan_id = $req->jurusan;
        $mahasiswa->alamat = $req->alamat;
        $mahasiswa->save();
        return redirect('mahasiswa');
    }

    function destroy($id){
        $mahasiswa = Mahasiswa::where('id', $id)->first();
        if($mahasiswa != null){
            $mahasiswa->delete();
            return response()->json([
                'status' => true,
                'message' => 'Success deleted this data',
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Delete data is fail',
        ]);
    }

    function edit($id){
        $mahasiswa = Mahasiswa::where('id', $id)->first();
        $province_options = [];
        $city_options = [];
        $response = Http::get('https://api.sevenmediatech.com/provinsi', []);
        if($response->status() == 200){
            $provinces = $response->json();
            foreach($provinces['content'] as $province){
                if($province['id'] == $mahasiswa->provinsi_id){
                    $province_options[] = [
                        'value' => $province['id'], 
                        'text' => $province['name'],
                        'status' => 'selected',
                    ];
                }else{
                    $province_options[] = ['value' => $province['id'], 'text' => $province['name']];
                }
            }
        }

        $response = Http::get('https://api.sevenmediatech.com/kota', [
            'province_id' => $mahasiswa->provinsi_id
        ]);

        if($response->status() == 200){
            $cities = $response->json();
            foreach($cities['content'] as $city){
                if($city['name'] == $mahasiswa->tempat_lahir){
                    $city_options[] = [
                        'value' => $city['name'], 
                        'text' => $city['name'],
                        'status' => 'selected',
                    ];
                }else{
                    $city_options[] = ['value' => $city['name'], 'text' => $city['name']];
                }
            }
        }

        $jurusan = Jurusan::get();
        $jurusan_options = [];

        foreach($jurusan as $j){
            if($j->id == $mahasiswa->jurusan_id){
                $jurusan_options[] = ['value' => $j['id'], 
                    'text' => $j['nama'], 'status' => 'selected'];
            }else{
                $jurusan_options[] = ['value' => $j['id'], 
                    'text' => $j['nama']];
            }
        }

        $data = [
            'data' => $mahasiswa,
            'province_options' => $province_options,
            'jurusan_options' => $jurusan_options,
            'cities_options' => $city_options,
        ];

        return view('admin/edit', $data);
    }

    function update(Request $req){
        $validator = Validator::make($req->all(), [
            'nim' => 'required',
            'nama' => 'required',
            'tanggal_lahir' => 'required',
            'jurusan' => 'required',
            'provinsi' => 'required',
            'kota' => 'required',
            'alamat' => 'required',
        ]);
        if($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->back()->withErrors($errors);
        }

        $mahasiswa = Mahasiswa::where('id', $req->id)->first();
        $mahasiswa->nim = $req->nim;
        $mahasiswa->nama = $req->nama;
        $mahasiswa->tanggal_lahir = $req->tanggal_lahir;
        $mahasiswa->provinsi_id = $req->provinsi;
        $mahasiswa->tempat_lahir = $req->kota;
        $mahasiswa->jurusan_id = $req->jurusan;
        $mahasiswa->alamat = $req->alamat;
        $mahasiswa->save();
        return redirect('mahasiswa');
    }

    function laporan(){
        $datenow = Carbon::now();
        $yearold = (int) $datenow->format('Y') - 21;
        $yearoldago = $yearold.'-'.$datenow->format('m').'-'.$datenow->format('d');
        $mahasiswa = $mahasiswa = Mahasiswa::whereHas('jurusan', function($q){
            $q->where('kode', 'T01');
        })->where('tanggal_lahir', '<', $yearoldago);
        return view('admin/laporan', ['mahasiswas' => $mahasiswa->get()]);
    }
}
