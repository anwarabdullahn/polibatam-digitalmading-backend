<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Http\Requests\Store\StoreAddOrmawa;
use App\Http\Requests\Update\UpdateOrmawaPost;
class AdminController extends Controller
{
    //
    public function __construct()
    {
        $this->admins = User::where('role' , 'admin')->get();
    }

    public function index()
    {
        if (Auth::user()->role =='super') {
        return view('layouts.admins.admins.admin')->with('admins' , $this->admins);
        }return redirect()->route('home')->with('gagal','Invalid Credential !!');
    }

    public function create(StoreAddOrmawa $request,User $user)
    {
        if (Auth::user()->role =='admin' || Auth::user()->role =='super') {
        $user->name   = $request->nama;
        $user->email  = $request->email;
        $user->notelpon = $request->notelpon;
        $user->role   = "admin";
        $user->password = bcrypt($request->password);
        if ($user->save()) {
            return redirect()->route('admin')->with('info','Admin Berhasil Di Tambahkan');
        }return redirect()->route('admin')->with('gagal','Admin Gagal Di Tambahkan');
        }return redirect()->route('home')->with('gagal','Invalid Credential !!');
    }

    public function update(UpdateOrmawaPost $request)
    {
        if (Auth::user()->role =='super') {
        $user = $this->admins->where('id', $request->edit_id)->first();
        if ($user) {
            $user->name       = $request->editname;
            $user->email      = $request->editemail;
            $user->role       = "admin";
            if ($request->notelpon) {
            $user->notelpon   = $request->notelpon;
            }
            if ($request->editpassword) {
            $user->password   = bcrypt($request->editpassword);
            }
            if ($user->save()) {
            return redirect()->route('admin')->with('info','Admin Berhasil Di Ubah');
            }return redirect()->route('admin')->with('gagal','Admin Gagal Di Ubah');
        }return redirect()->route('admin')->with('gagal','Admin Gagal Di Ubah');
        }return redirect()->route('home')->with('gagal','Invalid Credential !!');
    }

  public function delete(Request $request)
  {
    if (Auth::user()->role =='super') {
      $user = $this->admins->where('id', $request->hapus_id)->first();
      if ($user) {
        if ($user->delete()) {
          return redirect()->route('admin')->with('info','Admin Berhasil Di Hapus');
        }return redirect()->route('admin')->with('gagal','Admin Gagal Di Hapus');
      }return redirect()->route('admin')->with('gagal','Admin Tidak Ditemukan');
    }return redirect()->route('home')->with('gagal','Invalid Credential !!');
  }
}
