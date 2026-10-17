@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<h1>Dashboard</h1>

<!-- Bento grid: stat tiles + recent claims -->
<section class="bento">
    <div class="tile"><i data-lucide="package"></i><span class="tile__num">{{ $stats['items'] }}</span>Total items</div>
    <div class="tile"><i data-lucide="clock"></i><span class="tile__num">{{ $stats['pending_items'] }}</span>Pending items</div>
    <div class="tile"><i data-lucide="check-circle"></i><span class="tile__num">{{ $stats['claimed_items'] }}</span>Claimed items</div>
    <div class="tile tile--accent"><i data-lucide="clipboard-check"></i><span class="tile__num">{{ $stats['pending_claims'] }}</span>Claims to review</div>

    <div class="tile tile--wide">
        <h3>Latest pending claims</h3>
        @forelse ($recentClaims as $claim)
            <a class="row" href="{{ route('admin.claims.show', $claim) }}">
                <span>{{ $claim->item->name }} <small>by {{ $claim->user->username }}</small></span>
                <i data-lucide="chevron-right"></i>
            </a>
        @empty
            <p class="muted">No pending claims.</p>
        @endforelse
    </div>
</section>
@endsection
