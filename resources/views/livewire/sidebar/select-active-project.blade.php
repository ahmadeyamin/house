<div class="w-full">
    <select
        id="project-switch"
        wire:model="selectedProjectId"
        wire:change="switchProject($event.target.value)"
        class="block text-lg rounded-md border border-gray-300 bg-gray-50 px-2 py-1 text-gray-900 shadow-sm focus:ring-blue-500 focus:border-blue-500 w-full"
    >
    @foreach ($projects as $project)
        <option value="{{ $project->id }}">
            {{ $project->name }}
        </option>
    @endforeach
    </select>
</div>
