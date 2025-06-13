<!-- resources/views/email/form.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Tulis Email</title>
</head>
<body>
    <h2>Buat Email</h2>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('email.draft') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="email" name="to" required placeholder="Kepada"><br>
        <input type="text" name="subject" placeholder="Subjek"><br>
        <textarea name="body" placeholder="Isi Email"></textarea><br>
        <input type="file" name="attachment" accept="image/*"><br>
        
        <button type="submit">Simpan Draf</button>
        @foreach ($drafts as $draft)
            <p><strong>{{ $draft->subject }}</strong> - {{ $draft->to }}</p>
            <form action="{{ route('email.send', $draft->id) }}" method="POST">
                @csrf
                <button type="submit">Kirim</butto>
            </form>
        @endforeach
    </form>
</body>
</html>
