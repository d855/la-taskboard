<x-app-layout>
	<header class="flex justify-between items-end mb-3 py-4">
		<h2 class="text-gray-400 font-semibold text-sm capitalize">My projects</h2>
		<a href="{{ route('projects.create') }}"
		   class="bg-cyan-400 text-white py-2 px-4 shadow hover:bg-cyan-500 rounded-md transition ease-in-out duration-150">Add
		                                                                                                                    project</a>
	</header>

	<div class="grid gap-5 grid-cols-1 md:grid-cols-3">
		@forelse($projects as $project)
			<a href="{{ route('projects.show', $project) }}">
				@include('projects.card')
			</a>
		@empty
			<div>No projects yet</div>
		@endforelse
	</div>
</x-app-layout>
