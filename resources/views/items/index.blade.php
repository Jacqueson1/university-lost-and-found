@extends('layouts.user')
@section('title', 'Browse Items')

@section('content')
<!-- Bento grid: hero + search + item cards -->
<section class="bento">

    <div class="bento__hero">
        <h1>Found it, Report it, Reunite with it.</h1>
        <p>Browse items found around campus, or report one you found.</p>
        <form method="GET" class="search">
            <i data-lucide="search"></i>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search item name...">
            <button class="btn btn--primary">Search</button>
        </form>
    </div>

    @forelse ($items as $item)
        <a href="{{ route('items.show', $item) }}" class="card">
            {{-- <img src="{{ asset('storage/'.$item->image_path) }}" alt="{{ $item->name }}"> --}}
            {{-- Uncomment this if dr Su wants it later. --}}
            <div class="card__body">
                <div>
                    <h3>{{ $item->name }}</h3>
                    <p class="muted">{{ Str::limit($item->item_description, 70) }}</p>
                </div>
                
                <h3>{{ $item->name }}</h3>
                @if ($item->status === 'claimed')
                    <span class="badge badge--claimed">Claimed</span>
                @else
                    <span class="badge">Available</span>
                @endif
            </div>
        </a>
    @empty
        <p class="empty">No items found.</p>
    @endforelse

</section>
@endsection
