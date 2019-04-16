<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
     * @param \Aimeos\MShop\Context\Item\Iface $context
     * @return \Illuminate\Contracts\Support\Renderable
     * @throws \Aimeos\MShop\Exception
     */
    public function index()
    {
        return view('home');
    }
}
