<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Arbitrase;

class ArbitraseController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $workerProfile = $user->workerProfile;
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->role === 'admin') {
            $arbitrases = Arbitrase::all();
        } else{
            $arbitrases = Arbitrase::where('client_id', $user->id)
                ->orWhere('worker_id', $workerProfile->user_id)
                ->get();
        }

        return view('General.arbitrase', compact('arbitrases'));
    }
}