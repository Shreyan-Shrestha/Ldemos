<?php

namespace App\Http\Controllers;

use App\Services\DemoLogger;
use Illuminate\Http\Request;
use App\Events\LoggedEvent;
use App\Models\LDemo;
use App\Models\demobackup;
use App\Models\Order;
use Illuminate\Foundation\Exceptions\Renderer\Renderer;
use Illuminate\Support\Facades\Cache;
use RuntimeException;
use Spatie\Activitylog\Models\Activity;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;

class LDemoController extends Controller
{
    public function __construct(public DemoLogger $demoLogger) {}

    public function index()
    {
        $startTime = microtime(true);
        $source = "database";

        $page = request()->input('page', 1);
        $perPage = 5;
        
        if (Cache::has('activity.cache')) {
            $source = "cache";
        }

        $allActivity = Cache::remember('activity.cache', 60, function () {
        return Activity::inLog('default')->latest()->get()->map(function ($act) {
            return [
                'id'               => $act->id,
                'log_name'         => $act->log_name,
                'description'      => $act->description,
                'subject_type'     => $act->subject_type,
                'subject_id'       => $act->subject_id,
                'event'            => $act->event,
                'created_at'       => $act->created_at->toDateTimeString(),
            ];
        })->toArray();
    });

        $timeTaken = microtime(true) - $startTime;

        $logindex = Activity::inLog('index')->get();
        $logerror = Activity::inLog('error')->get();
        $orders = Order::all()->keyBy('customer_id');

        $allActivity = collect($allActivity);

        $activity = new \Illuminate\Pagination\LengthAwarePaginator(
            $allActivity->forPage($page, $perPage),
            $allActivity->count(),
            $perPage,
            $page,
            ['path' => request()->url()]
        );

        return view('welcome', compact('activity', 'orders', 'logindex', 'logerror', 'timeTaken', 'source'));
    }

    public function dashboard(){
        $data = Activity::all()->last();
        return view('dashboard', compact('data'));
    }
    public function demo1()
    {
       Bugsnag::notifyException(new RuntimeException("Test error"));
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
