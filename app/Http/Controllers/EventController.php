<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Http\Requests\Store\StoreAddEvent;
use App\Http\Requests\Update\UpdateEventPost;
use App\AuthMahasiswa;
use Auth;
use Storage;
use App\Transformers\EventTransformer;

use App\Firebase\Push;
use App\Firebase\Firebase;

use Image;
use File;

class EventController extends Controller
{
  protected $events;

  public function __construct()
  {
    // $this->middleware('auth');
    $this->events = Event::all();
    $this->firebase = new Firebase();
    $this->push = new Push();
  }

  public function index()
  {
    return view ('layouts.admins.events.event')->with('events' , $this->events);
  }

  public function create(StoreAddEvent $request, Event $event)
  {
    $adminID = Auth::user()->id;
    $event->title = $request->title;
    $event->description = $request->description;
    $event->id_user = $adminID;
    $event->date = $request->date;
    if (isset($request->image)) {
      $byscryptAttachmentFile =  md5(str_random(64));
      $event->image = $byscryptAttachmentFile;
      // dd($byscryptAttachmentFile);
    }
    $save = Image::make($request->file('image'))->fit(400, 400, function ($constraint) {
      $constraint->upsize();})->save(storage_path('app/public/event/images/'.$byscryptAttachmentFile));
      if ($save) {
        if ($event->save()) {
          return redirect()->route('event')->with('info','Event Berhasil Di Tambahkan');
        }
      }
    return redirect()->route('event')->with('gagal','Event Gagal Di Tambahkan');
  }

  public function update(UpdateEventPost $request)
  {
    if (Auth::user()->name == $request->edituser || Auth::user()->role =='admin'|| Auth::user()->role =='super'){
      $event = $this->events->where('id', $request->edit_id)->first();
      if ($event) {
        $forDelete = $event->image;
        if ($request->edittitle) {
          $event->title = $request->edittitle;
        }
        if ($request->editdescription) {
          $event->description = $request->editdescription;
        }
        $event->date= $request->editdate;
        $event->id_user = $request->editpenerbit;
        if (isset($request->editimage)) {
          $byscryptAttachmentFile =  md5(str_random(64));
          $event->image = $byscryptAttachmentFile;
        }
        $save = Image::make($request->file('editimage'))->fit(400, 400, function ($constraint) {
          $constraint->upsize();})->save(storage_path('app/public/event/images/'.$byscryptAttachmentFile));
          if ($save) {
            if ($event->save()) {
              $delete = storage_path('app/public/event/images/'.$forDelete);
              if (File::exists($delete)) {
                File::delete($delete);
              }return redirect()->route('event')->with('info', 'Event Berhasil Di Ubah');
            }return redirect()->route('event')->with('info', 'Event Berhasil Di Ubah');
          }
        return redirect()->route('event')->with('gagal', 'Event Gagal Di Ubah');
      }return redirect()->route('event')->with('gagal', 'Event Gagal Di Ubah');
    }return redirect()->route('event')->with('gagal','Invalid Credential !!');
  }

  public function delete(Request $request)
  {
    $forDelete = $request->hapusimage;
    if (Auth::user()->name == $request->hapususer || Auth::user()->role =='admin'|| Auth::user()->role =='super') {
      $event = $this->events->where('id' , $request->hapus_id)->first();
      if ($event) {
        if ($event->delete()) {
          $delete = storage_path('app/public/event/images/'.$forDelete);
          if (File::exists($delete)) {
            File::delete($delete);
          }
          return redirect()->route('event')->with('info', 'Event Berhasil Di Hapus');
        }return redirect()->route('event')->with('gagal', 'Event Gagal Di Hapus');
      }return redirect()->route('event')->with('gagal', 'Event Tidak Ditemukan');
    }return redirect()->route('event')->with('gagal', 'Invalid Credential !!');
  }

  public function status(Request $request)
  {
    if (Auth::user()->role =='super') {
      $event = $this->events->where('id',$request->status_id)->first();
      if ($event) {
        $event->status = $request->editstatus;
        if ($event->save()) {

          // Firebase Push
          $payload = array();
          $payload['Event'] = $event->title;
          $title = $event->title;
          $message = $event->date.' - '.$event->user->name;
          $push_type = 'topic';

          $this->push->setTitle($title);
          $this->push->setMessage($message);
          $this->push->setImage('');
          $this->push->setIsBackground(FALSE);
          $this->push->setPayload($payload);

          $json = '';
          $response = '';

          $json = $this->push->getPush();
          $response = $this->firebase->sendToTopic('global', $json);
          // End Firebase

          return redirect()->route('event')->with('info','Event Berhasil Di Ubah');
        }return redirect()->route('event')->with('gagal','Event Gagal Di Ubah');
      }return redirect()->route('event')->with('gagal','Event Tidak Ditemukan');
    }return redirect()->route('home')->with('gagal','Invalid Credential !!');
  }

  public function getImage($id)
  {
    $path = Storage::get('public/event/images/'.$id);
    $mimetype = Storage::mimeType('public/event/images/'.$id);
    return response($path, 200)->header('Content-Type', $mimetype);
  }

  public function getAPI(Request $request)
  {
    $authorization = $request->header('Authorization');
    if ($authorization) {
      $authMahasiswa = AuthMahasiswa::where('api_token' , $authorization)->first();

      if ($authMahasiswa) {
        if ($request->date) {
          $event = Event::where('date' ,$request->date)->get()->sortByDesc('created_at');
          // dd($event);
          if ($event) {
            $response = fractal()
            ->collection($event)
            ->transformWith(new EventTransformer)
            ->toArray();
            return response()->json(array('result' => $response['data']), 201);
          }$messageResponse['message'] = 'Event Tidak ditemukan';
          return response($messageResponse, 406);
        }
        $event = Event::get()->sortByDesc('created_at');
        // dd($announcements);
        $response = fractal()
        ->collection($event)
        ->transformWith(new EventTransformer)
        ->toArray();
        return response()->json(array('result' => $response['data']), 201);
      }$messageResponse['message'] = 'Invalid Credentials';
      return response($messageResponse, 401);
    }$messageResponse['message'] = 'Authorization Not Set';
    return response($messageResponse, 401);
  }


}
