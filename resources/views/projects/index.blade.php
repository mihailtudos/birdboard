@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-3">
        <div class="flex justify-between  items-end w-full">
            <h2 class="text-gray-600 text-lg font-normal" >My Projects</h2>
            <a class="button" href="/projects/create">New project</a>
        </div>
    </header>

    <main class="lg:flex lg:flex-wrap -mx-3 ">
        @forelse($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">
                <div class="card" style="height: 250px">
                    <h3 class="font-normal text-xl mb-6 py-4 -ml-5 border-l-4 border-green-500 pl-4">
                        <a class="no-underline font-bold " href="{{$project->path()}}">
                            {{ Str::limit($project->title, 25) }}
                        </a>
                    </h3>

                    <div class="text-gray-500">{{ Str::limit($project->description, 100)}}</div>
                </div>

            </div>
        @empty
            <div>No articles</div>
        @endforelse
    </main>
@endsection

