@extends('layouts.admin')
@section('title', 'Items')

@section('content')
<h1>Items</h1>

<div class="panel">
    <table class="table">
        <thead>
            <tr><th>Photo</th><th>Name</th><th>Description (hidden)</th><th>Found</th><th>Finder</th><th>Status</th><th>Claims</th><th></th></tr>
        </thead>
        <tbody>
        @foreach ($items as $item)
            <tr>
                <td><img src="{{ asset('storage/'.$item->image_path) }}" class="thumb"></td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->detail }}</td>
                <td>{{ $item->found_place }}<br><small>{{ $item->date->format('d M Y') }}</small></td>
                <td>{{ $item->finder->username }}</td>
                <td><span class="badge {{ $item->status === 'claimed' ? 'badge--dark' : '' }}">{{ ucfirst($item->status) }}</span></td>
                <td>{{ $item->claims_count }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.items.destroy', $item) }}"
                          onsubmit="return confirm('Delete this item?')">
                        @csrf @method('DELETE')
                        <button class="btn btn--danger"><i data-lucide="trash-2"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
