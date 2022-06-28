<?php

    namespace App\Http\Controllers;

    use App\Models\Project;
    use Illuminate\Http\Request;

    class ProjectsController extends Controller
    {

        public function index()
        {
            return view('projects.index', [
                'projects' => auth()->user()->projects
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

        public function store()
        {
            //validate
            auth()->user()->projects()->create(request()->validate([
                'title' => 'required',
                'description' => 'required',
            ]));

            //redirect
            return redirect('/projects');
        }

    }
