<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Http\Requests\Store\StoreAddEvent;
use App\Http\Requests\Update\UpdateEventPost;
use Auth;
use Storage;

class EventController extends Controller
{
    protected $events;

    public function __construct()
    {
        // $this->middleware('auth');
        $this->events = Event::all();
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
      if (isset($request->image)) {
        $byscryptAttachmentFile =  md5(str_random(64));
        $event->image = $byscryptAttachmentFile;
        // dd($byscryptAttachmentFile);
        }
      if ($event->save()) {
        if (isset($request->image)) {
          $request->image->storeAs('public/event/images' , $byscryptAttachmentFile );
          return redirect()->route('event')->with('info','Event Berhasil Di Tambahkan');
        }return redirect()->route('event')->with('gagal','Event Gagal Di Tambahkan');
      }return redirect()->route('event')->with('gagal','Event Gagal Di Tambahkan');
    }

    public function update(UpdateEventPost $request)
    {
      if (Auth::user()->name == $request->edituser || Auth::user()->role =='admin'){
        $event = $this->events->where('id', $request->edit_id)->first();
        if ($event) {
          $event->title = $request->edittitle;
          $event->description = $request->editdescription;
          $event->id_user = $request->editpenerbit;
          if (isset($request->editimage)) {
            $byscryptAttachmentFile =  md5(str_random(64));
            $event->image = $byscryptAttachmentFile;
          }
          if ($event->save()) {
            if (isset($request->editimage)) {
              $request->editimage->storeAs('public/event/images' , $byscryptAttachmentFile );
              return redirect()->route('event')->with('info', 'Event Berhasil Di Ubah');
            }return redirect()->route('event')->with('info', 'Event Berhasil Di Ubah');
          }return redirect()->route('event')->with('gagal', 'Event Gagal Di Ubah');
        }return redirect()->route('event')->with('gagal', 'Event Gagal Di Ubah');
      }return redirect()->route('event')->with('gagal','Invalid Credential !!');
    }

    public function delete(Request $request)
    {
      $id = $request->hapusimage;
      if (Auth::user()->name == $request->hapususer || Auth::user()->role =='admin') {
        $event = $this->events->where('id' , $request->hapus_id)->first();
        if ($event) {
          if ($event->delete()) {
            if (Storage::delete('public/event/images/'.$id)) {
              return redirect()->route('event')->with('info', 'Event Berhasil Di Hapus');
            }return redirect()->route('event')->with('gagal', 'Event Gagal Di Hapus');
          }return redirect()->route('event')->with('gagal', 'Event Gagal Di Hapus');
        }return redirect()->route('event')->with('gagal', 'Event Tidak Ditemukan');
      }return redirect()->route('event')->with('gagal', 'Invalid Credential !!');
    }

    public function getImage($id)
    {
      $path = Storage::get('public/event/images/'.$id);
      $mimetype = Storage::mimeType('public/event/images/'.$id);
      return response($path, 200)->header('Content-Type', $mimetype);
    }


}
