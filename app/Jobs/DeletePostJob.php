<?php

namespace App\Jobs;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeletePostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // The job receives the post's integer ID, not the model.
    // This is intentional: when the "deleted" event fires, the MySQL record is already gone.
    // If we passed the model with SerializesModels, Laravel would try to re-fetch it
    // from the database and get a ModelNotFoundException.
    public function __construct(private readonly int $postId) {}

    public function handle(Client $client): void
    {
        try {
            $client->delete([
                'index' => config('elasticsearch.indices.posts'),
                'id'    => $this->postId,
            ]);
        } catch (ClientResponseException $e) {
            // A 404 means the document was never indexed in the first place.
            // This can happen if a draft post (which we do not index) is deleted.
            // It is not an error condition, so we swallow it silently.
            if ($e->getCode() !== 404) {
                throw $e;
            }
        }
    }
}