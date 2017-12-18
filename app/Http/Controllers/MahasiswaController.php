<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mahasiswa;
use Auth;

class MahasiswaController extends Controller
{
  protected $mahasiswa;

  public function __construct()
  {
    $this->mahasiswa = Mahasiswa::all();
  }

  public function index()
  {
    if (Auth::user()->role =='admin') {
      return view ('layouts.admins.mahasiswa.mahasiswa')->with('mahasiswa' , $this->mahasiswa);
    }return redirect()->route('home')->with('gagal','Invalid Credential !!');
  }
}