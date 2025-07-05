<?php

namespace App\Http\Controllers;

use App\Models\WorkerProfile;
use Illuminate\Http\Request;

class UserControlController extends Controller
{
    public function index()
    {
        $workers = WorkerProfile::with('user')->get();

        return view('admin.Control.usercontrol', compact('workers'));
    }

    public function updateLabel($id)
    {
        $worker = WorkerProfile::findOrFail($id);
        $worker->empowr_label = $worker->empowr_label ? null : 1; // toggle
        $worker->save();

        return back()->with('success', 'Status Empowr Label berhasil diperbarui.');
    }

    public function updateAffiliate($id)
    {
        $worker = WorkerProfile::findOrFail($id);
        $worker->empowr_affiliate = $worker->empowr_affiliate ? null : 1; // toggle
        $worker->save();

        return back()->with('success', 'Status Empowr Affiliate berhasil diperbarui.');
    }

    public function deleteLabel($id)
    {
        $worker = WorkerProfile::findOrFail($id);
        $worker->empowr_label = 0;
        $worker->save();

        return back()->with('success', 'Empowr Label berhasil dihapus.');
    }

    public function deleteAffiliate($id)
    {
        $worker = WorkerProfile::findOrFail($id);
        $worker->empowr_affiliate = 0;
        $worker->save();

        return back()->with('success', 'Empowr Affiliate berhasil dihapus.');
    }
}
