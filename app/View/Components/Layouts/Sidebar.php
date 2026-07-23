<?php

namespace App\View\Components\Layouts;

use App\Models\Project;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $projects = Project::select('id', 'label')
            ->whereHas('memberships', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->orderBy('label')
            ->get();

        return view('components.layouts.sidebar', ['projects' => $projects]);
    }
}
