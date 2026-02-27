@extends('layouts.admin')

@section('title', __('Bejelentkezés'))
@section('subtitle', __('Admin belépés'))

@section('content')
<div class="card shadow-sm">
    <div class="card-body p-4">
        <h5 class="card-title mb-4">{{ __('Bejelentkezés') }}</h5>

        <form method="POST" action="{{ url('admin/login') }}">
            @csrf

            <div class="form-group">
                <label for="email">{{ __('E-Mail cím') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">{{ __('Jelszó') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">{{ __('Emlékezz rám') }}</label>
                </div>
            </div>

            <div class="form-group mb-0">
                <button type="submit" class="btn btn-primary btn-block">{{ __('Belépés') }}</button>
                @if (Route::has('password.request'))
                    <a class="btn btn-link btn-block btn-sm" href="{{ route('password.request') }}">{{ __('Jelszó emlékeztető') }}</a>
                @endif
            </div>
        </form>
    </div>
</div>
<p class="text-center text-muted small mt-3">
    <a href="{{ route('admin.register') }}">{{ __('Regisztráció') }}</a>
</p>
@endsection
