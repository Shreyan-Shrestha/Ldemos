<?php

namespace App\Http\Controllers;

use App\Services\DemoLogger;
use Illuminate\Http\Request;
use App\Events\LoggedEvent;
use App\Models\LDemo;
use App\Models\demobackup;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class LDemoController extends Controller
{
    public function __construct(public DemoLogger $demoLogger)
    {

    }

    public function index()
    {
        //$this->demoLogger->log("User accessed Index page | " . request()->header('User-Agent') . " | Referer: " . request()->header('Referer'));
        $activity = Activity::inLog('default')->latest()->cursorPaginate(5);
        $logindex = Activity::inLog('index')->get();
        $orders = Order::all()->keyBy('customer_id');
        return view('welcome', compact('activity', 'orders', 'logindex'));
    }

    public function demo1()
    {
       activity('index')->log('User accessed Demo1 page');
        return view('demo1');
    }

    public function addDataform()
    {
        activity('index')->log('User accessed Add Data form');
        return view('adddata');
        
    }

    public function addData(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $demodata = LDemo::create($validated);
        activity('index')->log('User added data: ' . $demodata->name);
        event(new LoggedEvent($demodata));
        return redirect('/')->with('success', 'Data added successfully!');
    }

    public function deletedHistory()
    {
        $deletedhistory = demobackup::all();
        return view('deletedhistory', compact('deletedhistory'));
    }
}
