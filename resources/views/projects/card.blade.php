    <div class="card flex flex-col " style="height: 250px">
        <h3 class="font-normal text-xl mb-6 py-4 -ml-5 border-l-4 border-green-500 pl-4">
            <a class="no-underline font-bold " href="{{$project->path()}}">
                {{ Str::limit($project->title, 25) }}
            </a>
        </h3>

        <div class="text-gray-500 mb-4 flex-1 overflow-scroll">{{ $project->description }}</div>

        <footer>
            <form class="text-right items-bottom" action="{{$project->path()}}" method="post">
                @csrf
                @method('DELETE')
                <button class="text-xs text-red-500 font-bold" type="submit">Delete</button>
            </form>
        </footer>

    </div>

