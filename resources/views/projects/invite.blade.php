<div >
    <div class="card flex flex-col mt-4" >
        <h3 class="font-normal text-xl mb-2 py-4 -ml-5 border-l-4 border-green-500 pl-4">
            Invite a user
        </h3>
        <form action="{{$project->path().'/invitations'}}" method="post">
            @csrf
            <div class="mb-3">
                <input class="border border-green-500 rounded w-full py-2 px-2" type="email" name="email" id="email" placeholder="User email">
                @error('email')
                <span class="text-sm text-red-500 font-bold">{{$message}}</span>
                @enderror
            </div>
            <button class="button" type="submit">Invite</button>
        </form>
    </div>
</div>
