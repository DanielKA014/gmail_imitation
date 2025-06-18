@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Delete your account') }}</div>
                    <div class="card-body">
                        <div class = "alert alert-danger">
                            <strong>PERINGATAN!</strong>"Apakah Anda yakin untuk menghapus akun? Tindakan ini tidak bisa dibatalkan."
                        </div>
                        <form class="d-inline" method="POST" action="{{ route('user.destroy', [auth()->user()->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus Akun Saya</button>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection