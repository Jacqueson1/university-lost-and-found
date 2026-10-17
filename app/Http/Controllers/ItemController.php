<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $items = Item::query()
            ->when($request->q, fn($query, $q) => $query->where('name', 'like', "%{$q}%"))
            ->latest()
            ->get();

        return view('items.index', compact('items'));
    }

    // Show the "report found item" form
    public function create()
    {
        return view('items.create');
    }

    // Save the submitted item
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'detail'      => 'required|string',
            'found_place' => 'required|string|max:150',
            'date'        => 'required|date',
            'image'       => 'required|file',
        ]);

        // Store the image in storage/app/public/items
        $data['image_path'] = $request->file('image')->store('items', 'public');
        unset($data['image']);

        $data['user_id'] = $request->user()->id;
        $data['status']  = 'pending';

        Item::create($data);

        return redirect()->route('items.index')->with('success', 'Item reported. Thank you!');
    }

    // Single item page (public: image + name only; claim form comes in Phase 5)
    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }
}
