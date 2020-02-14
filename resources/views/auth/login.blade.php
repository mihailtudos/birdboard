@extends('layouts.app')

@section('content')

    <div class="w-full max-w-xs mx-auto ">
        <div class="bg-white shadow-md rounded px-5 pt-6 pb-8 mb-4">
            <div class="text-center">
                <h1>{{ __('Login') }}</h1>
            </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4 mt-4">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="shadow appearance-none border  rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            </span>
                            @enderror
                        </div>
                    </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>

                        <div class="mt-4">
                            <button type="submit" class=" bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                {{ __('Login') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                </form>
        </div>
        <p class="text-center text-gray-500 text-xs">
            &copy;2020 QA. All rights reserved.
        </p>
    </div>



@endsection
