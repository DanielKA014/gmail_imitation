<!DOCTYPE html>
<html>
<head>
    <title>View Email</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f6f8fc;
            color: #202124;
            line-height: 1.5;
        }

        .email-full {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
            padding: 24px;
        }

        .email-actions {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f1f3f4;
        }

        .back-btn {
            background: none;
            border: none;
            color: #1a73e8;
            cursor: pointer;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 14px;
            transition: background 0.2s;
        }

        .back-btn:hover {
            background: #f1f3f4;
        }

        .star-btn {
            background: none;
            border: none;
            padding: 8px;
            cursor: pointer;
            color: #5f6368;
            transition: color 0.2s;
            margin-left: 8px;
        }

        .star-btn.active {
            color: #f4b400;
        }

        h1 {
            font-size: 24px;
            margin: 0 0 16px;
            color: #202124;
        }

        .email-meta {
            color: #5f6368;
            font-size: 14px;
            margin-bottom: 24px;
            line-height: 1.8;
        }

        .email-body {
            color: #202124;
            font-size: 16px;
            line-height: 1.6;
        }

        .attachment {
            margin-top: 24px;
            padding-top: 16px;
            border-top: 1px solid #f1f3f4;
        }

        .attachment-preview {
            max-width: 100%;
            border-radius: 8px;
        }

        .email-image {
            margin-top: 16px;
            text-align: center;
        }

        .email-image img {
            max-width: 100%;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="email-full">
        <div class="email-actions">
            <button onclick="window.history.back()" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back
            </button>
            
            <form action="{{ route('emails.toggle-favorite', $email) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="star-btn {{ $isFavorited ? 'active' : '' }}">
                    <i class="fas fa-star"></i>
                </button>
            </form>
        </div>

        <h1>{{ $email->subject }}</h1>
        <div class="email-meta">
            From: {{ $email->from }}<br>
            To: {{ $email->to }}<br>
            Date: {{ $email->created_at->format('M d, Y h:i A') }}
        </div>
        <div class="email-body">
            {{ $email->body }}
            
            @if($email->image_path)
                <div class="email-image">
                    <img src="{{ asset('storage/' . $email->image_path) }}" alt="Email attachment">
                </div>
            @endif
        </div>
    </div>
</body>
</html>