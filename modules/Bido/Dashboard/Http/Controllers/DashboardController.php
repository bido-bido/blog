<?php

namespace Bido\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function home()
    {
        return view('Dashboard::index');
    }
}
