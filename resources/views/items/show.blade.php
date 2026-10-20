@extends('layouts.user')
@section('title', $item->name)

@section('content')
@php
    // The logged-in user's existing claim for this item (if any)
    $myClaim = auth()->check() ? $item->claims->where('user_id', auth()->id())->first() : null;
@endphp

<section class="panel panel--detail">
    {{-- <img src="{{ asset('storage/'.$item->image_path) }}" alt="{{ $item->name }}"> --}}
    {{-- Uncomment this if dr Su wants it later. --}}

    <div>
        <h2>{{ $item->name }}</h2>
        <p>{{ $item->item_description }}</p>
        
        <h2>{{ $item->name }}</h2>
        <p class="muted">
            <i data-lucide="map-pin"></i> {{ $item->found_place }}<br>
            <i data-lucide="calendar"></i> {{ $item->date->format('d M Y') }}
        </p>

        @if ($item->status === 'claimed')
            <span class="badge badge--claimed">Claimed</span>

        @elseif ($myClaim)
            {{-- User already claimed this item --}}
            <span class="badge">Your claim: {{ ucfirst($myClaim->status) }}</span>

        @elseif (auth()->check())
            {{-- Claim form --}}
            <span class="badge">Available</span>
            <form method="POST" action="{{ route('claims.store', $item) }}" class="form">
                @csrf
                <label>Prove this is yours
                    <textarea name="proof_of_ownership" rows="4"
                        placeholder="Describe the item in detail (colour, marks, contents, etc.)" required>{{ old('proof_of_ownership') }}</textarea>
                </label>

                @if ($errors->any())
                    <p class="error">{{ $errors->first() }}</p>
                @endif

                <button class="btn btn--primary"><i data-lucide="hand"></i> Claim this item</button>
            </form>

        @else
            {{-- Guest --}}
            <span class="badge">Available</span>
            <p><a href="{{ route('login') }}" class="btn btn--primary"><i data-lucide="log-in"></i> Login to claim</a></p>
        @endif
    </div>
</section>
@endsection
