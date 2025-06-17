<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class DashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:dashboard', only: ['index']),
        ];
    }
    public function index()
    {
        $data = [
            'title' => __('Dashboard')
        ];
        return view('cms.dashboard')->with($data);
    }
}
