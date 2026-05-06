<?php

namespace App\Jobs;

use App\Models\Post;
use Elastic\Elasticsearch\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class IndexPostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // SerializesModels stores only the model's primary key in the serialized payload.
    // When the job runs, Laravel re-fetches the full model from MySQL.
    // This means the job always indexes the most up-to-date version of the post.
    public function __construct(private readonly Post $post) {}

    public function handle(Client $client): void
    {
        $client->index([
            'index' => config('elasticsearch.indices.posts'),
            'id'    => $this->post->id,
            'body'  => [
                'title'        => $this->post->title,
                'body'         => $this->post->body,
                // Null-safe: if the author was deleted between job dispatch and execution,
                // fall back to an empty string rather than crashing the job.
                'author_name'  => $this->post->author?->name ?? '',
                'published_at' => $this->post->published_at?->toIso8601String(),
            ],
        ]);
    }
}