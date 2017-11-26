<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banner;
use App\Http\Requests\Store\StoreAddBanner;
use Auth;

class BannerController extends Controller
{
  protected $banners;

  public function __construct()
  {
    // $this->middleware('auth:admin');
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
      }
    }return redirect()->route('banner')->with('gagal','Banner Gagal Di Tambahkan');
  }
}
