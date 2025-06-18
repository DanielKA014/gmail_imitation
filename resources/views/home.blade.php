@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}

                        <a href="{{ route('user.delete.confirm') }}" class="btn btn-danger">
                            Hapus Akun Saya
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<!DOCTYPE html>
<html>
<head>
    <title>Email Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f6f8fc;
            color: #202124;
            line-height: 1.5;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 256px;
            background: white;
            padding: 16px;
            position: fixed;
            height: 100vh;
            box-shadow: 2px 0 4px rgba(0,0,0,0.1);
        }

        .compose-btn {
            width: 100%;
            padding: 12px 24px;
            background: #c2e7ff;
            border: none;
            border-radius: 16px;
            cursor: pointer;
            font-weight: 500;
            transition: box-shadow 0.2s;
        }

        .compose-btn:hover {
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }

        .menu-list {
            margin-top: 20px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 24px;
            text-decoration: none;
            color: #202124;
            border-radius: 0 16px 16px 0;
            margin: 4px 0;
        }

        .menu-item:hover {
            background: #f1f3f4;
        }

        .menu-item.active {
            background: #d3e3fd;
        }

        .menu-item i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            margin-left: 256px;
            flex: 1;
            padding: 20px;
        }

        .email-list {
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .email-item {
            display: flex;
            align-items: center;
            padding: 16px;
            border-bottom: 1px solid #f1f3f4;
            transition: box-shadow 0.2s;
        }

        .email-item:hover {
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .star-btn {
            background: none;
            border: none;
            padding: 8px;
            cursor: pointer;
            color: #5f6368;
            transition: color 0.2s;
        }

        .star-btn.active {
            color: #f4b400;
        }

        .star-btn:hover {
            opacity: 0.8;
        }

        .email-content {
            flex: 1;
            margin: 0 16px;
        }

        .email-subject {
            font-weight: 500;
            margin-bottom: 4px;
        }

        .email-preview {
            color: #5f6368;
            font-size: 14px;
        }

        .email-date {
            color: #5f6368;
            font-size: 12px;
            margin-left: 16px;
        }

        .count {
            margin-left: auto;
            background: #e8eaed;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
        }

        .logout-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s;
        }

        .logout-btn:hover {
            background: #bb2d3b;
        }

        .delete-account-btn {
            position: fixed;
            top: 60px;
            right: 20px;
            background: #dc3545;
            color: white;
            border: none;
            padding: 4px 8px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s;
        }

        .delete-account-btn:hover {
            background: #bb2d3b;
        }
    </style>
</head>
<body>
    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>

    <form action="{{ route('user.delete.confirm') }}" method="GET" style="display: inline;">
        @csrf
        <button type="submit" class="delete-account-btn">
            <i class="fas fa-user-times"></i> Hapus Akun
        </button>
    </form>

    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="user-info">
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-email">{{ Auth::user()->email }}</div>
            </div>
            <button onclick="window.location.href='{{ route('emails.create') }}'" class="compose-btn">
                <i class="fas fa-plus"></i> Compose
            </button>

            <nav class="menu-list">
                <a href="{{ route('home') }}" class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="fas fa-inbox"></i> Inbox
                    <span class="count">{{ ($emails ?? collect([]))->count() }}</span>
                </a>
                
                <a href="{{ route('emails.favorites') }}" class="menu-item {{ request()->routeIs('emails.favorites') ? 'active' : '' }}">
                    <i class="fas fa-star"></i> Starred
                    <span class="count">{{ $favoriteCount ?? 0 }}</span>
                </a>
                
                <a href="{{ route('emails.sent') }}" class="menu-item {{ request()->routeIs('emails.sent') ? 'active' : '' }}">
                    <i class="fas fa-paper-plane"></i> Sent
                    <span class="count">{{ $sentCount ?? 0 }}</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="email-list">
                @forelse($emails ?? collect([]) as $email)
                    <div class="email-item">
                        <form action="{{ route('emails.toggle-favorite', $email) }}" method="POST">
                            @csrf
                            <button type="submit" class="star-btn {{ $email->favorites()->where('user_id', auth()->id())->exists() ? 'active' : '' }}">
                                <i class="fas fa-star"></i>
                            </button>
                        </form>

                        <div class="email-content" onclick="window.location.href='{{ route('emails.show', $email->id) }}'">
                            <div class="email-subject">{{ $email->subject }}</div>
                            <div class="email-preview">
                                <span class="email-sender">{{ $email->from }}</span> -
                                {{ Str::limit($email->body, 100) }}
                            </div>
                        </div>

                        <div class="email-date">{{ $email->created_at->format('M d') }}</div>
                    </div>
                @empty
                    <div class="email-item">
                        <p>No emails found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</body>
</html>