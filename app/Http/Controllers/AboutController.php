<?php

namespace App\Http\Controllers;

use App\Models\User;

class AboutController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $teachers = User::query()
            ->role('professor')
            ->with('teacherProfile')
            ->limit(6)
            ->get();

        return view('pages.about', compact('teachers'));
    }
}
