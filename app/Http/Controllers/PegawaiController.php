<?php

namespace App\Http\Controllers;

use App\Pegawai;
use Illuminate\Http\Request;
use Validator;
use Auth;

class PegawaiController extends Controller
{

    
    
    public function index()
    {
        return response()->json(Pegawai::all(),200);
    }


    public function login(Request $request)
    {
        

        if (Auth::attempt($request->only(['Email', 'Password']))) {
            $status = 200;
            $response = [
                'pegawai' => Auth::pegawai(),
                'token' => Auth::pegawai()->createToken('AtmaAuto')->accessToken,
            ];
            return response()->json([$response, $status]);
        }

        
    }

    public function register(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'Nama' => 'required|max:50',
        //     'Email' => 'required|email',
        //     'Password' => 'required|min:6',
        //     'Alamat' => 'required|max:50',
        //     'Gaji' => 'required',
        //     'Role' => 'required',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['error' => $validator->errors()], 401);
        // }

        $data = $request->only(['Nama', 'Email', 'Password', 'Alamat', 'Gaji', 'Role']);
        

        $pegawai = Pegawai::create($data);
        

        return response()->json([
            'pegawai' => $pegawai,
            
        ]);
    }

    public function gantiPassword(Request $request, Pegawai $pegawai)
    {
        $status = $pegawai->update(
            $request->only([
                'Password' => $request->Password
            ])
        );
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Password Diupdate!' : 'Error Mengupdate Password'
        ]);
    }

    public function show(Pegawai $pegawai)
    {
        return response()->json($pegawai,200);
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $status = $pegawai->update(
            $request->only([
                'Nama' => $request->Nama,
                'Email' => $request->Email,
                'Alamat' => $request->Alamat,
                'Gaji' => $request->Gaji,
                'Role' => $request->Role,                 
        
            ])
        );
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Pegawai Diupdate!' : 'Error Mengupdate Pegawai'
        ]);
    }

    public function destroy(Pegawai $pegawai)
    {
        $status = $pegawai->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Pegawai Berhasil di Hapus!' : 'Error Menghapus Pegawai'
        ]);
    }
}
