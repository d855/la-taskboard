<x-app-layout>


	<h2>Create a project</h2>

	<form action="/projects" method="POST">
	@csrf
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
			></textarea>
		</div>

		<div class="mb-6">
			<button type="submit"
			        class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500"
			>
				Create a Project
			</button>
		</div>

		@if($errors->any())
			<div class="mt-6">
				@foreach($errors->all() as $error)
					<li class="text-sm text-red-600">{{ $error }}</li>
				@endforeach
			</div>
		@endif
	</form>
</x-app-layout>