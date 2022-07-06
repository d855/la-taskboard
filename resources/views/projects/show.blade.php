<x-app-layout>
	<header class="flex justify-between items-end mb-3 py-4">
		<p class="text-gray-400 font-semibold text-sm capitalize">
			<a href="{{ route('projects') }}">My projects</a> / {{ $project->title }}
		</p>
		<a href="{{ route('projects.edit', $project) }}"
		   class="bg-cyan-400 text-white py-2 px-4 shadow hover:bg-cyan-500 rounded-md transition ease-in-out duration-150">Edit
		                                                                                                                    Project</a>
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
								<form action="{{ $project->path() . '/tasks/' . $task->id }}" method="POST">
									@method('PATCH')
									@csrf
									<div class="flex items-center">
										<input name="body"
										       type="text"
										       value="{{ $task->body }}"
										       class="w-full border-none focus:border-none {{ $task->completed ? 'text-gray-400' : '' }}">
										<input name="completed"
										       type="checkbox"
										       onChange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
									</div>
								</form>
							</div>
						@endforeach
						<div class="bg-white rounded-lg shadow p-5 cursor-pointer hover:shadow-lg transition ease-in-out duration-250">
							<form method="POST" action="{{ $project->path() . '/tasks' }}">
								@csrf
								<input type="text"
								       name="body"
								       placeholder="Add new task..."
								       class="w-full border-none focus:border-none">
							</form>
						</div>
					</div>
				</div>

				<div>
					<h2 class="text-gray-400 text-lg font-semibold mb-3">General Notes</h2>
					{{-- general notes--}}

					<form method="POST" action="{{ $project->path() }}">
						@csrf
						@method('PATCH')
						<textarea id="notes"
						          name="notes"
						          class="bg-white w-full rounded-lg text-base mb-4 shadow p-5 cursor-pointer border-none hover:shadow-lg transition ease-in-out duration-250"
						          style="min-height: 200px;">{{ $project->notes }}</textarea>
						<button type="submit"
						        class="bg-cyan-400 text-white py-2 px-4 shadow hover:bg-cyan-500 rounded-md transition ease-in-out duration-150">
							Save
						</button>
					</form>
				</div>
			</div>

			<div class="lg:w-1/4">
				@include('projects.card')

				<div class="bg-white rounded-lg shadow p-5 cursor-pointer hover:shadow-lg transition ease-in-out duration-250 mt-3">
					<ul class="text-sm space-y-1">
						@foreach($project->activity as $activity)
							<li>
								@include("projects.activity.{$activity->description}")
								<span class="text-gray-500 text-xs">{{ $activity->created_at->diffForHumans(null, true) }}</span>
							</li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	</section>
</x-app-layout>