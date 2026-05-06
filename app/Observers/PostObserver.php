<?php

namespace App\Observers;

use App\Jobs\DeletePostJob;
use App\Jobs\IndexPostJob;
use App\Models\Post;

class PostObserver
{
    // The "saved" event fires after both create and update operations.
    // We only index posts that are published. If a published post is reverted
    // to a draft, the old document stays in the index until the next indexing cycle.
    // For production use, you would also dispatch a delete here when published_at is null.
    public function saved(Post $post): void
    {
        if ($post->published_at !== null) {
            IndexPostJob::dispatch($post);
        }
    }

    // The "deleted" event fires after the record has been removed from MySQL.
    // We pass only the ID, not the model, for the reason documented in DeletePostJob.
    public function deleted(Post $post): void
    {
        DeletePostJob::dispatch($post->id);
    }
}