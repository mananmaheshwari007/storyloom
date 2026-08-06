{{--
    Rebuilt on the admin layout.

    Breeze shipped this page as <x-app-layout>, which renders layouts.app and
    passes the page body as $slot. layouts.app was later rewritten as the public
    marketing layout and outputs @yield('content') instead — so the slot was
    silently discarded and the page rendered as a header and footer with nothing
    between them. It also carried Tailwind classes, which this site doesn't load.

    Account settings belong with the rest of the dashboard anyway, so it now
    extends layouts.admin and uses the same Bootstrap styling as every other
    admin screen.
--}}
@extends('layouts.admin')

@section('title', 'My Account')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="page-title h3 mb-1"><i class="bi bi-person-gear me-2 text-primary"></i> My Account</h1>
        <p class="text-muted small mb-0">Your login details for the Storyloom dashboard.</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">My Account</li>
        </ol>
    </nav>
</div>

@if (session('status') === 'profile-updated')
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i> Your details were updated.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('status') === 'password-updated')
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i> Your password was changed. It applies the next time you sign in.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4">
    {{-- ---------- Password ---------- --}}
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold text-dark"><i class="bi bi-key me-2 text-primary"></i> Change Password</h5>
            </div>
            <div class="card-body">
                <p class="text-muted small">Use a long, unique password you don't use anywhere else.</p>

                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="mb-3">
                        <label for="current_password" class="form-label fw-bold">Current Password</label>
                        <input id="current_password" name="current_password" type="password" autocomplete="current-password"
                               class="form-control form-control-sm @error('current_password', 'updatePassword') is-invalid @enderror">
                        @error('current_password', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">New Password</label>
                        <input id="password" name="password" type="password" autocomplete="new-password"
                               class="form-control form-control-sm @error('password', 'updatePassword') is-invalid @enderror">
                        @error('password', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label fw-bold">Confirm New Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                               class="form-control form-control-sm @error('password_confirmation', 'updatePassword') is-invalid @enderror">
                        @error('password_confirmation', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm fw-bold px-4">
                        <i class="bi bi-save me-1"></i> Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ---------- Name / email ---------- --}}
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold text-dark"><i class="bi bi-person me-2 text-primary"></i> Your Details</h5>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Name</label>
                        <input id="name" name="name" type="text" autocomplete="name" required
                               value="{{ old('name', $user->name) }}"
                               class="form-control form-control-sm @error('name') is-invalid @enderror">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Email — this is your login</label>
                        <input id="email" name="email" type="email" autocomplete="username" required
                               value="{{ old('email', $user->email) }}"
                               class="form-control form-control-sm @error('email') is-invalid @enderror">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm fw-bold px-4">
                        <i class="bi bi-save me-1"></i> Save Details
                    </button>
                </form>
            </div>
        </div>

        <div class="alert alert-light border small">
            <i class="bi bi-shield-lock me-1 text-primary"></i>
            Signing in uses the email address above. If you change it, use the new address next time.
        </div>
    </div>
</div>
@endsection
