<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\User;
use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostRepository implements PostRepositoryInterface
{
    public function __construct(
        private readonly Post $model
    ) {}

    /**
     * Get paginated published posts, sorted by most recent publication date.
     *
     * "Published" means: has a published_at timestamp that is not in the future.
     * Future-dated posts are excluded deliberately, to support scheduled publishing.
     */
    public function getPublished(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->with('author')          // Eager-load to prevent N+1 queries in the view
            ->latest('published_at')
            ->paginate($perPage);
    }

    /**
     * Get all drafts (posts that have no published_at value).
     *
     * Sorted by creation date so the most recently created drafts appear first.
     */
    public function getDrafts(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->whereNull('published_at')
            ->with('author')
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get all posts belonging to a specific user, regardless of publish status.
     *
     * Useful for "My Posts" views or admin dashboards where you need
     * to see both published and draft posts for a single author.
     */
    public function getByUser(User $user, int $perPage = 10): LengthAwarePaginator
    {
        return $this->model
            ->where('user_id', $user->id)
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Retrieve a single post and load its author relationship in the same query.
     *
     * Throws ModelNotFoundException if the post does not exist, which Laravel
     * automatically converts to a 404 response in controllers.
     */
    public function findWithAuthor(int $id): Post
    {
        return $this->model
            ->with('author')
            ->findOrFail($id);
    }

    /**
     * Publish a post by recording the current time as its publication timestamp.
     *
     * Returns the refreshed model so the caller always gets up-to-date attributes,
     * including the newly set published_at value.
     */
    public function publish(Post $post): Post
    {
        $post->update(['published_at' => now()]);

        // fresh() re-fetches the record from the database to reflect
        // any changes made by database triggers or other processes
        return $post->fresh();
    }

    /**
     * Save a new post as a draft.
     *
     * The published_at override ensures that even if the caller accidentally
     * passes a timestamp in $data, this method always stores a draft.
     * The intent is enforced at the repository level, not at the call site.
     */
    public function storeDraft(array $data): Post
    {
        return $this->model->create(
            array_merge($data, ['published_at' => null])
        );
    }

    public function updateDraft(Post $post, array $data): Post
    {
        $post->update(
            array_merge($data, ['published_at' => null])
        );

        return $post->fresh();
    }
}