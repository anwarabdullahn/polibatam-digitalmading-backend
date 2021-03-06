<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AuthMahasiswa;
use App\Announcement;
use App\AnnouncementCategories;
use App\User;
use App\Mahasiswa;

use App\Transformers\AnnouncementTransformer;
use App\Http\Requests\Store\StoreAddAnnouncement;
use App\Http\Requests\Update\UpdateAnnouncementPost;
use Illuminate\Support\Facades\Response;
use App\Notifications\PushNotification;

use Auth;
use Storage;
use Image;
use File;
use Notification;

use App\Firebase\Push;
use App\Firebase\Firebase;

class AnnouncementController extends Controller
{
  public function __construct()
  {
    $this->announcements = Announcement::all();
    $this->categories = AnnouncementCategories::all();
    $this->firebase = new Firebase();
    $this->push = new Push();
  }

  public function index()
  {
    if (Auth::user()->role =='admin' || Auth::user()->role =='super') {
      return view ('layouts.admins.announcements.announcement')->with('announcements' , $this->announcements)->with('categories' , $this->categories);
    }return redirect()->route('home')->with('gagal','Invalid Credential !!');
  }

  public function create(StoreAddAnnouncement $request, Announcement $announcement)
  {
    if (Auth::user()->role =='admin' || Auth::user()->role =='super'){
      $adminID = Auth::user()->id;
      $announcement->title = $request->title;
      $announcement->description = $request->description;
      $announcement->id_user = $adminID;
      $announcement->id_category = $request->id_category;
      if (isset($request->image)) {
        $byscryptAttachmentImage =  md5(str_random(64));
        $announcement->image = $byscryptAttachmentImage;

        $save = Image::make($request->file('image'))->fit(400, 400, function ($constraint) {
          $constraint->upsize();
        })->save(storage_path('app/public/announcement/images/'.$byscryptAttachmentImage));
      }
      if (isset($request->file)) {
        $byscryptAttachmentFile =  md5(str_random(64)) . '.' . $request->editfile->getClientOriginalExtension();
        // $byscryptAttachmentFile =  md5(str_random(24));
        $announcement->file = $byscryptAttachmentFile;
      }

        if ($announcement->save()) {
          if (isset($request->file)) {
            $request->file('file')->storeAs('public/files', $byscryptAttachmentFile);
            // $request->file('file')->storeAs('public/files' , $byscryptAttachmentFile );
          }return redirect()->route('announcement')->with('info','Announcement Berhasil Di Tambahkan');
        }return redirect()->route('announcement')->with('gagal','Announcement Gagal Di Tambahkan');

    }return redirect()->route('home')->with('gagal','Invalid Credential !!');
  }

  public function update(UpdateAnnouncementPost $request)
  {
    $id = $request->editimagefordelete;
    // $request->edit_penerbit;
    // dd(Auth::user()->name);
    if ((Auth::user()->name == $request->editpenerbit) ||  Auth::user()->role =='super') {
      $announcement = $this->announcements->where('id', $request->edit_id)->first();
      $file = $announcement->file;
      if ($announcement) {
        $forDelete = $announcement->image;
        $announcement->title = $request->edittitle;
        if (isset($request->editdescription)) {
          $announcement->description = $request->editdescription;
        }
        $announcement->id_category = $request->id_categoryedit;
        if ($request->editimage) {
          $byscryptAttachmentImage =  md5(str_random(64));
          $save = Image::make($request->file('editimage'))->fit(400, 400, function ($constraint) {
            $constraint->upsize();
          })->save(storage_path('app/public/announcement/images/'.$byscryptAttachmentImage));
          if ($save) {
            $announcement->image = $byscryptAttachmentImage;
            $delete = storage_path('app/public/announcement/images/'.$forDelete);
            if (File::exists($delete)) {
              File::delete($delete);
            }
          }
        }
        if (isset($request->editfile)) {
          $byscryptAttachmentFile =  md5(str_random(64)) . '.' . $request->editfile->getClientOriginalExtension();
          // $byscryptAttachmentFile =  md5(str_random(64));
          $announcement->file = $byscryptAttachmentFile;
        }
        if ($announcement->save()) {
          if (isset($request->editfile)) {
            // $request->file('editfile')->storeAs('public/files', $byscryptAttachmentFile);
            if ($request->file('editfile')->storeAs('public/files', $byscryptAttachmentFile)) {
              Storage::delete('public/files/'.$file);
            }else {
              return redirect()->route('announcement')->with('info', 'Announcement Berhasil Di Ubah');
            }
          }
          return redirect()->route('announcement')->with('info', 'Announcement Berhasil Di Ubah');
        }return redirect()->route('announcement')->with('gagal', 'Announcement Gagal Di Ubah');
      }return redirect()->route('announcement')->with('gagal','Announcement Tidak Ditemukan');
    }return redirect()->route('home')->with('gagal','Invalid Credential !!');
  }

  public function delete(Request $request)
  {
    $id = $request->hapusimage;
    if ((Auth::user()->name == $request->hapuspenerbit) || Auth::user()->role =='super') {
      $announcement = $this->announcements->where('id',$request->hapus_id)->first();
      if ($announcement->file) {
        $file = $announcement->file;
        $delete = storage_path('app/public/files/'.$file);
        // dd($delete);
        if (File::exists($delete)) {
          File::delete($delete);
        }
      }
      // dd($file);
      if ($announcement) {
        if ($announcement->delete()) {
          if (Storage::delete('public/announcement/images/'.$id)) {
            return redirect()->route('announcement')->with('info','Announcement Berhasil Di Hapus');
          }return redirect()->route('announcement')->with('info','Announcement Berhasil Di Hapus');
        }return redirect()->route('announcement')->with('gagal','Announcement Gagal Di Hapus');
      }return redirect()->route('announcement')->with('gagal','Announcement Tidak Ditemukan');
    }return redirect()->route('home')->with('gagal','Invalid Credential !!');
  }

  public function status(Request $request)
  {
    if (Auth::user()->role =='super') {
      $announcement = $this->announcements->where('id',$request->status_id)->first();
      if ($announcement) {
        $announcement->status = $request->editstatus;
        if ($announcement->save()) {

          // Firebase Push
          // $payload = array();
          // $payload['Announcement'] = $announcement->title;
          // $title = $announcement->title;
          // $message = $announcement->category->name.' - '.$announcement->user->name;
          // $push_type = 'topic';

          // $this->push->setTitle($title);
          // $this->push->setMessage($message);
          // $this->push->setImage('');
          // $this->push->setIsBackground(FALSE);
          // $this->push->setPayload($payload);

          // $json = '';
          // $response = '';

          // $json = $this->push->getPush();
          // $response = $this->firebase->sendToTopic('global', $json);
          // End Firebase

          // start email

            $data = array(
              'title'               => $announcement->title,
              'author'              => $announcement->user->name,
              'image'               => url('/announcement/images/'.$announcement->image),
              'description'         => $announcement->description,
              'category'            => $announcement->category->name,
            );


          $mahasiswa = Mahasiswa::all();

          Notification::send($mahasiswa, new PushNotification($data));

          // end email

          return redirect()->route('announcement')->with('info','Announcement Berhasil Di Ubah');
        }return redirect()->route('announcement')->with('gagal','Announcement Gagal Di Ubah');
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
      $announcements = Announcement::where('status', '1')->take(15)->get()->sortByDesc('created_at');
      $response = fractal()
      ->collection($announcements)
      ->transformWith(new AnnouncementTransformer)
      ->toArray();

      return response()->json(array('result' => $response['data']), 200);
    }
    $messageResponse['message'] = 'Invalid Credentials';
    return response($messageResponse, 401);
  }

  public function byCategoryAPI(Request $request,$id)
  {
    $authorization = $request->header('Authorization');
    $authMahasiswa = AuthMahasiswa::where('api_token' ,$authorization)->first();
    if ($authMahasiswa) {
      $announcements = Announcement::where('id_category', $id)->where('status', '1')->take(15)->get()->sortByDesc('created_at');
      if ($announcements) {
        $response = fractal()
        ->collection($announcements)
        ->transformWith(new AnnouncementTransformer)
        ->toArray();

        return response()->json(array('result' => $response['data']), 200);
      }
      $messageResponse['message'] = 'Kategori Tidak Tersedia';
      return response($messageResponse, 406);
    }
    $messageResponse['message'] = 'Invalid Credentials';
    return response($messageResponse, 401);
  }
}
