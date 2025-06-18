<!DOCTYPE html>
<html>
<head>
    <title>Favorite Emails</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f6f8fc;
            color: #202124;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 256px;
            background: white;
            padding: 16px;
            position: fixed;
            height: 100vh;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
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
            transition: background 0.2s;
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
        }

        .main-content {
            margin-left: 256px;
            flex: 1;
            padding: 20px;
        }

        .email-list {
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
            overflow: hidden;
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

        .email-content {
            flex: 1;
            margin: 0 16px;
        }

        .email-subject {
            font-weight: 500;
            margin-bottom: 4px;
            color: #202124;
            text-decoration: none;
        }

        .email-preview {
            color: #5f6368;
            font-size: 14px;
        }

        .email-date {
            color: #5f6368;
            font-size: 12px;
            white-space: nowrap;
        }

        .back-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #1a73e8;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 24px;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transition: background 0.2s;
        }

        .back-btn:hover {
            background: #1557b0;
        }

        .email-link {
            text-decoration: none;
            color: inherit;
        }
        .email-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- ... existing sidebar code ... -->

        <div class="main-content">
            <div class="email-list">
                @forelse($emails as $email)
                    <div class="email-item">
                        <form action="{{ route('emails.toggle-favorite', $email) }}" method="POST">
                            @csrf
                            <button type="submit" class="star-btn">
                                <i class="fas fa-star"></i>
                            </button>
                        </form>

                        <div class="email-content">
                            <a href="{{ route('emails.show', $email) }}" class="email-link">
                                <div class="email-subject">{{ $email->subject }}</div>
                                <div class="email-sender">From: {{ $email->from }}</div>
                                <div class="email-preview">{{ Str::limit($email->body, 100) }}</div>
                            </a>
                        </div>

                        <div class="email-date">
                            {{ $email->created_at->format('M d') }}
                        </div>
                    </div>
                @empty
                    <div class="email-item">
                        <p>No favorite emails found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</body>
</html>