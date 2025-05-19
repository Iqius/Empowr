<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Mendapatkan task yang dilamar, menggunakan paginate
        $appliedTasks = Task::where('status', 'applied')->paginate(5);

        // Mendapatkan task yang diterima oleh user yang sedang login, menggunakan paginate
        $worker = Auth::user()->workerProfile;
        $accTasks = Task::where('profile_id', $worker->id)
            ->where('status', 'in progress')
            ->paginate(5);

        // Debugging - pastikan data sudah benar
        dd($appliedTasks, $accTasks);

        // Mengirim data ke view
        return view('your-view', compact('appliedTasks', 'accTasks'));
    }
}
