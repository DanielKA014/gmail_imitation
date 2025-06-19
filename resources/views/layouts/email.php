<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Email System')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f6f8fc;
        }
        .wrapper {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 256px;
            background: white;
            padding: 20px;
            box-shadow: 2px 0 4px rgba(0,0,0,0.1);
        }
        .content {
            flex: 1;
            padding: 20px;
        }
        .menu-item {
            padding: 10px 15px;
            margin: 5px 0;
            border-radius: 0 16px 16px 0;
            cursor: pointer;
            transition: background 0.2s;
        }
        .menu-item:hover {
            background: #f1f3f4;
        }
        .menu-item i {
            margin-right: 10px;
        }
        .compose-btn {
            width: 100%;
            padding: 12px 24px;
            background: #c2e7ff;
            border: none;
            border-radius: 16px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: box-shadow 0.2s;
        }
        .compose-btn:hover {
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="sidebar">
            <button class="compose-btn" onclick="window.location.href='{{ route('email.create') }}'">
                <i class="fas fa-plus"></i> Compose
            </button>
            
            @section('sidebar')
                <div class="menu-item">
                    <i class="fas fa-inbox"></i> Inbox
                </div>
                <div class="menu-item">
                    <i class="fas fa-star"></i> Starred
                </div>
                <div class="menu-item">
                    <i class="fas fa-paper-plane"></i> Sent
                </div>
                <div class="menu-item">
                    <i class="fas fa-file"></i> Drafts
                </div>
            @show
        </div>
        
        <div class="content">
            @yield('content')
        </div>
    </div>
</body>
</html>