<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Draft Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Draft Email</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($drafts->isEmpty())
            <p>You have no draft email.</p>
        @else
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>To</th>
                        <th>Subject</th>
                        <th>Body</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($drafts as $draft)
                        <tr>
                            <td>{{ $draft->to ?? '-' }}</td>
                            <td>{{ $draft->subject ?? '-' }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($draft->body, 50) }}</td>
                            <td>{{ $draft->created_at->format('Y-m-d H:i') }}</td>  
                            <td>
                                <a href="{{ route('email.show', $draft->id) }}" class="btn btn-sm btn-primary">View</a>

                                <form action="{{ route('draft.send', $draft->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-success">Send</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('email.create') }}" class="btn btn-secondary">Compose New Email</a>
    </div>
</body>
</html>
