<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mahasiswa;
use Auth;
use Softon\SweetAlert\Facades\SWAL;
use App\Http\Requests\Store\StoreAddMahasiswa;
use Mail;
use Validator;
use App\Mail\MahasiswaEmailVerification;
use DB;
use Carbon;

class MahasiswaController extends Controller
{
  public function __construct()
  {
    $this->mahasiswas = Mahasiswa::all();
  }

  public function index()
  {
    if (Auth::user()->role =='admin'|| Auth::user()->role =='super') {
      return view ('layouts.admins.mahasiswa.mahasiswa')->with('mahasiswas' , $this->mahasiswas);
    }return redirect()->route('home')->with('gagal','Invalid Credential !!');
  }

  public function verification($nim , $code)
  {
    $mahasiswa = Mahasiswa::where('nim' , $nim)
    ->where('verification_code' ,$code)
    ->first();
    // dd($mahasiswa);
    if ($mahasiswa) {
      $mahasiswa->verification_code = NULL;
      $mahasiswa->verified = true;
      if ($mahasiswa->save()) {
        $swal = swal()->success('Good Job','Your Account successfully Activated!',[]);
        return view('layouts.app', compact('swal'));
      }
    }
    $swal = swal()->error('Sorry','There is an Error while Activating Your Account!',[]);
    return view('layouts.app', compact('swal'));
  }

  public function forgetPassword(Request $request){

    $messsages = array(
      'newpassword.required'  => 'Password Harus diisi.',
      'renewpassword.required'  => 'Password Harus diisi.',
      'rerenewpassword.required'  => 'Password Harus diisi.',
      'newpassword.min'       => 'Password minimal 6 karakter.',
      'renewpassword.same'    => 'Password Tidak Cocok.',
      'rerenewpassword.same'  => 'Password Tidak Cocok.',
    );

    $validator = Validator::make($request->all(), [
      'newpassword'     => 'required|min:6',
      'renewpassword'   => 'required|same:newpassword',
      'rerenewpassword' => 'required|same:rerenewpassword',
    ], $messsages);

    if ($validator->fails()) {
      $nim = $request->nim;
      $code = $request->code;
      return redirect()->route('forget',compact('nim','code'))->withErrors($validator, 'forget');
    }

    $mahasiswa = Mahasiswa::where('nim' , $request->nim)
    ->where('verification_code',$request->code)->first();

    if ($mahasiswa) {
      $mahasiswa->verification_code=null;
      $mahasiswa->password = bcrypt($request->newpassword);
      // dd($mahasiswa->password);
      if ($mahasiswa->save()) {
        $swal = swal()->success('Good Job','Your Password successfully Change!',[]);
        return view('layouts.app', compact('swal'));
      }
      $swal = swal()->error('Sorry','There is an Error while Change Your Password!',[]);
      return view('layouts.app', compact('swal'));
    }
  }

  public function forgetPasswordLayout($nim,$code){
    $mahasiswa = Mahasiswa::where('nim' , $nim)
    ->where('verification_code',$code)->first();

    if ($mahasiswa) {
      return view('layouts.admins.mahasiswa.forget',compact('nim','code'));
    }
  }


  public function create(StoreAddMahasiswa $request, Mahasiswa $mahasiswa)
  {
    if (Auth::user()->role =='admin'|| Auth::user()->role =='super') {

      $code = str_random(64);

      if ($request->verified == 'true') {
        // dd($code);
        $mahasiswa->nim                       = $request->nim;
        $mahasiswa->name                      = $request->name;
        $mahasiswa->email                     = $request->email;
        $mahasiswa->verification_code         = NULL;
        $mahasiswa->password                  = bcrypt($request->password);
        $mahasiswa->verified                  = $request->verified;

        if ($mahasiswa->save()) {
          return redirect()->route('mahasiswa')->with('info','Data Verified Mahasiswa Berhasil Ditambahkan !!');
        }return redirect()->route('mahasiswa')->with('gagal','Data Mahasiswa Gagal di Tambahkan !!');
      }elseif ($request->verified == 'false'){

        $mahasiswa->nim                       = $request->nim;
        $mahasiswa->name                      = $request->name;
        $mahasiswa->email                     = $request->email;
        $mahasiswa->verification_code         = $code;
        $mahasiswa->password                  = bcrypt($request->password);
        $mahasiswa->verified                  = $request->verified;

        if ($mahasiswa->save()) {
          $data = array(
            'nim'               => $request->nim,
            'name'              => $mahasiswa->name,
            'verification_code' => $code,
          );
          Mail::to($request->email)->send(new MahasiswaEmailVerification($data));
          return redirect()->route('mahasiswa')->with('info','Data Non-Verified Mahasiswa Berhasil Ditambahkan, Silahkan Periksa Email Untuk Verifikasi !!');
        }return redirect()->route('mahasiswa')->with('gagal','Data Mahasiswa Gagal di Tambahkan !!');
      }return redirect()->route('mahasiswa')->with('gagal','Data Mahasiswa Gagal di Tambahkan !!');
    }return redirect()->route('home')->with('gagal','Invalid Credential !!');
  }

  public function update(Request $request)
  {
    if (Auth::user()->role =='admin'|| Auth::user()->role =='super') {
      $mahasiswa = Mahasiswa::where('id' , $request->edit_id)->first();
      // dd($mahasiswa);
      if ($mahasiswa) {
        // dd($request->editstatus);
        if ($request->editstatus == 'Activated') {
          $mahasiswa->verification_code         = NULL;
          $mahasiswa->verified                  = 'true';
          if ($mahasiswa->save()) {
            return redirect()->route('mahasiswa')->with('info','Data Mahasiswa Berhasil diubah !!');
          }return redirect()->route('mahasiswa')->with('gagal','Data Mahasiswa Gagal di diubah !!');
        }elseif ($request->editstatus == 'NotActivated') {
          $mahasiswa->verification_code         = NULL;
          $mahasiswa->verified                  = 'false';
          if ($mahasiswa->save()) {
            return redirect()->route('mahasiswa')->with('info','Data Mahasiswa Berhasil diubah !!');
          }return redirect()->route('mahasiswa')->with('gagal','Data Mahasiswa Gagal di diubah !!');
        }
      }return redirect()->route('mahasiswa')->with('gagal','Data Mahasiswa Tidak ditemukan !!');
    }return redirect()->route('home')->with('gagal','Invalid Credential !!');
  }

  public function delete(Request $request)
  {
    if (Auth::user()->role =='admin'|| Auth::user()->role =='super') {
      $mahasiswa = Mahasiswa::where('id' , $request->hapus_id)->first();
      if ($mahasiswa) {
        if ($mahasiswa->delete()) {
          return redirect()->route('mahasiswa')->with('info','Data Mahasiswa Berhasil dihapus !!');
        }return redirect()->route('mahasiswa')->with('gagal','Data Mahasiswa Gagal dihapus !!');
      }return redirect()->route('mahasiswa')->with('gagal','Data Mahasiswa Tidak ditemukan !!');
    }return redirect()->route('home')->with('gagal','Invalid Credential !!');
  }

  public function pushData(Request $request)
  {
    if(($handle = fopen($_FILES['dataUpload']['tmp_name'],"r")) !== FALSE){
      fgetcsv($handle);
      while(($data = fgetcsv($handle,100,",")) !== FALSE){
        // $sama = Mahasiswa::
        try {
          $addMhs = DB::table('mahasiswas')->insert([
            'nim'       => $data[0],
            'name'      => $data[1],
            'email'     => $data[2],
            'password'  => bcrypt('123123'),
            'verified'  => true,
            'created_at'=> Carbon::now()->toDateTimeString(),
            'updated_at'=> Carbon::now()->toDateTimeString(),
          ]);
        } catch(\Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == '1062'){
                echo('Error Message');
            }
        }
      }
      return redirect()->route('mahasiswa')->with('info','Data Mahasiswa Berhasil Ditambahkan !!');
    }
  }

  public function downloadData()
  {
    $mahasiswas = DB::table('mahasiswas')->get();
    $proData = "";

    if(count($mahasiswas)>0){
      $proData .='<table>
      <tr>
      <th>NIM</th>
      <th>Name</th>
      <th>Email</th>
      </tr>';

      foreach ($mahasiswas as $m){
        $proData .='
      <tr>
      <td>'.$m->nim.'</td>
      <td>'.$m->name.'</td>
      <td>'.$m->email.'</td>
      </tr>';
      }
      $proData .='<table>';
    }
    header("Content-Type: .xls");
    header("Content-Disposition: attachment; filename=\"mahasiswa.xls\"");
    header("Cache-Control: max-age=0");
    echo $proData;
  }
}
