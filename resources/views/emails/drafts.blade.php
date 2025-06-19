<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Draft Emails</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 90%;
            margin: 30px auto;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
            vertical-align: top;
        }
        .success {
            color: green;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Draft Emails</h2>
    @foreach ($emails as $email)
                        <tr>
                            <td>{{ $email->to }}</td>
                            <td>{{ $email->subject }}</td>
                            <td>{{ Str::limit($email->body, 100) }}</td>
                            <td>{{ $email->created_at->format('d M Y H:i') }}</td>
                            <td>
                                @if($email->file_path)
                                    <img src="{{ asset('storage/' . $email->file_path) }}" width="100" alt="attachment">
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    @endsection

</body>
</html>
