<?php

namespace App\Repositories\Contracts;

use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface
{
    // Each signature here is a promise: any class implementing this interface
    // must provide exactly these methods with exactly these type signatures.
    // This contract is what the controller and tests will depend on.

    public function getPublished(int $perPage = 15): LengthAwarePaginator;

    public function getDrafts(int $perPage = 15): LengthAwarePaginator;

    public function getByUser(User $user, int $perPage = 10): LengthAwarePaginator;

    public function findWithAuthor(int $id): Post;

    public function publish(Post $post): Post;

    public function storeDraft(array $data): Post;

    public function updateDraft(Post $post, array $data): Post;
}