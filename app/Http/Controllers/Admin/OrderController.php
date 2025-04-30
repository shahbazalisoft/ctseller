<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index($status, Request $request)
    {
        return view('admin-views.order.list');
    }
}
