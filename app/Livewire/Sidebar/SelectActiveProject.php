<?php

namespace App\Livewire\Sidebar;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SelectActiveProject extends Component
{
    public $projects;
    public $selectedProjectId;

    public function mount()
    {
        $user = Auth::user();
        $this->projects = $user ? $user->projects()->orderBy('name')->get() : collect();
        $this->selectedProjectId = $user->current_project_id ?? session('current_project_id') ?? $this->projects->first()?->id;
    }

    public function switchProject($projectId)
    {
        $user = Auth::user();
        if (! $user) {
            return;
        }

        $project = $user->projects()->find($projectId);
        if (! $project) {
            $this->mount();
            return;
        }

        // Persist to user and session (adjust if you prefer session-only)
        $user->current_project_id = $project->id;
        $user->save();

        session(['current_project_id' => $project->id]);

        // Make it immediately available for the request
        $user->setRelation('currentProject', $project);

        // redirect so the rest of the app picks up the new project context
        $this->js('window.location.reload()');
    }


    public function render()
    {
        return view('livewire.sidebar.select-active-project');
    }
}
