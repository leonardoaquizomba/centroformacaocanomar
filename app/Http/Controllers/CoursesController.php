<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    public function index(Request $request): \Illuminate\View\View
    {
        $categories = CourseCategory::query()
            ->where('is_active', true)
            ->withCount(['courses' => fn ($q) => $q->where('is_active', true)])
            ->get();

        return view('pages.courses.index', compact('categories'));
    }

    public function show(string $slug): \Illuminate\View\View
    {
        $course = Course::query()
            ->with(['category', 'classes' => fn ($q) => $q->where('is_active', true)->with('schedules')])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $related = Course::query()
            ->with('category')
            ->where('course_category_id', $course->course_category_id)
            ->where('id', '!=', $course->id)
            ->where('is_active', true)
            ->limit(3)
            ->get();

        return view('pages.courses.show', compact('course', 'related'));
    }
}
