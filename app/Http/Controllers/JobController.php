<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\Job;

class JobController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request): View
    {
        $jobs = Job::query();

        $productTitle = $request->input('productTitle');
        $companyTitle = $request->input('companyTitle');
        $minSalary = $request->input('minSalary');
        $maxSalary = $request->input('maxSalary');

        if ($request->has('productTitle') && $request->input('productTitle') !== '') {
            $jobs->where('title', 'like', '%' . $request->input('productTitle') . '%');
        }
        if ($request->has('companyTitle') && $request->input('companyTitle') !== '') {
            $jobs->where('company_name', 'like', '%' . $request->input('companyTitle') . '%');
        }
        if ($request->has('minSalary') && is_numeric($request->input('minSalary'))) {
            $jobs->where('salary', '>=', (int)$request->input('minSalary'));
        }
        if ($request->has('maxSalary') && is_numeric($request->input('maxSalary'))) {
            $jobs->where('salary', '<=', (int)$request->input('maxSalary'));
        }

        $jobs = $jobs->paginate(9);

        return view('jobs.index', compact('jobs', 'productTitle', 'companyTitle', 'minSalary', 'maxSalary'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): RedirectResponse|View
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:32',
            'description' => 'required|string|max:512',
            'salary' => 'required|integer|min:40000|max:90000',
            'job_type' => 'required|string',
            'remote' => 'required|boolean',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zipcode' => 'nullable|string',
            'contact_email' => 'required|string',
            'contact_phone' => 'nullable|string',
            'company_name' => 'required|string',
            'company_description' => 'nullable|string',
            'company_logo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:16384',
            'company_website' => 'nullable|url'
        ]);

        $validatedData['user_id'] = auth()->user()->id;

        // Validate for image
        if ($request->hasFile('company_logo')) {
            // Store the file and get path
            $path = $request->file('company_logo')->store('logos', 'public');

            $validatedData['company_logo'] = $path;
        }

        Job::create($validatedData);

        return redirect()->route('jobs.index')->with('success', 'Job listing created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job): View
    {
        return view('jobs.show')->with('job', $job);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job): View
    {
        // Check if user authorized
        $this->authorize('update', $job);

        return view('jobs.edit')->with('job', $job);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job): RedirectResponse
    {
        // Check if user authorized
        $this->authorize('update', $job);

        $validatedData = $request->validate([
            'title' => 'required|string|max:32',
            'description' => 'required|string|max:512',
            'salary' => 'required|integer|min:40000|max:90000',
            'job_type' => 'required|string',
            'remote' => 'required|boolean',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zipcode' => 'nullable|string',
            'contact_email' => 'required|string',
            'contact_phone' => 'nullable|string',
            'company_name' => 'required|string',
            'company_description' => 'nullable|string',
            'company_logo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:16384',
            'company_website' => 'nullable|url'
        ]);

        // Validate for image
        if ($request->hasFile('company_logo')) {
            // Delete old image
            Storage::delete('public/logos/' . basename($job->company_logo));

            // Store the file and get path
            $path = $request->file('company_logo')->store('logos', 'public');

            $validatedData['company_logo'] = $path;
        }
        $job->update($validatedData);

        return redirect()->route('jobs.index')->with('success', 'Job listing updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job): RedirectResponse
    {
        // Check if user authorized
        $this->authorize('delete', $job);

        if ($job->company_logo) {
            Storage::delete('public/logos/' . $job->company_logo);
        }
        $job->delete();

        // Check if request from dashboard
        if (request()->query('from') == 'dashboard') {
            return redirect()->route('dashboard')->with('success', 'Job listing deleted successfully!');
        }
        if (request()->query('from') == 'adminPanel') {
            return redirect()->back()->with('success', 'Job listing deleted successfully!');
        }

        return redirect()->route('jobs.index')->with('success', 'Job listing deleted successfully!');
    }
}


