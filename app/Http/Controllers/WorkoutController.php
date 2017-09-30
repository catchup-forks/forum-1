<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()->latitude == null) {
            return redirect('/my-position');
        }

        $nearbys = DB::select('SELECT * FROM(SELECT id, `starting` as stdate, distance, tempo, latitude, longitude,
                  111.045 * DEGREES(ACOS(COS(RADIANS(latpoint))
                      * COS(RADIANS(latitude))
                      * COS(RADIANS(longpoint) - RADIANS(longitude))
                      + SIN(RADIANS(latpoint))
                      * SIN(RADIANS(latitude)))) AS distance_in_km
             FROM workouts
             JOIN (
                 SELECT ' . auth()->user()->latitude . ' AS latpoint,  ' . auth()->user()->longitude . ' AS longpoint
               ) AS p
             ORDER BY distance_in_km ASC) AS x
             WHERE distance_in_km < 25 AND DATE(stdate) >= DATE(NOW())
             ORDER BY distance_in_km ASC
             LIMIT 15');

        $workouts = [];
        foreach ($nearbys as $n) {
            //$n->starts_at = date('H:i', strtotime($n->stdate));
            $workout = Workout::with('attendees')->find($n->id);
            $workout->starts_at = date('d/m H:i', strtotime($workout->starting));
            $workout->distance_in_km = $n->distance_in_km;
            $workouts[] = $workout;
        }

        if (\request()->wantsJson()) return $workouts;

        $latestThreads = \App\Thread::orderBy('updated_at', 'desc')->take(15)->get();

        return view('workouts.index', ['workouts' => $workouts, 'latestThreads' => $latestThreads]);
    }

    public function create()
    {
        return view('workouts.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'tempo' => 'unrealistic_tempo',
            'distance' => 'required|integer',
            'latitude' => 'required',
            'longitude' => 'required',
            'starting' => 'required|not_attending_workout:' . auth()->id(),
        ]);

        $workout = Workout::create([
            'user_id' => auth()->id(),
            'tempo' => \request('tempo'),
            'distance' => \request('distance'),
            'latitude' => \request('latitude'),
            'longitude' => \request('longitude'),
            'starting' => \request('starting'),
            'description' => \request('description'),
        ]);

        return $workout;
    }

    public function show(Workout $workout)
    {
        return view('workouts.show', ['workout' => $workout]);
    }
}
