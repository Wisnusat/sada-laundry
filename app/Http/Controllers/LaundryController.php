<?php

namespace App\Http\Controllers;

class LaundryController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function faq()
    {
        return view('faq');
    }

    public function contact()
    {
        return view('contact');
    }
}
