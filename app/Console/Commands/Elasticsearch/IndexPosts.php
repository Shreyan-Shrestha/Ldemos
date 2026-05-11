<?php

namespace App\Console\Commands\Elasticsearch;

use App\Models\Post;
use Elastic\Elasticsearch\Client;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('es:index-posts')]
#[Description('Index all published posts into Elasticsearch')]
class IndexPosts extends Command
{
    public function __construct(private readonly Client $client)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $index = config('elasticsearch.indices.posts');

        $posts = Post::with('author')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->get();

        if ($posts->isEmpty()) {
            $this->warn('No published posts found to index.');
            return self::SUCCESS;
        }

        $this->info("Indexing {$posts->count()} posts...");

        foreach ($posts as $post) {
            $this->client->index([
                'index' => $index,
                'id'    => $post->id,
                'body'  => [
                    'title'        => $post->title,
                    'body'         => $post->content,
                    'author_name'  => $post->author->name,
                    'published_at' => $post->published_at->toIso8601String(),
                ],
            ]);
        }

        $this->info("Indexed {$posts->count()} posts successfully.");
        return self::SUCCESS;
    }
}
