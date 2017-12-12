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


class AnnouncementCategoriesController extends Controller
{
  protected $categories;

  public function __construct()
  {
    $this->categories = AnnouncementCategories::all();
  }

  public function index()
  {
    if (Auth::user()->role =='admin') {
      return view ('layouts.admins.announcements.categories')->with('categories' , $this->categories);
    }return redirect()->route('home')->with('gagal','Invalid Credential !!');
  }

  public function create(StoreAddAnnouncementCategories $request, AnnouncementCategories $category)
  {
    if (Auth::user()->role =='admin') {
      $category->name = $request->name;
      if ($category->save()) {
        return redirect()->route('category')->with('info','Kategori Berhasil di Tambahkan !!');
      }return redirect()->route('category')->with('gagal','Kategori Gagal di Tambahkan !!');
    }return redirect()->route('home')->with('gagal','Invalid Credential !!');
  }

  public function update(UpdateAnnouncementCategories $request)
  {
    if (Auth::user()->role =='admin') {
      $category = $this->categories->where('id', $request->edit_id)->first();
      if ($category) {
        $category->name = $request->editname;
        if ($category->save()) {
          return redirect()->route('category')->with('info','Kategori Berhasil di Ubah !!');
        }return redirect()->route('category')->with('gagal','Kategori Gagal di Ubah !!');
      }return redirect()->route('category')->with('gagal','Kategori Tidak di Temukan !!');
    }return redirect()->route('home')->with('gagal','Invalid Credential !!');
  }

  public function delete(Request $request)
  {
    if (Auth::user()->role =='admin') {
      $category = $this->categories->where('id', $request->hapus_id)->first();
      if ($category) {
        if ($category->delete()) {
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
      ->item($categories)
      ->transformWith(new AnnouncementCategoriesTransformer)
      ->toArray();

      return response()->json($response, 201);
    }
    $messageResponse['message'] = 'Invalid Credentials';
    return response($messageResponse, 401);
  }
}
