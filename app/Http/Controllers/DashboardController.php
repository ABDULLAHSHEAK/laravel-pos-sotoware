<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function HomePage()
    {
        return view('fontend.home');
    }
    function DashboardPage()
    {
        return view('dashboard.pages.home');
    }
}
