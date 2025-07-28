@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2>Your Notifications</h2>
    <ul class="list-group">
        @forelse ($notifications as $notification)
            <li class="list-group-item">
                {{ $notification->data['message'] }}
                <span class="text-muted">{{ $notification->created_at->diffForHumans() }}</span>
            </li>
        @empty
            <li class="list-group-item">No notifications</li>
        @endforelse
    </ul>
</div>
@endsection
