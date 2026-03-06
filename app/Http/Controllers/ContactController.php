<?php

namespace App\Http\Controllers;

class ContactController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        return view('pages.contact');
    }
}
