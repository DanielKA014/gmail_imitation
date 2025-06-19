@extends('layouts.app')

@section('content')
<div class="container">
    <h1>All Emails</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Subject</th>
                <th>Body</th>
                <th>Sent At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($email as $email)
                <tr>
                    <td>{{ $email->subject }}</td>
                    <td>{{ $email->body }}</td>
                    <td>{{ $email->created_at->format('d M Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection