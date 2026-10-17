<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Item;
use Illuminate\Http\Request;

class ClaimController extends Controller
{
    public function index(Request $request)
    {
        $claims = Claim::with('item')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return view('claims.index', compact('claims'));
    }

    // Save a claim with the proof of ownership
    public function store(Request $request, Item $item)
    {
        // Can't claim an item that is already claimed
        if ($item->status === 'claimed') {
            return back()->withErrors(['proof_of_ownership' => 'This item has already been claimed.']);
        }
        // The finder can't claim their own item
        if ($item->user_id === $request->user()->id) {
            return back()->withErrors(['proof_of_ownership' => 'You reported this item, so you cannot claim it.']);
        }

        $request->validate([
            'proof_of_ownership' => 'required|string',
        ]);

        // One claim per user per item
        $alreadyClaimed = Claim::where('item_id', $item->id)
            ->where('user_id', $request->user()->id)
            ->exists();

        if ($alreadyClaimed) {
            return back()->withErrors(['proof_of_ownership' => 'You already submitted a claim for this item.']);
        }

        Claim::create([
            'item_id'            => $item->id,
            'user_id'            => $request->user()->id,
            'proof_of_ownership' => $request->proof_of_ownership,
            'date'               => now()->toDateString(),
            'status'             => 'pending',
        ]);

        return redirect()->route('claims.index')->with('success', 'Claim submitted. Admin will review it.');
    }
}
