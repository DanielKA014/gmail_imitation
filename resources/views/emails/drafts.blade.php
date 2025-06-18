@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Draft Emails</h2>

    <div class="mb-3">
        <strong>Drafts:</strong> {{ $draftCount }} |
        <strong>Sent:</strong> {{ $sentCount }} |
        <strong>Favorites:</strong> {{ $favoriteCount }}
    </div>

    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    @if ($emails->isEmpty())
        <p>You don't have any draft emails yet.</p>
    @else
        <table border="1" cellpadding="10" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>To</th>
                    <th>Subject</th>
                    <th>Body</th>
                    <th>Created At</th>
                    <th>Attachment</th>
                </tr>
            </thead>
            <tbody>
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
