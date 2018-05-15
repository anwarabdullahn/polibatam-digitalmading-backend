<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Banner;
use App\AuthMahasiswa;

use App\Http\Requests\Store\StoreAddBanner;
use App\Http\Requests\Update\UpdateBannerPost;
use App\Transformers\BannerTransformer;

use Auth;
use Storage;

class BannerController extends Controller
{
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
    if (Auth::user()->role =='super' || Auth::user()->name == $request->edituser) {
      $adminID = Auth::user()->id;
      $banner = $this->banners->where('id', $request->edit_id)->first();
      if ($banner) {
        $banner->title = $request->edittitle;
        $banner->id_user = $request->editpenerbit;
        if (isset($request->editimage)) {
          $byscryptAttachmentFile =  md5(str_random(64));
          $banner->image = $byscryptAttachmentFile;
        }
        if ($banner->save()) {
          if (isset($request->editimage)) {
            if ($request->editimage->storeAs('public/banner/images' , $byscryptAttachmentFile )) {
              Storage::delete('public/banner/images/'.$id);
              return redirect()->route('banner')->with('info', 'Banner Berhasil Di Ubah');
            }return redirect()->route('banner')->with('gagal', 'Banner Gagal Di Ubah');
          }return redirect()->route('banner')->with('info', 'Banner Berhasil Di Ubah');
        }return redirect()->route('banner')->with('gagal', 'Banner Gagal Di Ubah');
      }return redirect()->route('banner')->with('gagal', 'Banner Gagal Di Temukan!!');
    }return redirect()->route('home')->with('gagal','Invalid Credential !!');
  }

  public function delete(Request $request)
  {
    $id = $request->hapusimage;
    if (Auth::user()->role =='super' || Auth::user()->name == $request->hapususer) {
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
  public function status(Request $request)
  {
    if (Auth::user()->role =='super') {
      $banner = $this->banners->where('id',$request->status_id)->first();
      if ($banner) {
        $banner->status = $request->editstatus;
        if ($banner->save()) {
          return redirect()->route('banner')->with('info','Banner Berhasil Di Ubah');
        }return redirect()->route('banner')->with('gagal','Banner Gagal Di Hapus');
      }return redirect()->route('banner')->with('gagal', 'Banner Gagal Di Temukan!!');
    }return redirect()->route('home')->with('gagal','Invalid Credential !!');
  }

  public function getImage($id) {
    $path = Storage::get('public/banner/images/'.$id);
    $mimetype = Storage::mimeType('public/banner/images/'.$id);
    return response($path, 200)->header('Content-Type', $mimetype);
  }

  public function getAPI(Request $request)
  {
    $authorization = $request->header('Authorization');
    $authMahasiswa = AuthMahasiswa::where('api_token' , $authorization)->first();
    if ($authMahasiswa) {
      $banners = Banner::where('status', '1')->take(5)->get()->sortByDesc('created_at');
      if ($banners) {
        $response = fractal()
        ->collection($banners)
        ->transformWith(new BannerTransformer)
        ->toArray();
        return response()->json(array('result' => $response['data']), 200);
      }
      $messageResponse['message'] = 'Banner Tidak Tersedia';
      return response($messageResponse, 406);
    }
    $messageResponse['message'] = 'Invalid Credentials';
    return response($messageResponse, 401);
  }
}
