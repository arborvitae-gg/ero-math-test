@extends('layouts.app')

@section('content')
    <style>

         header {
            background: darkblue;
            padding: 1rem 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .nav-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .logo img {
            height: 40px;
            width: auto;
            display: block;
            padding-left: 20px;
        }

        nav {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background 0.2s;
        }

        nav a:hover {
            background: #1a2533;
        }
        .forgot-card {
    max-width: 400px;
    margin: 2rem auto;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.10);
    padding: 2rem 2rem 1.5rem 2rem;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.forgot-title {
    font-size: 2rem;
    font-weight: 500;
    margin-bottom: 1.5rem;
    color: #222;
    width: 100%;
    text-align: left;
}
.forgot-form-group {
    width: 100%;
    margin-bottom: 1.2rem;
}
.forgot-label {
    display: block;
    font-size: 1rem;
    margin-bottom: 0.3rem;
    color: #333;
}
.forgot-input {
    width: 100%;
    padding: 0.7rem;
    border: 1px solid #e0e0e0;
    border-radius: 6px;
    background: #f7f7f7;
    font-size: 1rem;
    outline: none;
    transition: border 0.2s;
}
.forgot-input:focus {
    border: 1.5px solid #2d3e50;
    background: #fff;
}
.forgot-btn {
    width: 100%;
    background: #222;
    color: #fff;
    border: none;
    border-radius: 24px;
    padding: 0.9rem 0;
    font-size: 1.1rem;
    font-weight: 500;
    margin-top: 0.5rem;
    cursor: pointer;
    transition: background 0.2s;
}
.forgot-btn:hover {
    background: #2d3e50;
}
.forgot-status {
    color: #388e3c;
    margin-bottom: 1rem;
    width: 100%;
    text-align: center;
}
.forgot-desc {
    color: #444;
    margin-bottom: 1.5rem;
    width: 100%;
    text-align: left;
    font-size: 1rem;
}
</style>
    <div class="forgot-card">
        <div class="forgot-title">Forgot Password</div>
        <div class="forgot-desc">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @if (session('status'))
            <div class="forgot-status">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" style="width: 100%;">
            @csrf

            <div class="forgot-form-group">
                <label for="email" class="forgot-label">{{__('Email')}}</label>
                <input id="email" type="email" name="email" class="forgot-input" value="{{ old('email') }}" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="" />
            </div>

            <button type="submit" class="forgot-btn">{{ __('Email Password Reset Link') }}</button>
        </form>
    </div>
@endsection
