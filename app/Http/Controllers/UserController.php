<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Http\Requests\Store\StoreAddOrmawa;
use App\Http\Requests\Update\UpdateOrmawaPost;

class UserController extends Controller
{
  protected $users;

  public function __construct()
  {
    $this->users = User::where('role' , 'ormawa')->get();;
  }

  public function index()
  {
    if (Auth::user()->role =='admin') {
      return view('layouts.admins.users.ormawa')->with('users' , $this->users);
    }return redirect()->route('home')->with('gagal','Invalid Credential !!');
  }

  public function create(StoreAddOrmawa $request,User $user)
  {
    if (Auth::user()->role =='admin') {
      $user->name   = $request->nama;
      $user->email  = $request->email;
      $user->notelpon = $request->notelpon;
      $user->role   = "ormawa";
      $user->password = bcrypt($request->password);
      if ($user->save()) {
        return redirect()->route('ormawa')->with('info','Ormawa Berhasil Di Tambahkan');
      }return redirect()->route('ormawa')->with('gagal','Ormawa Gagal Di Tambahkan');
    }return redirect()->route('home')->with('gagal','Invalid Credential !!');
  }

  public function update(UpdateOrmawaPost $request)
  {
    if (Auth::user()->role =='admin') {
      $user = $this->users->where('id', $request->edit_id)->first();
      if ($user) {
        $user->name       = $request->editname;
        $user->email      = $request->editemail;
        $user->role       = "ormawa";
        if ($request->notelpon) {
          $user->notelpon   = $request->notelpon;
        }
        if ($request->editpassword) {
          $user->password   = bcrypt($request->editpassword);
        }
        if ($user->save()) {
          return redirect()->route('ormawa')->with('info','Ormawa Berhasil Di Ubah');
        }return redirect()->route('ormawa')->with('gagal','Ormawa Gagal Di Ubah');
      }return redirect()->route('ormawa')->with('gagal','Ormawa Gagal Di Ubah');
    }return redirect()->route('home')->with('gagal','Invalid Credential !!');
  }

  public function delete(Request $request)
  {
    if (Auth::user()->role =='admin') {
      $user = $this->users->where('id', $request->hapus_id)->first();
      if ($user) {
        if ($user->delete()) {
          return redirect()->route('ormawa')->with('info','Ormawa Berhasil Di Hapus');
        }return redirect()->route('ormawa')->with('gagal','Ormawa Gagal Di Hapus');
      }return redirect()->route('ormawa')->with('gagal','Ormawa Tidak Ditemukan');
    }return redirect()->route('home')->with('gagal','Invalid Credential !!');
  }
}
