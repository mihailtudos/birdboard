@extends('layouts.app')

@section('content')

    <header class="flex items-center mb-3 py-3">
        <div class="flex justify-between  items-end w-full">
            <p class="text-gray-600 text-lg font-normal" >
                <a href="/projects">My Projects</a>  / {{ $project->title }}
            </p>
            <a class="button" href="/projects/create">New project</a>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3 ">
            {{-- Tasks section --}}
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-10">
                    <h2 class="text-gray-600 text-lg font-normal mb-3" >Tasks</h2>

                    @foreach($project->tasks as $task)
                        <div class="card mb-4">
                            <form method="post" action="{{$task->path()}}">
                                @method('PATCH')
                                @csrf

                                <div class="flex items-end">
                                    <input class="w-full mr-4 {{$task->completed ? 'text-green-500 ' : ''}}" type="text" name="body" id="body" value="{{ $task->body }}" >
                                    <input type="checkbox" class="form-checkbox" name="completed" id="completed" onChange="this.form.submit()" {{$task->completed ? 'checked' : ''}}>
                                </div>
                            </form>

                        </div>
                    @endforeach
                    <div class="card mb-4">
                        <form action="{{ $project->path().'/tasks' }}" method="post">
                            @csrf
                            <div class="flex">
                                <input type="text" name="body" id="body" class="w-full mr-4 rounded border-solid border-2 border-green-500" placeholder="Add task">
                                <button type="submit" class="button">Add</button>
                            </div>

                        </form>
                    </div>

                </div>
                {{-- Notes --}}
                <div>
                    <h2 class="text-gray-600 text-lg font-normal mb-3">General notes on this project</h2>
                    {{-- Coments --}}
                    <form action="{{ $project->path() }}" method="post" class="mt-5">
                        @csrf
                        @method('PATCH')
                        <textarea name="notes" class="card mb-3 w-full" style="min-height: 200px" placeholder="Space for your notes.">{{ $project->notes }}</textarea>
                        <button type="submit" class="button">Save</button>
                    </form>
                </div>

            </div>
            {{-- Project card section --}}
            <div class="lg:w-1/4 px-3">
                <div class="card" style="height: 250px">
                    <h3 class="font-normal text-xl mb-6 py-4 -ml-5 border-l-4 border-green-500 pl-4">
                        <a class="no-underline font-bold " href="{{$project->path()}}">
                            {{ Str::limit($project->title, 25) }}
                        </a>
                    </h3>

                    <div class="text-gray-500">{{ $project->description }}</div>
                </div>

            </div>
            </div>
        </div>

    </main>
    <a class="button" href="/projects"> Go Back</a>



@endsection

