<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    // contrôleur appelé depuis web.php
    public function index()
    {
        return view('welcome');
    }
    public function test()
    {
        return view('testview');
    }
}
