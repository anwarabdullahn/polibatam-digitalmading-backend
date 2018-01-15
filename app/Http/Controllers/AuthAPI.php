<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mahasiswa;
use App\AuthMahasiswa;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Store\StoreAddMahasiswa;
use App\Transformers\MahasiswaTransformer;

use App\Mail\MahasiswaEmailVerification;

use Mail;

use Validator;

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
      'email'     => 'required|email|unique:mahasiswas',
      'nim'       => 'required|unique:mahasiswas',
      'name'      => 'required',
      'password'  => 'required|min:6',
    ], $messsages);

    if ($validator->fails()) {
      $errors = $validator->errors();
      return response()->json([
        'message' => $errors->first()
      ], 406);
    }

    $code = str_random(64);

    $input = array(
      'nim'                       => $request->nim,
      'name'                      => $request->name,
      'email'                     => $request->email,
      'verification_code'         => $code,
      'password'                  => bcrypt($request->password),
    );

    $mahasiswa = Mahasiswa::create($input);

    if ($mahasiswa) {
      $data = array(
        'nim'               => $request->nim,
        'name'              => $mahasiswa->name,
        'verification_code' => $code,
      );
      Mail::to($request->email)->send(new MahasiswaEmailVerification($data));
      return response()->json([
        'message' => 'Akun Berhasil Di Buat, Silahkan Lakukan Verifikasi Email !'
      ], 201);
    }
    return response()->json([
      'message' => 'Akun Gagal Di Buat !'
    ], 400);
  }


  public function login(Request $request)
  {
    $mahasiswa = Mahasiswa::where('email', $request->email)
    ->first();
    // dd($mahasiswa);
    if($mahasiswa){
      if(Hash::check($request->password, $mahasiswa->password))
      {
        if ($mahasiswa->verified == 'Activated') {
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
          }
          return response()->json([
            'message' => 'Gagal Login!'
          ], 401);
        }
        return response()->json([
          'message' => 'Akun Belum DiVerifikasi, Silahkan Lakukan Verifikasi Email !'
        ], 403);
      }
      return response()->json([
        'message' => 'Password Salah!'
      ], 401);
    }
    return response()->json([
      'message' => 'Akun Tidak diTemukan !'
    ], 404);
  }
}
