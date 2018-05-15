<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Announcement;
use App\AnnouncementCategories;
use App\AuthMahasiswa;
use App\Transformers\AnnouncementCategoriesTransformer;
use App\Http\Requests\Store\StoreAddAnnouncementCategories;
use App\Http\Requests\Update\UpdateAnnouncementCategories;

use Image;
use Storage;
use File;

use App\Firebase\Push;
use App\Firebase\Firebase;


class AnnouncementCategoriesController extends Controller
{
  public function __construct()
  {
    $this->categories = AnnouncementCategories::all();
    $this->firebase = new Firebase();
    $this->push = new Push();
  }

  public function index()
  {
    if (Auth::user()->role =='admin'|| Auth::user()->role =='super') {
      return view ('layouts.admins.announcements.categories')->with('categories' , $this->categories);
    }return redirect()->route('home')->with('gagal','Invalid Credential !!');
  }

  public function create(StoreAddAnnouncementCategories $request, AnnouncementCategories $category)
  {
    if (Auth::user()->role =='admin'|| Auth::user()->role =='super') {
      $category->name = $request->name;
      if (isset($request->image)) {
        $byscryptAttachmentFile =  md5(str_random(24)). '.' . $request->image->getClientOriginalExtension();
        // dd($byscryptAttachmentFile);
      }
      $save = Image::make($request->file('image'))->fit(700, 300, function ($constraint) {   $constraint->upsize();})->save(storage_path('app/public/uploads/backgrounds/'.$byscryptAttachmentFile));
      if ($save) {
        $category->image = $byscryptAttachmentFile;
        if ($category->save()) {
          return redirect()->route('category')->with('info','Kategori Berhasil di Tambahkan !!');
        }return redirect()->route('category')->with('gagal','Kategori Gagal di Tambahkan !!');
      }
    }return redirect()->route('home')->with('gagal','Invalid Credential !!');
  }

  public function update(UpdateAnnouncementCategories $request)
  {
    if (Auth::user()->role =='admin'|| Auth::user()->role =='super') {
      $category = $this->categories->where('id', $request->edit_id)->first();
      if ($category) {
        $forDelete = $category->image;
        $category->name = $request->editname;
        if (isset($request->editimage)) {
          $byscryptAttachmentFile =  md5(str_random(24)). '.' . $request->editimage->getClientOriginalExtension();
        }
        $save = Image::make($request->file('editimage'))->fit(700, 300, function ($constraint) {   $constraint->upsize();})->save(storage_path('app/public/uploads/backgrounds/'.$byscryptAttachmentFile));
        if ($save) {
          if ($category->save()) {
            $delete = storage_path('app/public/uploads/backgrounds/'.$forDelete);
            if (File::exists($delete)) {
              File::delete($delete);
            }
            return redirect()->route('category')->with('info','Kategori Berhasil di Ubah !!');
          }return redirect()->route('category')->with('gagal','Kategori Gagal di Ubah !!');
        }
      }return redirect()->route('category')->with('gagal','Kategori Tidak di Temukan !!');
    }return redirect()->route('home')->with('gagal','Invalid Credential !!');
  }

  public function delete(Request $request)
  {
    if (Auth::user()->role =='admin'|| Auth::user()->role =='super') {
      $category = $this->categories->where('id', $request->hapus_id)->first();
      if ($category) {
        $forDelete = $category->image;
        if ($category->delete()) {
          $delete = storage_path('app/public/uploads/backgrounds/'.$forDelete);
          if (File::exists($delete)) {
            File::delete($delete);}
            return redirect()->route('category')->with('info','Kategori Berhasil di Hapus !!');
          }return redirect()->route('category')->with('gagal','Kategori Gagal di Hapus !!');
        }return redirect()->route('category')->with('gagal','Kategori Tidak di Temukan !!');
      }return redirect()->route('home')->with('gagal','Invalid Credential !!');
    }
    public function getAPI(Request $request)
    {
      $authorization = $request->header('Authorization');
      $authMahasiswa = AuthMahasiswa::where('api_token' , $authorization)->first();

      if ($authMahasiswa) {
        $categories = AnnouncementCategories::all()->sortBy('id');
        // dd($category);
        $response = fractal()
        ->collection($categories)
        ->transformWith(new AnnouncementCategoriesTransformer)
        ->toArray();

        return response()->json(array('result' => $response['data']), 200);
      }
      $messageResponse['message'] = 'Invalid Credentials';
      return response($messageResponse, 401);
    }

    public function getContent($id) {
      $path = Storage::get('public/uploads/backgrounds/'.$id);
      $mimetype = Storage::mimeType('public/uploads/backgrounds/'.$id);
      return response($path, 200)->header('Content-Type', $mimetype);
    }

  }
