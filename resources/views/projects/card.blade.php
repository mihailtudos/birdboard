    <div class="card" style="height: 200px">
        <h3 class="font-normal text-xl mb-6 py-4 -ml-5 border-l-4 border-green-500 pl-4">
            <a class="no-underline font-bold " href="{{$project->path()}}">
                {{ Str::limit($project->title, 25) }}
            </a>
        </h3>

        <div class="text-gray-500 mb-6">{{ Str::limit($project->description, 100)}}</div>

        <footer>
            <form class="text-right items-bottom" action="{{$project->path()}}" method="post">
                @csrf
                @method('DELETE')
                <button class="text-xs text-red-500 font-bold" type="submit">Delete</button>
            </form>
        </footer>

    </div>

