<x-app-layout>
	<h2>Edit your project</h2>

	<form action="{{ $project->path() }}" method="POST">
	@csrf
	@method('PATCH')
	<!-- Title Form Input -->
		<div class="mb-6">
			<label class="block mb-2 uppercase font-bold text-xs text-gray-700"
			       for="title"
			>
				Title:
			</label>

			<input id="title"
			       class="border border-gray-400 p-2 w-full"
			       name="title"
			       placeholder="Title"
			       type="text"
			       value="{{ $project->title }}"
			>
		</div>

		<!-- Description Form Input -->
		<div class="mb-6">
			<label class="block mb-2 uppercase font-bold text-xs text-gray-700"
			       for="description"
			>
				Description:
			</label>

			<textarea id="description"
			          class="border border-gray-400 p-2 w-full"
			          name="description"
			>{{ $project->description }}</textarea>
		</div>

		<div class="mb-6">
			<button type="submit"
			        class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500"
			>
				Update
			</button>
		</div>
	</form>
</x-app-layout>