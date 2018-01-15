<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mahasiswa;
use Auth;
use Softon\SweetAlert\Facades\SWAL;
use App\Http\Requests\Store\StoreAddMahasiswa;
use Mail;
use App\Mail\MahasiswaEmailVerification;

class MahasiswaController extends Controller
{
  protected $mahasiswas;

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
}
