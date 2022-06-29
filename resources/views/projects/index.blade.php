<x-app-layout>
	<header class="flex justify-between items-center mb-3 py-4">
		<h2 class="text-gray-400 font-semibold text-sm capitalize">My projects</h2>
		<a href="{{ route('projects.create') }}"
		   class="bg-cyan-400 text-white py-2 px-4 shadow hover:bg-cyan-500 rounded-md transition ease-in-out duration-150">Add
		                                                                                                                    project</a>
	</header>

	<div class="grid gap-5 grid-cols-1 md:grid-cols-3">
		@forelse($projects as $project)
			<a href="{{ route('projects.show', $project) }}">
				<div class="bg-white rounded-lg shadow h-52 p-5 cursor-pointer hover:shadow-lg transition ease-in-out duration-250">
					<h3 class="font-normal text-xl py-4 border-l-4 border-cyan-400 -ml-5 pl-4">{{ $project->title }}</h3>

					<div class="text-gray-500">{{ Str::limit($project->description, 100) }}</div>
				</div>
			</a>
		@empty
			<div>No projects yet</div>
		@endforelse
	</div>
</x-app-layout>
