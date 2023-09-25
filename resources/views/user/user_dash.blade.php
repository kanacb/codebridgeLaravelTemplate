@extends('user.layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Dashboard</div>
            <div class="card-body">
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
                @else
                <div class="alert alert-success">
                    You are logged in!
                </div>
                @endif
            </div>
            <div>
                <p>Welcome to your dashboard!</p>

                {{-- Check if email_verified_at is not null --}}
                @if (Auth::user()->email_verified_at)
                <p>Verified</p>
                @else
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            Send Verification Link
                        </button>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
