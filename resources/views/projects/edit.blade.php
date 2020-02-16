@extends('layouts.app')

@section('content')
    <div class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">

        <h1 class="text-2xl mb-10 text-center font-normal">
            Edit your project
        </h1>
        <form method="POST" action="{{$project->path()}}">
        @csrf
        @method('PATCH')

        @include('projects._form', [
            'buttonText' => 'Update project'
            ])
        </form>
    </div>
@endsection
