<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\CourseCategory;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class CourseCatalog extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'categoria')]
    public string $category = '';

    #[Url(as: 'modalidade')]
    public string $modality = '';

    #[Url(as: 'nivel')]
    public string $level = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCategory(): void
    {
        $this->resetPage();
    }

    public function updatedModality(): void
    {
        $this->resetPage();
    }

    public function updatedLevel(): void
    {
        $this->resetPage();
    }

    public function render(): \Illuminate\View\View
    {
        $courses = Course::query()
            ->with('category')
            ->where('is_active', true)
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('description', 'like', "%{$this->search}%"))
            ->when($this->category, fn ($q) => $q->whereHas('category', fn ($c) => $c->where('slug', $this->category)))
            ->when($this->modality, fn ($q) => $q->where('modality', $this->modality))
            ->when($this->level, fn ($q) => $q->where('level', $this->level))
            ->latest()
            ->paginate(9);

        $categories = CourseCategory::query()
            ->where('is_active', true)
            ->withCount(['courses' => fn ($q) => $q->where('is_active', true)])
            ->get();

        return view('livewire.course-catalog', compact('courses', 'categories'));
    }
}
