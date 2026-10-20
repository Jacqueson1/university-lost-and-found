@extends('layouts.admin')
@section('title', 'Review Claim')

@section('content')
<h1>Review claim</h1>

<!-- Bento grid: photo | finder description | claimer proof -->
<section class="bento bento--review">
    <div class="tile">
        {{-- <img src="{{ asset('storage/'.$claim->item->image_path) }}" class="review-img"> --}}
        {{-- Uncomment this if dr Su wants it later. --}}
        
        <h3>{{ $claim->item->name }}</h3>
        <p class="muted">{{ $claim->item->found_place }} · {{ $claim->item->date->format('d M Y') }}</p>
    </div>

    <div class="tile">
        <h3><i data-lucide="file-text"></i> Finder's description</h3>
        <p class="muted">Submitted by {{ $claim->item->finder->username }}</p>
        <p>{{ $claim->item->detail }}</p>
    </div>

    <div class="tile tile--accent">
        <h3><i data-lucide="hand"></i> Claimer's proof</h3>
        <p class="muted">By {{ $claim->user->username }} ({{ $claim->user->email }})</p>
        <p>{{ $claim->proof_of_ownership }}</p>
    </div>
</section>

@if ($claim->status === 'pending' && $claim->item->status === 'pending')
    <div class="actions">
        <form method="POST" action="{{ route('admin.claims.approve', $claim) }}">
            @csrf <button class="btn btn--primary"><i data-lucide="check"></i> Approve</button>
        </form>
        <form method="POST" action="{{ route('admin.claims.reject', $claim) }}">
            @csrf <button class="btn btn--danger"><i data-lucide="x"></i> Reject</button>
        </form>
    </div>
@else
    <p>Status: <span class="badge badge--{{ $claim->status }}">{{ ucfirst($claim->status) }}</span></p>
@endif
@endsection
