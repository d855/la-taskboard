<div class="bg-card flex flex-col rounded-lg shadow h-52 p-5 cursor-pointer hover:shadow-lg transition ease-in-out duration-250">
	<h3 class="font-normal text-xl text-default py-4 border-l-4 border-cyan-400 -ml-5 pl-4">{{ $project->title }}</h3>

	<div class="text-default mb-4 flex-1">{{ Str::limit($project->description, 100) }}</div>

	@can('manage', $project)
		<footer>
			<form action="{{ $project->path() }}" method="POST" class="text-right">
				@method('DELETE')
				@csrf
				<button type="submit" class="text-xs hover:text-red-500 transition ease-in-out">Delete</button>
			</form>
		</footer>
	@endcan

</div>

