<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
        <tr>
            <th>from</th>
            <th>to</th>
            <th>subject</th>
            <th>body</th>
        </tr>
        @foreach ($emails as $email)
        <tr>
            <td>{{ $email->from }}</td>
            <td>{{ $email->to }}</td>
            <td>{{ $email->subject }}</td>
            <td>{{ $email->body }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>