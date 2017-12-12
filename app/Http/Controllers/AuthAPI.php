<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mahasiswa;
use Illuminate\Support\Facades\Hash;
use App\AuthMahasiswa;
use App\Http\Requests\Store\StoreAddMahasiswa;
use Validator;
use App\Transformers\MahasiswaTransformer;

class AuthAPI extends Controller
{
  public function register(Request $request)
  {
     $messsages = array(
          'name.required'      => 'Nama Harus diisi.',
          'email.required'     => 'Alamat Email Harus diisi.',
          'email.email'        => 'Alamat Email tidak valid.',
          'email.unique'       => 'Alamat Email telah digunakan.',
          'nim.required'       => 'NIM Harus diisi.',
          'nim.unique'         => 'NIM telah digunakan.',
          'password.required'  => 'Password Harus diisi.',
          'password.min'       => 'Password minimal 6 karakter.',
        );

     $validator = Validator::make($request->all(), [
          'nim'       => 'required|unique:mahasiswas',
          'name'      => 'required',
          'email'     => 'required|email|unique:mahasiswas',
          'password'  => 'required|min:6'
     ], $messsages);

     if ($validator->fails()) {
       $errors = $validator->errors();
       return response()->json([
        'message' => $errors->first()
       ], 406);
     }

      $dataMahasiswa = Mahasiswa::create([
        'nim'       => $request->nim,
        'name'      => $request->name,
        'email'     => $request->email,
        'password'  => bcrypt($request->password)
      ]);

      if ($dataMahasiswa) {
        $messageResponse['message'] = 'Akun Berhasil Di Buat !';
           return response($messageResponse, 201);
      }
      $messageResponse['message'] = 'Akun Gagal Di Buat !';
       return response($messageResponse, 400);
     }


  public function login(Request $request)
  {
    $mahasiswa = Mahasiswa::where('email', $request->email)->first();

    if($mahasiswa){
      if(Hash::check($request->password, $mahasiswa->password))
      {
        $apiStore = AuthMahasiswa::create([
          'api_token'   => bin2hex(str_random(20)),
          'platfom'     =>  $request->platfom,
          'id_mahasiswa' => $mahasiswa->id,
        ]);
        if ($apiStore) {
          $response = fractal()
              ->item($mahasiswa)
              ->transformWith(new MahasiswaTransformer)
              ->addMeta([
                'token' => $apiStore->api_token,
              ])
              ->toArray();
            return response()->json($response, 201);
          }$messageResponse['message'] = 'Gagal Login';
          return response($messageResponse, 401);
        }$messageResponse['message'] = 'Password Salah';
         return response($messageResponse, 401);
      }$messageResponse['message'] = 'Akun Tidak Ada';
      return response($messageResponse, 404);
    }
}
