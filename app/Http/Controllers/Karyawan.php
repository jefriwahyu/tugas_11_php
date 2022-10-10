<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\tbl_karyawan;

class Karyawan extends Controller
{
    public function getData(){
        $data = DB::table('tbl_karyawan')->get();
        if(count($data) > 0){
            $res['pesan'] = "Berhasil mendapatkan data !";
            $res['data_karyawan'] = $data;
            return response($res);
        }else{
            $res['pesan'] = "Tidak ada data !";
            return response($res);
        }
    }

    public function store(Request $request){
        $this->validate($request, [
            'file' => 'required|max: 2048'
        ]);

        
        $file = $request -> file('file');                               // menyimpan file yang di upload ke dalam $file
        $nama_file = time()."_".$file->getClientOriginalName();
        $simpan_file = $file->storeAs('public/foto', $nama_file);       // membuat folder untuk tempat menyimpan file yang di upload
        if($file -> move($simpan_file, $nama_file)){
            $data = tbl_karyawan::create([
                'nama_karyawan' => $request -> nama_karyawan,
                'jabatan'       => $request -> jabatan,
                'umur'          => $request -> umur,
                'alamat'        => $request -> alamat,
                'foto'          => $nama_file
            ]);
            $res['pesan'] = "Berhasil menyimpan data !";
            $res['data_karyawan'] = $data;
            return response($res);
        }else{
            $res['pesan'] = "Gagal menyimpan data !";
            return response($res);
        }
    }

    public function update(Request $request){
        if(!empty($request->file)){
            $this->validate($request, [
                'file' => 'required|max: 2048'
            ]);
    
            
            $file = $request -> file('file');                               // menyimpan file yang di upload ke dalam $file
            $nama_file = time()."_".$file->getClientOriginalName();
            $simpan_file = $file->storeAs('public/foto', $nama_file);       // membuat folder untuk tempat menyimpan file yang di upload
            $file -> move($simpan_file, $nama_file);
            $data = DB::table('tbl_karyawan')->where('id', $request->id)->get();
            foreach ($data as $karyawan){
                Storage::delete('public/foto/'.$karyawan->foto);
                $kar = DB::table('tbl_karyawan')->where('id', $request->id)->update([
                    'nama_karyawan' => $request -> nama_karyawan,
                    'jabatan'       => $request -> jabatan,
                    'umur'          => $request -> umur,
                    'alamat'        => $request -> alamat,
                    'foto'          => $nama_file
                ]);
                $res['pesan'] = "Data berhasil di ubah !";
                $res['data_karyawan'] = $kar;
                return response($res);
            }
        }else{
            $data = DB::table('tbl_karyawan')->where('id', $request->id)->get();
            foreach ($data as $karyawan){
                $kar = DB::table('tbl_karyawan')->where('id', $request->id)->update([
                    'nama_karyawan' => $request -> nama_karyawan,
                    'jabatan'       => $request -> jabatan,
                    'umur'          => $request -> umur,
                    'alamat'        => $request -> alamat
                ]);
                $res['pesan'] = "Data berhasil di ubah !";
                $res['data_karyawan'] = $kar;
                return response($res);
            }
        }
    }

    public function hapus($id){
        $data = DB::table('tbl_karyawan')->where('id', $id)->get();
        foreach($data as $karyawan){
            if(file_exists('public/foto/'.$karyawan->foto)){
                Storage::delete('public/foto/'.$karyawan->foto);
                DB::table('tbl_karyawan')->where('id', $id)->delete();
                $res['pesan'] = "Data berhasil di hapus !";
                return response($res);
            }else{
                $res['pesan'] = "Data tidak ada !";
                return response($res);
            }
        }
    }

    public function bacaData($id){
        $data = DB::table('tbl_karyawan')->where('id', $id)->get();
        if(count($data) > 0){
            $res['pesan'] = "Berhasil mendapatkan data !";
            $res['data_karyawan'] = $data;
            return response($res);
        }else{
            $res['pesan'] = "Data tidak ada !";
            return response($res);
        }
    }
}
