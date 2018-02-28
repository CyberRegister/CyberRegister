<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return View
     */
    public function index(): View
    {
        return view('home');
    }

    /**
     * Show the logout page for non-js peopel.
     *
     * @return View
     */
    public function logout(): View
    {
        return view('auth.logout');
    }
}
