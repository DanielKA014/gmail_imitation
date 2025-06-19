@extends('layouts.app') {{-- Ganti kalau layout kamu bukan app --}}

@section('content')
    <div class="container">
        <h2>Sent Emails</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @forelse($emails as $email)
            <div class="card mb-3">
                <div class="card-body">
                    <strong>To:</strong> {{ $email->to }}<br>
                    <strong>Subject:</strong> {{ $email->subject }}<br>
                    <strong>Body:</strong> {{ $email->body }}<br>

                    @if($email->file_path)
                        <p><strong>Attachment:</strong>
                            <a href="{{ asset('storage/' . $email->file_path) }}" target="_blank">View File</a>
                        </p>
                    @endif

                    <small>Sent at: {{ $email->created_at->format('d M Y H:i') }}</small>
                </div>
            </div>
        @empty
            <p>No emails sent yet.</p>
        @endforelse
    </div>
@endsection
