@extends('layouts.app')

@section('content')
    <div >
        <h1 class="heading is-1">Create a Project</h1>
        <form method="POST" action="/projects">

            @csrf

            <div class="field">
                <label class="lable" for="title">Title</label>

                <div class="control">
                    <input type="text" class="input"  name="title" placeholder="Title">
                </div>
            </div>

            <div class="field">
                <label class="lable" for="description">Description</label>

                <div class="control">
                    <input type="text" class="input"  name="description" placeholder="Description">
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <button type="submit" class="button is-link">Create Project</button>
                    <a href="/projects">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
