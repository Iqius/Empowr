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
        ]); //gonane pean

        // $request->validate([
        //     'title' => 'required',
        //     'description' => 'nullable',
        //     'price' => 'required|numeric',
        //     'end_date' => 'required|date',
        //     'type' => 'required',
        //     'provisions' => 'nullable',
        //     'revisions' => 'required|integer',
        //     'file' => 'nullable|file|max:2048', // 2MB max
        // ]);

        Job::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'end_date' => $request->end_date,
            'user_id' => Auth::id(),
        ]); //gonane pean

        // Job::create([
        //     'title' => $request->title,
        //     'description' => $request->description,
        //     'price' => $request->price,
        //     'end_date' => $request->end_date,
        //     'type' => $request->type,
        //     'provisions' => $request->provisions,
        //     'revisions' => $request->revisions,
        //     'user_id' => Auth::id(),
        // ]);
        return redirect('/worker/jobs')->with('success', 'Job created successfully.');
    }
    
    public function getJobData()
    {
        $jobs = Job::selectRaw('count(*) as count, category')
                ->groupBy('category')
                ->get();

        return response()->json($jobs);
    }
    public function show($id)
    {
        // Ambil job berdasarkan ID dari URL
        $job = Job::with('user')->findOrFail($id); // Ambil juga relasi user jika ada
    
        // Kirim ke view
        return view('show', compact('job'));
    }
    public function myJobs()
{
    $jobs = \App\Models\Job::where('user_id', Auth::id())->get();
    return view('myJobClient', compact('jobs'));
}
public function manage($id)
{
    // Bisa pakai data real jika sudah ada di DB
    $job = \App\Models\Job::with('user')->findOrFail($id);

    // Kirim ke view manage.blade.php
    return view('manage', compact('job'));
}

// public function updateStatus($id)
// {
//     $job = \App\Models\Job::findOrFail($id);

//     // Hanya user yang membuat job boleh ubah status
//     if ($job->user_id !== Auth::id()) {
//         abort(403, 'Unauthorized');
//     }

//     // Ubah status sesuai urutan
//     $statusOrder = ['belum' => 'sedang', 'sedang' => 'selesai', 'selesai' => 'selesai'];
//     $job->status = $statusOrder[$job->status] ?? 'belum';
//     $job->save();

//     return back()->with('success', 'Status berhasil diperbarui ke: ' . ucfirst($job->status));
// } 

}
// app/Http/Controllers/JobController.php

