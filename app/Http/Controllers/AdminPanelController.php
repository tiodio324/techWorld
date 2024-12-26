<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;
use App\Models\User;

class AdminPanelController extends Controller
{
    public function index(): View
    {
        $usr = Auth::user();
        $users = User::all();
        $jobs = Job::where('user_id', $usr->id);

        // Set default status for jobs without a status
        foreach ($users as $user) {
            foreach ($user->shoppingCartJobs as $job)
            if (is_null($job->status)) {
                $job->status = 'In Cart';
                $job->save();
            }
        }

        return view('adminPanel.index', compact('users', 'jobs'));
    }

    public function updateStatus(Request $request, Job $job): RedirectResponse
    {
        $job->status = $request->input('productStatus');
        $job->save();

        return redirect()->back()->with('success', 'Status updated successfully');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->avatar) {
            Storage::delete('public/avatars/' . $user->avatar);
        }
        $user->delete();

        return redirect()->route('adminPanel')->with('success', 'User deleted successfully!');
    }
}
