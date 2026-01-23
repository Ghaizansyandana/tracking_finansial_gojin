<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengarahkan ke file resources/views/dashboard.blade.php
        return view('dashboard.index');
    }
}