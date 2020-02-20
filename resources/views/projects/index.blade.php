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
                @include('projects.card')
            </div>
        @empty
            <div>No projects found, but you can create one at anytime!</div>
        @endforelse
    </main>
@endsection

