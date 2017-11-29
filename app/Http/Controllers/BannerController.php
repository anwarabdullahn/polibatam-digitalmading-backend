<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banner;
use App\Http\Requests\Store\StoreAddBanner;
use App\Http\Requests\Update\UpdateBannerPost;
use Auth;
use Storage;

class BannerController extends Controller
{
  protected $banners;

  public function __construct()
  {
    $this->banners = Banner::all();
  }

  public function index()
  {
    return view('layouts.admins.banners.banner')->with('banners', $this->banners);
  }

  public function create(StoreAddBanner $request, Banner $banner)
  {
    $adminID = Auth::user()->id;
    $banner->title   = $request->title;
    $banner->status = $request->status;
    $banner->id_user = $adminID;
    if (isset($request->image)) {
      $byscryptAttachmentFile =  md5(str_random(64));
      $banner->image = $byscryptAttachmentFile;
    }
    if ($banner->save()) {
      if (isset($request->image)) {
        $request->image->storeAs('public/banner/images' , $byscryptAttachmentFile );
        return redirect()->route('banner')->with('info','Banner Berhasil Di Tambahkan');
      }return redirect()->route('banner')->with('gagal','Banner Gagal Di Tambahkan');
    }return redirect()->route('banner')->with('gagal','Banner Gagal Di Tambahkan');
  }

  public function update(UpdateBannerPost $request)
  {
    $id = $request->editimagefordelete;
    if (Auth::user()->role =='admin' || Auth::user()->name == $request->edituser) {
      $adminID = Auth::user()->id;
      $banner = $this->banners->where('id', $request->edit_id)->first();
      if ($banner) {
        $banner->title = $request->edittitle;
        $banner->status = $request->editstatus;
        $banner->id_user = $request->editpenerbit;
        if (isset($request->editimage)) {
          $byscryptAttachmentFile =  md5(str_random(64));
          $banner->image = $byscryptAttachmentFile;
        }
        if ($banner->save()) {
          if (isset($request->editimage)) {
            Storage::delete('public/banner/images/'.$id);
            $request->editimage->storeAs('public/banner/images' , $byscryptAttachmentFile );
            return redirect()->route('banner')->with('info', 'Banner Berhasil Di Ubah');
          }return redirect()->route('banner')->with('info', 'Banner Berhasil Di Ubah');
        }return redirect()->route('banner')->with('gagal', 'Banner Gagal Di Ubah');
      }return redirect()->route('banner')->with('gagal', 'Banner Gagal Di Temukan!!');
    }return redirect()->route('home')->with('gagal','Invalid Credential !!');
  }

  public function delete(Request $request)
  {
    $id = $request->hapusimage;
    if (Auth::user()->role =='admin' || Auth::user()->name == $request->hapususer) {
      $banner = $this->banners->where('id',$request->hapus_id)->first();
      if ($banner) {
        if ($banner->delete()) {
          if (Storage::delete('public/banner/images/'.$id)) {
            return redirect()->route('banner')->with('info','Banner Berhasil Di Hapus');
          }return redirect()->route('banner')->with('gagal', 'Banner Gagal Di Hapus');
        }return redirect()->route('banner')->with('gagal', 'Banner Gagal Di Hapus');
      }return redirect()->route('banner')->with('gagal', 'Banner Gagal Di Temukan!!');
    }return redirect()->route('home')->with('gagal','Invalid Credential !!');
  }
}
