<?php

namespace App\Http\Controllers\Dashboard; // Tambahkan \Dashboard

use App\Http\Controllers\Controller; // Tambahkan ini agar bisa extend Controller
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }
}