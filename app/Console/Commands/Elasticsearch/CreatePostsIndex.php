<?php

namespace App\Console\Commands\Elasticsearch;

use Elastic\Elasticsearch\Client;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('es:create-posts-index {--fresh : Drop the existing index before creating a new one}')]
#[Description('Create the Elasticsearch index for posts with explicit field mappings')]
class CreatePostsIndex extends Command
{
    public function __construct(private readonly Client $client)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $index = config('elasticsearch.indices.posts');

        // If --fresh is passed, drop the existing index first.
        // This is useful when you change the mapping and need to reindex from scratch.
        if ($this->option('fresh') && $this->indexExists($index)) {
            $this->client->indices()->delete(['index' => $index]);
            $this->info("Deleted existing index [{$index}].");
        }

        if ($this->indexExists($index)) {
            $this->warn("Index [{$index}] already exists. Use --fresh to recreate it.");
            return self::SUCCESS;
        }

        $this->client->indices()->create([
            'index' => $index,
            'body'  => [
                'settings' => [
                    // number_of_shards: how many pieces the index is split into.
                    // 1 is correct for a single-node development environment.
                    'number_of_shards'   => 1,
                    // number_of_replicas: how many copies of each shard exist.
                    // 0 is correct for a single-node cluster; 1+ requires multiple nodes.
                    'number_of_replicas' => 0,
                ],
                'mappings' => [
                    'properties' => [

                        // "text" type: the field is analyzed (tokenized, lowercased, stemmed).
                        // Suitable for full-text search where you want "posts" to match "post".
                        // The nested "keyword" sub-field stores the raw, unanalyzed string,
                        // which is useful for sorting and exact-match aggregations.
                        'title' => [
                            'type'   => 'text',
                            'fields' => [
                                'keyword' => ['type' => 'keyword'],
                            ],
                        ],

                        // The "english" analyzer applies language-specific stemming.
                        // "running" becomes "run", so a search for "run" matches "running".
                        // This is the key difference between "standard" and "english" analyzer.
                        'body' => [
                            'type'     => 'text',
                            'analyzer' => 'english',
                        ],

                        // "keyword" type: stored and searched as an exact string, never analyzed.
                        // Correct for values you filter on but never do full-text search against.
                        'author_name' => [
                            'type' => 'keyword',
                        ],

                        // "date" type: stored in milliseconds since epoch internally.
                        // Elasticsearch auto-detects ISO 8601 strings during indexing.
                        'published_at' => [
                            'type' => 'date',
                        ],
                    ],
                ],
            ],
        ]);

        $this->info("Index [{$index}] created successfully.");
        return self::SUCCESS;
    }

    private function indexExists(string $index): bool
    {
        return $this->client->indices()->exists(['index' => $index])->asBool();
    }
}
