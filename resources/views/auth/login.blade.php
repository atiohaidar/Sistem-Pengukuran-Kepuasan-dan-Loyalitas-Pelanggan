@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="login-card">
        <div class="card-body p-5">
          <div class="text-center mb-4">
            <i class="bi bi-clipboard-data display-3 text-primary"></i>
            <h3 class="mt-3">Login</h3>
            <p class="text-muted">Aplikasi Survei</p>
          </div>

          <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                       name="email" value="{{ old('email') }}" required autofocus placeholder="Email">
                @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="mb-4">
              <label for="password" class="form-label">Password</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                       name="password" required placeholder="Password">
                @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">
              {{ __('Login') }}
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
