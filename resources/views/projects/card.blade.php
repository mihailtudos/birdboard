    <div class="card" style="height: 250px">
        <h3 class="font-normal text-xl mb-6 py-4 -ml-5 border-l-4 border-green-500 pl-4">
            <a class="no-underline font-bold " href="{{$project->path()}}">
                {{ Str::limit($project->title, 25) }}
            </a>
        </h3>

        <div class="text-gray-500">{{ Str::limit($project->description, 100)}}</div>
    </div>

