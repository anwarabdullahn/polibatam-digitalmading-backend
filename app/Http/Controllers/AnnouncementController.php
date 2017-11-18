<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Announcement;
use App\Http\Requests\Store\StoreAddAnnouncement;
use App\Http\Requests\Update\UpdateAnnouncementPost;
use File;
use Illuminate\Support\Facades\Response;
use Auth;
use Storage;

class AnnouncementController extends Controller
{
    protected $announcements;

    public function __construct()
    {
        // $this->middleware('auth');
        $this->announcements = Announcement::all();
    }

    public function index()
    {
      return view ('layouts.admins.announcement.announcement')->with('announcements' , $this->announcements);
    }

    public function create(StoreAddAnnouncement $request, Announcement $announcement)
    {
      $adminID = Auth::user()->id;
      // dd($admin);
      $announcement->title = $request->title;
      $announcement->description = $request->description;
      $announcement->id_user = $adminID;

      if (isset($request->image)) {
        $byscryptAttachmentFile =  md5(str_random(64));
        $announcement->image = $byscryptAttachmentFile;
        // dd($byscryptAttachmentFile);
      } if ($announcement->save()) {
      if (isset($request->image)) {
        $request->image->storeAs('public/announcement/images' , $byscryptAttachmentFile );
        return redirect()->route('announcement')->with('info','Announcement Berhasil Di Tambahkan');
      }
      }return redirect()->route('announcement')->with('gagal','Announcement Gagal Di Tambahkan');
    }

    public function update(UpdateAnnouncementPost $request)
    {
      $adminID = Auth::user()->id;
      // dd($adminID);
      $announcement = $this->announcements->where('id', $request->edit_id)->first();

      if ($announcement) {
        $announcement->title = $request->edittitle;
        $announcement->description = $request->editdescription;
        $announcement->id_user = $adminID;

        // dd($request->editdescription);

        if (isset($request->editimage)) {
          $byscryptAttachmentFile =  md5(str_random(64));
          $announcement->image = $byscryptAttachmentFile;
          // dd($announcement->image);
        }

        if ($announcement->save()) {
          if (isset($request->editimage)) {
            $request->editimage->storeAs('public/announcement/images' , $byscryptAttachmentFile );
            return redirect()->route('announcement')->with('info', 'Announcement Berhasil Di Ubah');
            }
          return redirect()->route('announcement')->with('info', 'Announcement Berhasil Di Ubah');
          }
      }
      return redirect()->route('announcement')->with('gagal', 'Announcement Gagal Di Ubah');
    }

    public function delete(Request $request)
    {
      if ($announcement = $this->announcements->where('id',$request->hapus_id)->first()) {
        // dd($announcement);
        if ($announcement->delete()) {
          return redirect()->route('announcement')->with('info','Announcement Berhasil Di Hapus');
        }
      }
      return redirect()->route('announcement')->with('gagal','Announcement Gagal Di Hapus');
    }

    public function getImage($id) {
      $path = Storage::get('public/announcement/images/'.$id);
      $mimetype = Storage::mimeType('public/announcement/images/'.$id);
      return response($path, 200)->header('Content-Type', $mimetype);
    }
}
