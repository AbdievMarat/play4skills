<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return RedirectResponse
     */
    public function index(): RedirectResponse
    {
        if (Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.assigned_tasks.index');
        } else {
            return redirect()->route('stream');
        }
    }
}
