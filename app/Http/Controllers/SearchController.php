<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Search\PostSearch;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __construct(private readonly PostSearch $postSearch) {}

    public function index(Request $request): View
    {
        $query = $request->input('q', '');
        $posts = collect();

        if (filled($query)) {
            // Step 1: ask Elasticsearch for the IDs of matching documents, in relevance order
            $ids = $this->postSearch->search($query);

            if (!empty($ids)) {
                // Step 2: fetch full Eloquent models from MySQL using those IDs.
                // We re-order in PHP to preserve the relevance order Elasticsearch gave us,
                // because SQL's whereIn() does not guarantee ordering.
                $modelsById = Post::with('author')
                    ->whereIn('id', $ids)
                    ->get()
                    ->keyBy('id');

                $posts = collect($ids)
                    ->map(fn ($id) => $modelsById->get((int) $id))
                    ->filter(); // remove nulls for documents that no longer exist in MySQL
            }
        }

        return view('search.index', compact('posts', 'query'));
    }
}