<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function store()
    {
        $attributes = $this->validateRequest();
        $attributes['owner_id'] = \auth()->id();
        $project = \auth()->user()->projects()->create($attributes);
        if (request()->has('tasks')) {
            foreach (request('tasks') as $task) {
                $project->addTask($task['body']);
            }
        }
        if (request()->wantsJson()) {
            return ['message' => $project->path()];
        }

        return redirect($project->path());
    }

    public function index()
    {
        $projects = auth()->user()->accessibleProject();
        //return Inertia::render('projects.index', compact('projects'));
        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        $this->authorize('update', $project);
        $project = Project::find($project->id);

        return view('projects.show', compact('project'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        //$request->persist();

        // $request->validated(); to get the validated attributes
        $this->authorize('update', $project);
        $project->update($request->validated());

        return redirect($project->path());
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * @return array
     */
    protected function validateRequest(): array
    {
        return \request()->validate([
            'title' => 'sometimes|required',
            'body' => 'sometimes|required',
            'notes' => 'nullable'
        ]);
    }

    public function destroy(Project $project)
    {
        $this->authorize('manage', $project);

        $project->delete();
        return redirect('/projects');
    }
}
