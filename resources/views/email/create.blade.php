<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body>
    <form action="{{ route('email.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="from">From</label>
            <span id="from">{{ auth()->user()->email }}</span>
        </div>
        <label for="to">To</label>
        <select name="to" id="to">
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->email }}</option>
            @endforeach
        </select>
        <div>
            <label for="subject">Subject</label>
            <input type="text" name="subject" id="subject">
        </div>
        <div>
            <label for="body">Body</label>
            <textarea name="body" id=""></textarea>
        </div>
        <div>
            <label for="file">File</label>
            <input type="file" name="file" id="">
        </div>

        <button type="submit" name="action" value="draft">Simpan ke Draft</button>
        <button type="submit" name="action" value="send">Kirim</button>
    </form>

    <script>
        $(document).ready(function () {
            $('#to').select2();
        });
    </script>
</body>

<form action="{{ route('emails.send') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- input email, subject, body, dan lampiran -->
    <input type="email" name="to" required>
    <input type="text" name="subject" required>
    <textarea name="body" required></textarea>
    <input type="file" name="image">

    <!-- Tombol kirim -->
    <button type="submit" name="action" value="send">Send</button>
</form>


</html>