@extends('layouts.user')
@section('title', 'Report Item')

@section('content')
<section class="panel">
    <h2><i data-lucide="package-plus"></i> Report a found item</h2>

    {{-- enctype is required for file upload --}}
    <form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data" class="form">
        @csrf

        <label>Photo
            <input type="file" name="image" accept="image/*" required>
        </label>

        <label>Item name (shown publicly, e.g. "Blue key")
            <input type="text" name="name" value="{{ old('name') }}" required>
        </label>

        <label>Found at
            <input type="text" name="found_place" value="{{ old('found_place') }}" required>
        </label>

        <label>Date found
            <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
        </label>

        <label>Description (hidden; admin uses it to verify owners)
            <textarea name="detail" rows="4" required>{{ old('detail') }}</textarea>
        </label>

        @if ($errors->any())
            <p class="error">{{ $errors->first() }}</p>
        @endif

        <button class="btn btn--primary"><i data-lucide="send"></i> Submit</button>
    </form>
</section>
@endsection
