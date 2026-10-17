@extends('layouts.admin')
@section('title', 'Claims')

@section('content')
<h1>Claims</h1>

<div class="panel">
    <table class="table">
        <thead><tr><th>Item</th><th>Claimed by</th><th>Date</th><th>Status</th><th></th></tr></thead>
        <tbody>
        @forelse ($claims as $claim)
            <tr>
                <td>{{ $claim->item->name }}</td>
                <td>{{ $claim->user->username }}</td>
                <td>{{ $claim->date->format('d M Y') }}</td>
                <td><span class="badge badge--{{ $claim->status }}">{{ ucfirst($claim->status) }}</span></td>
                <td><a href="{{ route('admin.claims.show', $claim) }}" class="btn btn--primary">
                    <i data-lucide="eye"></i> Review</a></td>
            </tr>
        @empty
            <tr><td colspan="5">No claims yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
