<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Create</title>
</head>
<body>
    <table>
        <tr>
            <th>from</th>
            <th>to</th>
            <th>subject</th>
            <th>body</th>
            <th>file</th>
        </tr>
        @foreach ($email as $email)
        <tr>
            <td>{{ $email->from }}</td>
            <td>{{ $email->to }}</td>
            <td>{{ $email->subject }}</td>
            <td>{{ $email->body }}</td>
            <td>{{ $email->file_path}}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>