<div>
	<div class="bg-white rounded-lg shadow h-52 p-5 cursor-pointer hover:shadow-lg transition ease-in-out duration-250">
		<h3 class="font-normal text-xl py-4 border-l-4 border-cyan-400 -ml-5 pl-4">{{ $project->title }}</h3>

		<div class="text-gray-500">{{ Str::limit($project->description, 100) }}</div>
	</div>
</div>