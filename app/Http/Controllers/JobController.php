<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index()
{
    $jobs = Job::all();
    return view('jobs', compact('jobs'));
}


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer',
            'end_date' => 'required|date',
        ]);

        Job::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'end_date' => $request->end_date,
            'user_id' => Auth::id(),
        ]);

        return redirect('/client/new')->with('success', 'Job created successfully.');
    }
    
    public function getJobData()
    {
        $jobs = Job::selectRaw('count(*) as count, category')
                ->groupBy('category')
                ->get();

        return response()->json($jobs);
    }
}
