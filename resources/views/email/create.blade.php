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
    <form action="{{ route('email.store') }}" method="post">
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
        <div>
            <button type="submit">Send</button>
        </div>
    </form>

    <script>
        $(document).ready(function () {
            $('#to').select2();
        });
    </script>
</body>

</html>