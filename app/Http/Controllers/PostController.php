<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;
use App\Search\PostSearch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct(
        private readonly PostRepositoryInterface $posts,
        private readonly PostSearch $postSearch,
    ) {}

    public function index(Request $request): View
    {
        $query   = $request->input('q', '');
        $posts   = collect();

        if (filled($query)) {
            $ids = $this->postSearch->search($query);

            if (!empty($ids)) {
                $modelsById = Post::with('author')
                    ->whereIn('id', $ids)
                    ->get()
                    ->keyBy('id');

                $posts = collect($ids)
                    ->map(fn ($id) => $modelsById->get((int) $id))
                    ->filter();
            }
        } else {
            $posts = $this->posts->getPublished();
        }

        $unposts = $this->posts->getDrafts();

        return view('posts.index', compact('posts', 'unposts', 'query'));
    }

    public function store(PostRequest $request): RedirectResponse
    {
        $this->posts->storeDraft(array_merge($request->validated(), [
            'user_id' => $request->user()->id,
        ]));

        return redirect()->route('posts.index')->with('message', 'Draft saved successfully!');
    }

    public function publish(Post $post): RedirectResponse
    {
        $this->posts->publish($post);

        return redirect()->route('posts.index')->with('message', 'Post published successfully.');
    }

    public function unpublish(Post $post): RedirectResponse
    {
        $this->posts->updateDraft($post, $post->toArray());

        return redirect()->route('posts.index')->with('message', 'Post unpublished successfully.');
    }
}