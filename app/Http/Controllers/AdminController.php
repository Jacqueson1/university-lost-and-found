<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'items'          => Item::count(),
            'pending_items'  => Item::where('status', 'pending')->count(),
            'claimed_items'  => Item::where('status', 'claimed')->count(),
            'pending_claims' => Claim::where('status', 'pending')->count(),
        ];
        $recentClaims = Claim::with(['item', 'user'])->where('status', 'pending')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentClaims'));
    }

    // All items (admin sees the hidden description too)
    public function items()
    {
        $items = Item::with('finder')->withCount('claims')->latest()->get();
        return view('admin.items', compact('items'));
    }

    // Delete an item and its image file
    public function destroyItem(Item $item)
    {
        Storage::disk('public')->delete($item->image_path);
        $item->delete(); // claims are removed by the cascade
        return back()->with('success', 'Item deleted.');
    }

    // All claims, pending first
    public function claims()
    {
        $claims = Claim::with(['item', 'user'])
            ->orderByRaw("status = 'pending' desc")
            ->latest()
            ->get();
        return view('admin.claims', compact('claims'));
    }

    // Review one claim: finder's description vs claimer's proof
    public function showClaim(Claim $claim)
    {
        $claim->load(['item.finder', 'user']);
        return view('admin.claim-show', compact('claim'));
    }

    // Approve: item becomes claimed, all other claims auto-rejected
    public function approveClaim(Claim $claim)
    {
        if ($claim->status !== 'pending' || $claim->item->status === 'claimed') {
            return back()->withErrors(['claim' => 'This claim can no longer be approved.']);
        }

        // Transaction = all three updates succeed together or not at all
        DB::transaction(function () use ($claim) {
            $claim->update(['status' => 'approved']);
            $claim->item->update(['status' => 'claimed', 'claimed_at' => now()]);
            Claim::where('item_id', $claim->item_id)
                ->where('id', '!=', $claim->id)
                ->update(['status' => 'rejected']);
        });

        return redirect()->route('admin.claims')->with('success', 'Claim approved. Other claims were rejected.');
    }

    // Reject a single claim
    public function rejectClaim(Claim $claim)
    {
        if ($claim->status === 'pending') {
            $claim->update(['status' => 'rejected']);
        }
        return redirect()->route('admin.claims')->with('success', 'Claim rejected.');
    }
}
