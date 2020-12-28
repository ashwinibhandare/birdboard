<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class ProjectTaskController extends Controller
{
    public function store(Project $project)
    {
        $this->authorize('update', $project);
        \request()->validate(['body' => 'required']);
        $project->addTask(\request('body'));

        return redirect($project->path());
    }

    public function show()
    {
        return view('');
    }

    public function update(Project $project, Task $tasks)
    {
        $this->authorize('update', $project);
        $tasks->update(\request()->validate(['body' => 'required']));
        $method = \request('completed') ? 'complete' : 'incompleted';
        $tasks->$method();
//        if (\request('completed')) {
//            $tasks->complete();
//        } else {
//            $tasks->incompleted();
//        }
//        $tasks->update([
//            'body' => \request('body'),
//            'completed' => \request()->has('completed')
//        ]);

        return redirect($project->path());
    }
}
