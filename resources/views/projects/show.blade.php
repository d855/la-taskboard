<x-app-layout>
	<header class="flex items-center mb-3 py-4">
		<div class="flex justify-between items-end w-full">
			<p class="text-default font-semibold text-sm capitalize">
				<a href="{{ route('projects') }}">My projects</a> / {{ $project->title }}
			</p>
			<div class="flex items-center">
				@foreach($project->members as $member)
					<img src="{{ gravatar_url($member->email) }}"
					     alt="{{ $member->name }}'s avatar"
					     class="rounded-full w-8 mr-2">
				@endforeach
				<a href="{{ route('projects.edit', $project) }}"
				   class="bg-button text-white py-2 px-4 shadow hover:bg-cyan-500 rounded-md transition ml-6 ease-in-out duration-150">Edit
				                                                                                                                         Project</a>
			</div>
		</div>
	</header>

	<section>
		<div class="flex p-4 -mx-3 space-x-5">
			<div class="lg:w-3/4 px-3">
				<div class="mb-6">
					<h2 class="text-default text-lg font-semibold mb-3">Tasks</h2>
					{{-- tasks --}}

					<div class="space-y-4">
						@foreach($project->tasks as $task)
							<div class="bg-card rounded-lg shadow-xl p-5 cursor-pointer hover:shadow-lg transition ease-in-out duration-250">
								<form action="{{ $project->path() . '/tasks/' . $task->id }}" method="POST">
									@method('PATCH')
									@csrf
									<div class="flex items-center">
										<input name="body"
										       type="text"
										       value="{{ $task->body }}"
										       class="w-full border-none bg-card focus:outline-none {{ $task->completed ? 'text-default' : '' }}">

										<input name="completed"
										       type="checkbox"
										       onChange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
									</div>
								</form>
							</div>
						@endforeach
						<div class="bg-card rounded-lg shadow-xl p-5 cursor-pointer hover:shadow-lg transition ease-in-out duration-250">
							<form method="POST" action="{{ $project->path() . '/tasks' }}">
								@csrf
								<input type="text"
								       name="body"
								       placeholder="Add new task..."
								       class="w-full bg-card border-none focus:border-none">
							</form>
						</div>
					</div>
				</div>

				<div>
					<h2 class="text-default text-lg font-semibold mb-3">General Notes</h2>
					{{-- general notes--}}

					<form method="POST" action="{{ $project->path() }}">
						@csrf
						@method('PATCH')
						<textarea id="notes"
						          name="notes"
						          class="bg-card w-full rounded-lg text-base mb-4 shadow p-5 cursor-pointer border-none hover:shadow-lg transition ease-in-out duration-250"
						          style="min-height: 200px;">{{ $project->notes }}</textarea>
						<button type="submit"
						        class="bg-button text-white py-2 px-4 shadow hover:bg-cyan-500 rounded-md transition ease-in-out duration-150">
							Save
						</button>
					</form>

					@include('errors')
				</div>
			</div>

			<div class="lg:w-1/4">
				@include('projects.card')

				<div class="bg-card rounded-lg shadow p-5 cursor-pointer hover:shadow-lg transition ease-in-out duration-250 mt-3">
					<ul class="text-sm space-y-1">
						@foreach($project->activity as $activity)
							<li>
								@include("projects.activity.{$activity->description}")
								<span class="text-gray-500 text-xs">{{ $activity->created_at->diffForHumans(null, true) }}</span>
							</li>
						@endforeach
					</ul>
				</div>

				@can('manage', $project)
					<div class="bg-card flex flex-col justify-start rounded-lg shadow mt-5 p-5 cursor-pointer hover:shadow-lg transition ease-in-out duration-250">
						<h3 class="font-normal text-xl py-4 border-l-4 border-cyan-400 -ml-5 pl-4">Invite a User</h3>

						<form action="{{ $project->path() . '/invitations' }}" method="POST">
							@csrf

							<div class="mb-3">
								<input type="email" name="email" class="border border-gray-300 rounded w-full" placeholder="Email address">
							</div>
							<button type="submit" class="bg-button text-white py-2 px-4 shadow hover:bg-cyan-500 rounded-md transition ml-6 ease-in-out duration-150">Invite</button>
						</form>
						@include('errors', ['bag' => 'invitations'])
					</div>
				@endcan
			</div>
		</div>
	</section>
</x-app-layout>