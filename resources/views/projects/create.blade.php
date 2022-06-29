<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport"
		      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Document</title>
	</head>
	<body>
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
		</form>
	</body>
</html>