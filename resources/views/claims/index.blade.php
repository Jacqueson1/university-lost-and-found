@extends('layouts.user')
@section('title', 'My Claims')

@section('content')
<section class="panel">
    <h2><i data-lucide="clipboard-list"></i> My Claims</h2>

    @forelse ($claims as $claim)
        <div class="claim-row">
            <a href="{{ route('items.show', $claim->item) }}">{{ $claim->item->name }}</a>
            <span class="badge {{ $claim->status === 'approved' ? 'badge--claimed' : '' }}">
                {{ ucfirst($claim->status) }}
            </span>
        </div>
    @empty
        <p>You haven't claimed any items yet.</p>
    @endforelse
</section>
@endsection
