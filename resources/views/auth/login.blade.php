@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3 class="mb-4">Login</h3>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email_username" class="form-label">Email or Username <span class="text-danger">*</span></label>
                    <input type="text" name="email_username" class="form-control" value="{{ old('email_username') }}">
                    @error('email_username') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control">
                    @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

{{--                <div class="mb-3 form-check">--}}
{{--                    <input type="checkbox" name="remember" class="form-check-input" id="remember">--}}
{{--                    <label class="form-check-label" for="remember">Remember Me</label>--}}
{{--                </div>--}}

                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
@endsection


