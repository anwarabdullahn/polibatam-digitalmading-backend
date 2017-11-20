<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Announcement;
use App\Http\Requests\Store\StoreAddAnnouncement;
use App\Http\Requests\Update\UpdateAnnouncementPost;
use Illuminate\Support\Facades\Response;
// use File;
use Auth;
use Storage;

class AnnouncementController extends Controller
{
    protected $announcements;

    public function __construct()
    {
      $this->announcements = Announcement::all();
    }

    public function index()
    {
      if (Auth::user()->role =='admin') {
        return view ('layouts.admins.announcements.announcement')->with('announcements' , $this->announcements);
      }return redirect()->route('home')->with('gagal','Invalid Credential !!');
    }

    public function create(StoreAddAnnouncement $request, Announcement $announcement)
    {
      if (Auth::user()->role =='admin'){
        $adminID = Auth::user()->id;
        $announcement->title = $request->title;
        $announcement->description = $request->description;
        $announcement->id_user = $adminID;
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
      }return redirect()->route('announcement')->with('gagal','Invalid Credential !!');
    }

    public function update(UpdateAnnouncementPost $request)
    {
      if (Auth::user()->role =='admin') {
        $adminID = Auth::user()->id;
        $announcement = $this->announcements->where('id', $request->edit_id)->first();
        if ($announcement) {
          $announcement->title = $request->edittitle;
          $announcement->description = $request->editdescription;
          $announcement->id_user = $adminID;
          if (isset($request->editimage)) {
            $byscryptAttachmentFile =  md5(str_random(64));
            $announcement->image = $byscryptAttachmentFile;
          }
          if ($announcement->save()) {
            if (isset($request->editimage)) {
              $request->editimage->storeAs('public/announcement/images' , $byscryptAttachmentFile );
              return redirect()->route('announcement')->with('info', 'Announcement Berhasil Di Ubah');
            }return redirect()->route('announcement')->with('info', 'Announcement Berhasil Di Ubah');
          }return redirect()->route('announcement')->with('gagal', 'Announcement Gagal Di Ubah');
        }return redirect()->route('announcement')->with('gagal', 'Announcement Gagal Di Ubah');
      }return redirect()->route('announcement')->with('gagal','Invalid Credential !!');
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
      }return redirect()->route('announcement')->with('gagal','Invalid Credential !!');
    }

    public function getImage($id) {
      $path = Storage::get('public/announcement/images/'.$id);
      $mimetype = Storage::mimeType('public/announcement/images/'.$id);
      return response($path, 200)->header('Content-Type', $mimetype);
    }
}
