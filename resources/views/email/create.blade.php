<!DOCTYPE html>
<html>
<head>
    <title>Create Email</title>
    <style>
        /* ...existing styles... */
        .image-preview {
            max-width: 200px;
            margin-top: 10px;
        }
        .file-input {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="email-form">
        <h1>New Email</h1>
        
        @if ($errors->any())
            <div style="color: red; margin-bottom: 15px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('email.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>From:</label>
                <input type="hidden" name="from" value="{{ Auth::user()->email }}">
                <span id = "from">{{ auth()->user()->email }}</span>
            </div>
            <div class="form-group">
                <label>To:</label>
                <input type="email" name="to" value="{{ old('to') }}" required>
            </div>

            <div class="form-group">
                <label>Subject:</label>
                <input type="text" name="subject" value="{{ old('subject') }}" required>
            </div>

            <div class="form-group">
                <label>Message:</label>
                <textarea name="body" rows="5" required>{{ old('body') }}</textarea>
            </div>

            <div class="form-group">
                <label>Image:</label>
                <input type="file" name="image" class="file-input" accept="image/*" onchange="previewImage(this)">
                <img id="preview" class="image-preview" style="display: none;">
            </div>
            <button type="submit" name="action" value="draft">Send as Draft</button>
            <button type="submit" name="action" value="send">Send Email</button>
        </form>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>