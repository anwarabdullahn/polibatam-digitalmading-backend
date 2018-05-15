<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use App\Http\Requests\Store\StoreAddOrmawa;
use App\Http\Requests\Update\UpdateOrmawaPost;
use App\Http\Requests\Update\UpdateUserPasswordPost;
use Illuminate\Support\Facades\Hash;

use Auth;
use Image;
use File;
use Storage;

class UserController extends Controller
{
  public function __construct()
  {
    $this->users = User::where('role' , 'ormawa')->get();
  }

  public function index()
  {
    if (Auth::user()->role =='admin' || Auth::user()->role =='super') {
      return view('layouts.admins.users.ormawa')->with('users' , $this->users);
    }return redirect()->route('home')->with('gagal','Invalid Credential !!');
  }

  public function create(StoreAddOrmawa $request,User $user)
  {
    if (Auth::user()->role =='admin' || Auth::user()->role =='super') {
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
    if (Auth::user()->role =='admin' || Auth::user()->role =='super') {
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
    if (Auth::user()->role =='admin' || Auth::user()->role =='super') {
      $user = $this->users->where('id', $request->hapus_id)->first();
      if ($user) {
        if ($user->delete()) {
          return redirect()->route('ormawa')->with('info','Ormawa Berhasil Di Hapus');
        }return redirect()->route('ormawa')->with('gagal','Ormawa Gagal Di Hapus');
      }return redirect()->route('ormawa')->with('gagal','Ormawa Tidak Ditemukan');
    }return redirect()->route('home')->with('gagal','Invalid Credential !!');
  }

  public function profileUpdate(Request $request)
  {
    $user = Auth::user();
    if ($request->admin === $user->name) {
      $forDelete = $user->avatar;
        if ($request->description || $request->name) {
          if ($request->description) {
            $user->deskripsi = $request->description;
          }
          if ($request->name) {
            $user->name = $request->name;
          }
          if ($user->save()) {
            return redirect()->route('home')->with('info','Profile About Berhasil Di Tukar');
          }return redirect()->route('home')->with('gagal','Profile About Gagal Di Tukar');
        }elseif (isset($request->avatar)) {
            $avatar = $request->file('avatar');
            $byscryptAttachmentFile =  md5(str_random(64)) . '.' . $avatar->getClientOriginalExtension();
            $user->avatar = $byscryptAttachmentFile;
          if ($request->avatar->storeAs('public/uploads/avatars' , $byscryptAttachmentFile ))
              if ($user->save()) {
                if ($forDelete == 'avatar.jpg') {
                  return redirect()->route('home')->with('info','Profile Image Berhasil Di Tukar');
                }
                if (Storage::delete('public/uploads/avatars/'.$forDelete)) {
                  return redirect()->route('home')->with('info','Profile Image Berhasil Di Tukar');
                }
            }return redirect()->route('home')->with('gagal','Profile Image Gagal Di Tukar');
        }return redirect()->route('home')->with('gagal','Silahkan Lengkapi Data');
    }return redirect()->route('home')->with('gagal','Invalid Credential !!');
  }

  public function getProfile($id)
  {
    $path = Storage::get('public/uploads/avatars/'.$id);
    $mimetype = Storage::mimeType('public/uploads/avatars/'.$id);
    return response($path, 200)->header('Content-Type' ,$mimetype);
  }

  public function passwordUpdate(UpdateUserPasswordPost $request)
  {
    $user = Auth::user();
    if ($user->name == $request->admin) {
      if (Hash::check($request->oldpassword , $user->password)) {
        $user->password = bcrypt($request->newpassword);
        if ($user->save()) {
          return redirect()->route('home')->with('info','Password Berasil Di Tukar');
        }
      }return redirect()->route('home')->with('gagal','Password Lama Salah !!');
    }return redirect()->route('home')->with('gagal','Invalid Credential !!');
  }
}
