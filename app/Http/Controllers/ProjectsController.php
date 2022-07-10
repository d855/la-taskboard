<?php

    namespace App\Http\Controllers;

    use App\Models\Project;
    use Illuminate\Http\Request;

    class ProjectsController extends Controller
    {

        public function index()
        {
            return view('projects.index', [
                'projects' => auth()->user()->accessibleProjects()
            ]);
        }

        /**
         * @throws \Illuminate\Auth\Access\AuthorizationException
         */
        public function show(Project $project)
        {
            $this->authorize('update', $project);

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
            $project = auth()->user()->projects()->create(request()->validate([
                'title' => 'required',
                'description' => 'required|max:100',
                'notes' => 'min:3'
            ]));

            return redirect($project->path());
        }

        public function edit(Project $project)
        {
            return view('projects.edit', [
                'project' => $project
            ]);
        }

        public function update(Project $project)
        {
            $attributes = request()->validate([
                'title' => 'sometimes|required',
                'description' => 'sometimes|required',
                'notes' => 'nullable'
            ]);

            $project->update($attributes);

            return redirect($project->path());
        }

        public function destroy(Project $project)
        {
            if (auth()->user()->isNot($project->owner)) {
                abort(403);
            }
            $project->delete();
            return redirect(route('projects'));
        }

    }
