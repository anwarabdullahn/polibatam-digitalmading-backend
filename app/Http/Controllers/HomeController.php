<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Charts;
use App\Mahasiswa;
use App\Banner;
use App\Announcement;
use App\Event;

use Storage;

class HomeController extends Controller
{
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
  * Show the application dashboard.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $event = Event::where('status', '1')->count();
    $announcement = Announcement::where('status', '1')->count();
    $banner = Banner::where('status', '1')->count();
    $mahasiswa = Mahasiswa::where('verified', 'true')->count();

    $lastAnnouncement = Announcement::take(5)->get()->sortByDesc('created_at');
    // dd($lastAnnouncement);
    $lastEvent = Event::take(5)->get()->sortByDesc('created_at');

    $chart = Charts::database(Event::all(), 'bar', 'highcharts')
    ->title("Jumlah Event Perbulan")
    ->elementLabel("Total")
    ->dimensions(1000, 100)
    ->responsive(true)
    ->dateColumn('date')
    ->groupByMonth('2018',true);

    if (Auth::user()->role =='ormawa') {
      return view ('ormawaapp', ['chart' => $chart], compact('mahasiswa','banner','event','announcement','lastAnnouncement','lastEvent'));
    }elseif (Auth::user()->role =='admin') {
      return view ('adminapp' , ['chart' => $chart], compact('mahasiswa','banner','event','announcement','lastAnnouncement','lastEvent'));
    }elseif (Auth::user()->role =='super') {
      return view ('adminapp' , ['chart' => $chart], compact('mahasiswa','banner','event','announcement','lastAnnouncement','lastEvent'));
    }
  }

}
