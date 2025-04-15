{{--<!DOCTYPE html>--}}
{{--<html>--}}
{{--<head>--}}
{{--    <title>Register</title>--}}
{{--</head>--}}
{{--<body>--}}

{{--<h2>Register</h2>--}}

{{--<form method="POST" action="/register">--}}
{{--    @csrf--}}

{{--    <div>--}}
{{--        <label>FirstName</label>--}}
{{--        <input type="text" name="firstname" value="{{ old('firstname') }}" required>--}}
{{--        @error('firstname') <div>{{ $message }}</div> @enderror--}}
{{--    </div>--}}

{{--    <div>--}}
{{--        <label>LastName</label>--}}
{{--        <input type="text" name="lastname" value="{{ old('lastname') }}" required>--}}
{{--        @error('lastname') <div>{{ $message }}</div> @enderror--}}
{{--    </div>--}}

{{--    <div>--}}
{{--        <label>Username</label>--}}
{{--        <input type="text" name="username" value="{{ old('username') }}" required>--}}
{{--        @error('username') <div>{{ $message }}</div> @enderror--}}
{{--    </div>--}}

{{--    <div>--}}
{{--        <label>Email</label>--}}
{{--        <input type="email" name="email" value="{{ old('email') }}" required>--}}
{{--        @error('email') <div>{{ $message }}</div> @enderror--}}
{{--    </div>--}}

{{--    <div>--}}
{{--        <label>Password</label>--}}
{{--        <input type="password" name="password" required>--}}
{{--        @error('password') <div>{{ $message }}</div> @enderror--}}
{{--    </div>--}}

{{--    <div>--}}
{{--        <label>Confirm Password</label>--}}
{{--        <input type="password" name="password_confirmation" required>--}}
{{--    </div>--}}

{{--    <button type="submit">Register</button>--}}
{{--</form>--}}

{{--<p>Already have an account? <a href="{{ route('login') }}">Login</a></p>--}}

{{--</body>--}}
{{--</html>--}}

@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3 class="mb-4">Register</h3>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="firstname" class="form-label">Firstname <span class="text-danger">*</span></label>
                    <input type="text" name="firstname" class="form-control" value="{{ old('firstname') }}">
                    @error('firstname') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="lastname" class="form-label">Lastname <span class="text-danger">*</span></label>
                    <input type="text" name="lastname" class="form-control" value="{{ old('lastname') }}">
                    @error('lastname') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                    <input type="text" name="username" class="form-control" value="{{ old('username') }}">
                    @error('username') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" value="{{ old('password') }}">
                    @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}">
                    @error('password_confirmation') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-success w-100">Register</button>
            </form>
        </div>
    </div>
@endsection
