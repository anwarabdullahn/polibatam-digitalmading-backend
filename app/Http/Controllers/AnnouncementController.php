<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AuthMahasiswa;
use App\Announcement;
use App\AnnouncementCategories;

use App\Transformers\AnnouncementTransformer;
use App\Http\Requests\Store\StoreAddAnnouncement;
use App\Http\Requests\Update\UpdateAnnouncementPost;
use Illuminate\Support\Facades\Response;

use Auth;
use Storage;


class AnnouncementController extends Controller
{
    protected $announcements;
    protected $categories;

    public function __construct()
    {
      $this->announcements = Announcement::all();
      $this->categories = AnnouncementCategories::all();
    }

    public function index()
    {
      if (Auth::user()->role =='admin') {
        return view ('layouts.admins.announcements.announcement')->with('announcements' , $this->announcements)->with('categories' , $this->categories);
      }return redirect()->route('home')->with('gagal','Invalid Credential !!');
    }

    public function create(StoreAddAnnouncement $request, Announcement $announcement)
    {
      if (Auth::user()->role =='admin'){
        $adminID = Auth::user()->id;
        $announcement->title = $request->title;
        $announcement->description = $request->description;
        $announcement->id_user = $adminID;
        $announcement->id_category = $request->id_category;
        if (isset($request->image)) {
          $byscryptAttachmentFile =  md5(str_random(64));
          $announcement->image = $byscryptAttachmentFile;
          // dd($byscryptAttachmentFile);
        }
        if ($announcement->save()) {
          if (isset($request->image)) {
            $request->image->storeAs('public/announcement/images' , $byscryptAttachmentFile );
            return redirect()->route('announcement')->with('info','Announcement Berhasil Di Tambahkan');
          }return redirect()->route('announcement')->with('gagal','Announcement Gagal Di Tambahkan');
        }return redirect()->route('announcement')->with('gagal','Announcement Gagal Di Tambahkan');
      }return redirect()->route('home')->with('gagal','Invalid Credential !!');
    }

    public function update(UpdateAnnouncementPost $request)
    {
      $id = $request->editimagefordelete;
      if (Auth::user()->role =='admin') {
        $adminID = Auth::user()->id;
        $announcement = $this->announcements->where('id', $request->edit_id)->first();
        if ($announcement) {
          $announcement->title = $request->edittitle;
          $announcement->description = $request->editdescription;
          $announcement->id_user = $request->edit_penerbit;
          $announcement->id_category = $request->id_categoryedit;
          if (isset($request->editimage)) {
            $byscryptAttachmentFile =  md5(str_random(64));
            $announcement->image = $byscryptAttachmentFile;
          }
          if ($announcement->save()) {
            if (isset($request->editimage)) {
              if ($request->editimage->storeAs('public/announcement/images' , $byscryptAttachmentFile )) {
                Storage::delete('public/announcement/images/'.$id);
                return redirect()->route('announcement')->with('info', 'Announcement Berhasil Di Ubah');
              }return redirect()->route('announcement')->with('gagal', 'Announcement Gagal Di Ubah');
            }return redirect()->route('announcement')->with('info', 'Announcement Berhasil Di Ubah');
          }return redirect()->route('announcement')->with('gagal', 'Announcement Gagal Di Ubah');
        }return redirect()->route('announcement')->with('gagal','Announcement Tidak Ditemukan');
      }return redirect()->route('home')->with('gagal','Invalid Credential !!');
    }

    public function delete(Request $request)
    {
      $id = $request->hapusimage;
      if (Auth::user()->role =='admin') {
        $announcement = $this->announcements->where('id',$request->hapus_id)->first();
        if ($announcement) {
          if ($announcement->delete()) {
            if (Storage::delete('public/announcement/images/'.$id)) {
              return redirect()->route('announcement')->with('info','Announcement Berhasil Di Hapus');
            }return redirect()->route('announcement')->with('gagal','Announcement Gagal Di Hapus');
          }return redirect()->route('announcement')->with('gagal','Announcement Gagal Di Hapus');
        }return redirect()->route('announcement')->with('gagal','Announcement Tidak Ditemukan');
      }return redirect()->route('home')->with('gagal','Invalid Credential !!');
    }

    public function getImage($id) {
      $path = Storage::get('public/announcement/images/'.$id);
      $mimetype = Storage::mimeType('public/announcement/images/'.$id);
      return response($path, 200)->header('Content-Type', $mimetype);
    }

    public function getAPI(Request $request)
    {
      $authorization = $request->header('Authorization');
      $authMahasiswa = AuthMahasiswa::where('api_token' , $authorization)->first();

      if ($authMahasiswa) {
        $announcements = Announcement::get()->sortByDesc('created_at');
        // dd($announcements);
        $response = fractal()
        ->item($announcements)
        ->transformWith(new AnnouncementTransformer)
        ->toArray();

        return response()->json($response, 201);
      }
      $messageResponse['message'] = 'Invalid Credentials';
         return response($messageResponse, 401);
    }

    public function byCategoryAPI(Request $request,$id)
    {
      $authorization = $request->header('Authorization');
      $authMahasiswa = AuthMahasiswa::where('api_token' ,$authorization)->first();
      if ($authMahasiswa) {
        $announcements = Announcement::where('id_category', $id)->get()->sortByDesc('created_at');
        if ($announcements) {
          $response = fractal()
          ->item($announcements)
          ->transformWith(new AnnouncementTransformer)
          ->toArray();

          return response()->json($response, 201);
        }
        $messageResponse['message'] = 'Kategori Tidak Tersedia';
        return response($messageResponse, 406);
      }
      $messageResponse['message'] = 'Invalid Credentials';
      return response($messageResponse, 401);
    }
}
