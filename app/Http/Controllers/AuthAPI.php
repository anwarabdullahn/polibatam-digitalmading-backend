<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mahasiswa;
use App\AuthMahasiswa;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Store\StoreAddMahasiswa;
use App\Transformers\MahasiswaTransformer;

use App\Mail\MahasiswaForgetPassword;
use App\Mail\MahasiswaEmailVerification;

use Mail;
use Storage;
use Validator;
use File;
use Image;

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
    $mahasiswa = Mahasiswa::where('email', $request->email)->first();
    // dd($mahasiswa);
    if($mahasiswa){
      if(Hash::check($request->password, $mahasiswa->password))
      {
        if ($mahasiswa->verified == 'Activated') {
          $apiStore = AuthMahasiswa::create([
            'api_token'   => bin2hex(openssl_random_pseudo_bytes(64)),
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

  public function profile(Request $request) {
    $authorization = $request->header('Authorization');
    $authMahasiswa = AuthMahasiswa::where('api_token' , $authorization)->first();
    // dd($authMahasiswa->id_mahasiswa);
    if ($authMahasiswa) {
      $mahasiswa = Mahasiswa::where('id' ,$authMahasiswa->id_mahasiswa)->first();
      if ($mahasiswa) {
        $response = fractal()
        ->item($mahasiswa)
        ->transformWith(new MahasiswaTransformer)
        ->toArray();
        return response()->json($response, 201);
      }return response()->json([
        'message' => 'Akun Tidak diTemukan !'
      ], 404);
    }return response()->json([
      'message' => 'Credential is required !'
    ], 405);
  }

  public function profileUpdate(Request $request){
    $authorization = $request->header('Authorization');
    $authMahasiswa = AuthMahasiswa::where('api_token' , $authorization)->first();
    // dd($authMahasiswa->id_mahasiswa);
    if ($authMahasiswa) {
      $mahasiswa = Mahasiswa::where('id' ,$authMahasiswa->id_mahasiswa)->first();
      // dd($mahasiswa);
      if ($mahasiswa) {
        if (isset($request->avatar)) {
          $messsages = array(
            'avatar.mimetypes'   => 'Incorrect File Type.',
          );

          $validator = Validator::make($request->all(), [
            'avatar'  => 'mimetypes:image/jpeg,image/png,image/gif',
          ], $messsages);

          if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
              'message' => $errors->first()
            ], 406);
          }
          $forDelete = $mahasiswa->avatar;
          // $avatar = $request->file('avatar');
          $code = md5(str_random(64));
          $byscryptAttachmentFile =  $code . '.' . $request->avatar->getClientOriginalExtension();
          // $path = $request->avatar->storeAs('public/uploads/avatars', $byscryptAttachmentFile);
          // $path = $request->file('avatar')->move(storage_path('app/public/uploads/avatars'), $byscryptAttachmentFile);
          // dd($path);
          $save = Image::make($request->file('avatar'))->fit(600, 600, function ($constraint) {   $constraint->upsize();})->save(storage_path('app/public/uploads/avatars/'.$byscryptAttachmentFile));
          if ($save) {
            $mahasiswa->avatar = $byscryptAttachmentFile;
            if ($mahasiswa->save()) {
              // $save = $request->avatar->storeAs('public/uploads/avatars', $byscryptAttachmentFile);
              // $save = Storage::disk('local')->store('app/public/uploads/avatars/', $byscryptAttachmentFile, $request->avatar);
              // dd($path);
              // $request->avatar->storeAs('public/uploads/avatars', $byscryptAttachmentFile);
              $delete = storage_path('app/public/uploads/avatars/'.$forDelete);
              // dd($delete);
              if (File::exists($delete)) {
                File::delete($delete);
              }
              return response()->json([
                'message' => 'Update Profile Berhasil'
              ], 200);
            }return response()->json([
              'message' => 'Update Profile Gagal !'
            ], 400);
          }
          return response()->json([
            'message' => 'Update Profile Gagal !'
          ], 400);
        }
      }return response()->json([
        'message' => 'Akun Tidak diTemukan !'
      ], 404);
    }return response()->json([
      'message' => 'Credential is required !'
    ], 405);
  }

  public function dataUpdate(Request $request){
    $authorization = $request->header('Authorization');
    $authMahasiswa = AuthMahasiswa::where('api_token' , $authorization)->first();
    // dd($authMahasiswa->id_mahasiswa);
    if ($authMahasiswa) {
      $mahasiswa = Mahasiswa::where('id' ,$authMahasiswa->id_mahasiswa)->first();
      if ($mahasiswa) {
        if (isset($request->name)) {
          $mahasiswa->name = $request->name;
        }
        if (isset($request->nim)) {
          $mahasiswa->nim = $request->nim;
        }

        if ($mahasiswa->save()) {
          return response()->json([
            'message' => 'Update Profile Berhasil'
          ], 200);
        }
      }return response()->json([
        'message' => 'Akun Tidak diTemukan !'
      ], 404);
    }return response()->json([
      'message' => 'Credential is required !'
    ], 405);
  }

  public function logout(Request $request){
    $authorization = $request->header('Authorization');
    $authMahasiswa = AuthMahasiswa::where('api_token' , $authorization)->first();
    // dd($authMahasiswa->id_mahasiswa);
    if ($authMahasiswa) {
      if ($authMahasiswa->delete()) {
        return response()->json([
          'message' => 'Success'
        ], 200);
      }else {
        return response()->json([
          'message' => 'Invalid Credential'
        ], 401);
      }
    }
    return response()->json([
      'message' => 'Credential is required'
    ], 405);
  }

  public function getContent($id) {
    $path = Storage::get('public/files/'.$id);
    $mimetype = Storage::mimeType('public/files/'.$id);
    return response($path, 200)->header('Content-Type', $mimetype);
  }

  public function updatePassword(Request $request){
    $authorization = $request->header('Authorization');
    $authMahasiswa = AuthMahasiswa::where('api_token' , $authorization)->first();
    if ($authMahasiswa) {
      $mahasiswa = Mahasiswa::where('id' ,$authMahasiswa->id_mahasiswa)->first();
      if ($mahasiswa) {
        $messsages = array(
          'repassword.same'   => 'Password Harus Sama.',
          'password.required'  => 'Password Baru Harus diisi.',
          'oldpassword.required'  => 'Password Lama Harus diisi.',
          'password.min'       => 'Password minimal 6 karakter.',
        );

        $validator = Validator::make($request->all(), [
          'oldpassword'  => 'required',
          'password'  => 'required|min:6',
          'repassword'  => 'same:password',
        ], $messsages);

        if ($validator->fails()) {
          $errors = $validator->errors();
          return response()->json([
            'message' => $errors->first()
          ], 406);
        }

        if (isset($request->password)) {
          if(Hash::check($request->oldpassword, $mahasiswa->password)){
            $mahasiswa->password = bcrypt($request->password);
            if ($mahasiswa->save()) {
              return response()->json([
                'message' => 'Data Berhasil diubah. !'
              ], 200);
            }
          }
          return response()->json([
            'message' => 'Password Lama Salah!'
          ], 401);
        }
      }
    }
  }

  public function resetPassword(Request $request){
    $messsages = array(
      'email.required'  =>  'Silahkan masukkan Alamat Email terlebih dahulu',
      'email.email'     =>  'Silahkan masukkan Alamat Email yang Valid'
    );

    $validator = Validator::make($request->all(), [
      'email' =>  'required|email'
    ], $messsages);

    if ($validator->fails()) {
      $errors = $validator->errors();
      return response()->json([
        'message' => $errors->first()
      ], 406);
    }

    $mahasiswa = Mahasiswa::where('email' , $request->email)->first();
    if ($mahasiswa) {
      $code = str_random(64);


      $data = array(
        'nim'               => $mahasiswa->nim,
        'name'              => $mahasiswa->name,
        'verification_code' => $code,
      );
      $mahasiswa->verification_code = $code;
      if ($mahasiswa->save()) {
        Mail::to($request->email)->send(new MahasiswaForgetPassword($data));
        return response()->json([
          'message' => 'Silahkan Periksa Email!'
        ], 201);
      }
    }return response()->json([
      'message' => 'Akun Tidak diTemukan !'
    ], 404);
  }
}
