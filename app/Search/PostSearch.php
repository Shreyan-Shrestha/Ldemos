<?php

namespace App\Search;

use Elastic\Elasticsearch\Client;

class PostSearch
{
    public function __construct(private readonly Client $client)
    {
    }

    /**
     * Search published posts by keyword.
     *
     * Returns an array of document IDs in relevance order (highest score first).
     * The caller is responsible for fetching the full Eloquent models using these IDs.
     *
     * @return string[]
     */
    public function search(string $query, int $size = 15): array
    {
        $response = $this->client->search([
            'index' => config('elasticsearch.indices.posts'),
            'body'  => [
                // Limit results to the requested page size
                'size'  => $size,
                'query' => [
                    // bool query combines multiple conditions.
                    // Conditions in "must" affect the relevance score.
                    // Conditions in "filter" do not affect score but exclude non-matching docs.
                    'bool' => [
                        'must' => [
                            [
                                // multi_match searches across multiple fields in one expression.
                                'multi_match' => [
                                    'query'     => $query,
                                    // title^2 boosts title matches: a hit in the title is
                                    // worth twice as much as a hit in the body.
                                    'fields'    => ['title^2', 'body'],
                                    // fuzziness AUTO: Elasticsearch calculates the allowed edit
                                    // distance based on term length.
                                    // "laravel" (7 chars) allows 2 character edits,
                                    // so "laravle" still matches.
                                    'fuzziness' => 'AUTO',
                                    // At least one of the query terms must match
                                    'operator'  => 'or',
                                ],
                            ],
                        ],
                        'filter' => [
                            [
                                // range filter: only include documents where published_at
                                // is in the past. "now" is a special Elasticsearch date math
                                // expression that resolves to the current UTC timestamp.
                                'range' => [
                                    'published_at' => [
                                        'lte' => 'now',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        // Each hit has a "_id" field containing the MySQL primary key we stored during indexing.
        // array_column extracts all "_id" values into a flat array.
        return array_column($response['hits']['hits'], '_id');
    }
}