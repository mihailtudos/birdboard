
    <div class="field mb-6">
        <label class="lable text-sm mb-2 block" for="title">Title</label>

        <div class="control">
            <input type="text" class="input bg-transparent border border-grey-500 rounded p-2 text-xs w-full"
                   name="title" placeholder="My next project title" value="{{$project -> title}}" required maxlength="100">

            @error('title')
            <span class="invalid-feedback" role="alert">
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    </span>
            @enderror
        </div>
    </div>

    <div class="field mb-6">
        <label class="lable text-sm mb-2 block" for="description">Description</label>

        <div class="control">
                <textarea name="description" placeholder="What is the project about in 200 characters" rows="10" maxlength="200"
                          class="textarea bg-transparent border border-grey-500 rounded p-2 text-xs w-full" required>{{$project->description}}</textarea>

            @error('description')
            <span class="invalid-feedback" role="alert">
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    </span>
            @enderror
        </div>
    </div>

    <div class="">
        <div class="control">
            <button type="submit" class="button is-link">{{$buttonText}}</button>
            <a class="" href="{{$project->path()}}">Cancel</a>
        </div>
    </div>


