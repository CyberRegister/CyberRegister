<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

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
     * @return View
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the logout page for non-js peopel.
     *
     * @return View
     */
    public function logout()
    {
        return view('auth.logout');
    }
}
