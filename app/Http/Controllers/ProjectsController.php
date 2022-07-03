<?php

    namespace App\Http\Controllers;

    use App\Models\Project;
    use Illuminate\Http\Request;

    class ProjectsController extends Controller
    {

        public function index()
        {
            return view('projects.index', [
                'projects' => auth()->user()->projects->sortByDesc('updated_at')
            ]);
        }

        public function show(Project $project)
        {
            if(auth()->user()->isNot($project->owner)) {
                abort(403);
            }

            return view('projects.show', [
                'project' => $project
            ]);
        }

        public function create()
        {
            return view('projects.create');
        }
        
        public function store()
        {
            //validate
            $project = auth()->user()->projects()->create(request()->validate([
                'title' => 'required',
                'description' => 'required|max:100',
                'notes' => 'min:3'
            ]));

            //redirect
            return redirect($project->path());
        }

        public function update(Project $project)
        {
            $project->update([
                'notes' => request('notes')
            ]);

            return redirect($project->path());
        }

    }
