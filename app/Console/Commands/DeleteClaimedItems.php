<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;

#[Signature('items:delete-claimed')]
#[Description('Command description')]
class DeleteClaimedItems extends Command
{
    protected $signature = 'items:delete-claimed';
    protected $description = 'Delete items that were claimed more than 3 days ago';

    public function handle()
    {
        // Claimed items older than 3 days
        $items = Item::where('status', 'claimed')
            ->where('claimed_at', '<=', now()->subDays(3))
            ->get();

        foreach ($items as $item) {
            Storage::disk('public')->delete($item->image_path); // delete the image file
            $item->claims()->delete();                          // no claim history kept
            $item->delete();
        }

        $this->info("Deleted {$items->count()} item(s).");
    }
}
