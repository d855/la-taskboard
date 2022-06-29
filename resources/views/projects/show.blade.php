<x-app-layout>
	<header class="flex justify-between items-end mb-3 py-4">
		<p class="text-gray-400 font-semibold text-sm capitalize">
			<a href="{{ route('projects') }}">My projects</a> / {{ $project->title }}
		</p>
		<a href="{{ route('projects.create') }}"
		   class="bg-cyan-400 text-white py-2 px-4 shadow hover:bg-cyan-500 rounded-md transition ease-in-out duration-150">Add
		                                                                                                                    project</a>
	</header>

	<section>
		<div class="flex -mx-3 space-x-5">
			<div class="lg:w-3/4 px-3">
				<div class="mb-6">
					<h2 class="text-gray-400 text-lg font-semibold mb-3">Tasks</h2>
					{{-- tasks --}}

					<div class="space-y-4">
						@foreach($project->tasks as $task)
							<div class="bg-white rounded-lg shadow p-5 cursor-pointer hover:shadow-lg transition ease-in-out duration-250">
								{{ $task->body }}
							</div>
						@endforeach
					</div>
				</div>

				<div>
					<h2 class="text-gray-400 text-lg font-semibold mb-3">General Notes</h2>
					{{-- general notes--}}

					<textarea id="genera_notes"
					          name="general_notes"
					          class="bg-white w-full rounded-lg text-base shadow p-5 cursor-pointer border-none hover:shadow-lg transition ease-in-out duration-250"
					          style="min-height: 200px;">lorem
					</textarea>
				</div>
			</div>

			<div class="lg:w-1/4">
				@include('projects.card')
			</div>
		</div>
	</section>
</x-app-layout>