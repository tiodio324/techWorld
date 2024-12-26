<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Job;

class ShoppingCartController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $shoppingCarts = $user->shoppingCartJobs()->orderBy('shopping_cart.created_at', 'desc')->paginate(3);

        return view('jobs.shoppingCart')->with('shoppingCarts', $shoppingCarts);
    }

    public function store(Job $job): RedirectResponse
    {
        $user = Auth::user();

        if ($user->shoppingCartJobs()->where('job_id', $job->id)->exists()) {
            return back()->with('error', 'Product is already in shopping cart');
        }

        $user->shoppingCartJobs()->attach($job->id);

        return back()->with('success', 'See your product on shopping list');
    }

    public function destroy(Job $job): RedirectResponse
    {
        $user = Auth::user();

        if (!$user->shoppingCartJobs()->where('job_id', $job->id)->exists()) {
            return back()->with('error', 'Product is not in shopping cart');
        }

        $user->shoppingCartJobs()->detach($job->id);

        return back();
    }
}
