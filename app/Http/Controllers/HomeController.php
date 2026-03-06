<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Post;
use App\Models\Testimonial;
use App\Models\User;

class HomeController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $categories = CourseCategory::query()
            ->withCount('courses')
            ->where('is_active', true)
            ->limit(6)
            ->get();

        $featuredCourses = Course::query()
            ->with('category')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->limit(6)
            ->get();

        $testimonials = Testimonial::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->limit(3)
            ->get();

        $posts = Post::query()
            ->with('category')
            ->where('is_published', true)
            ->latest('published_at')
            ->limit(3)
            ->get();

        $stats = [
            'students' => User::query()->role('aluno')->count(),
            'courses' => Course::query()->where('is_active', true)->count(),
            'instructors' => User::query()->role('professor')->count(),
            'certificates' => \App\Models\Certificate::query()->count(),
        ];

        return view('pages.home', compact('categories', 'featuredCourses', 'testimonials', 'posts', 'stats'));
    }
}
