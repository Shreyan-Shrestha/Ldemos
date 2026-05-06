<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct(
        private readonly PostRepositoryInterface $posts
    ) {}

    public function index(): View
    {
        $posts = $this->posts->getPublished();
        $unposts = $this->posts->getDrafts();
        return view('posts.index', compact('posts','unposts'));
    }

    public function store(PostRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $post = $this->posts->storeDraft(array_merge($validated, [
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
