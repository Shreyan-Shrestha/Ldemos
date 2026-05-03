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
        $activity = Activity::all();
        $orders = Order::all();
        return view('welcome', compact('activity', 'orders'));
    }

    public function demo1()
    {
        $this->demoLogger->log("User accessed Demo1 page");
        return view('demo1');
    }

    public function addDataform()
    {
        $this->demoLogger->log("User accessed Add Data form");
        return view('adddata');
        
    }

    public function addData(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $demodata = LDemo::create($validated);
        $this->demoLogger->log("User added data: " . $demodata->name);
        $this->demoLogger->log("Event triggered by " . $demodata->name);
        event(new LoggedEvent($demodata));
        return redirect('/')->with('success', 'Data added successfully!');
    }

    public function deletedHistory()
    {
        $deletedhistory = demobackup::all();
        return view('deletedhistory', compact('deletedhistory'));
    }
}
