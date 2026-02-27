@extends('layouts.admin')

@section('title', __('Regisztráció'))
@section('subtitle', __('Új fiók létrehozása'))

@section('content')
<div class="card shadow-sm">
    <div class="card-body p-4">
        <h5 class="card-title mb-4">{{ __('Regisztráció') }}</h5>

        <form method="POST" action="{{ url('admin/register') }}">
            @csrf

            <div class="form-group">
                <label for="name">{{ __('Név') }}</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">{{ __('E-Mail cím') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">{{ __('Jelszó') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password-confirm">{{ __('Jelszó újra') }}</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>

            <div class="form-group mb-0">
                <button type="submit" class="btn btn-primary btn-block">{{ __('Regisztrálok') }}</button>
            </div>
        </form>
    </div>
</div>
<p class="text-center text-muted small mt-3">
    <a href="{{ route('admin.login') }}">{{ __('Bejelentkezés') }}</a>
</p>
@endsection
