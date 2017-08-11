<?php

namespace App\Repositories\Article;

use App\Article;
use Illuminate\Database\Eloquent\Collection;

class EloquentArticle implements ArticleRepository
{
    public function search(string $query = ""): Collection
    {
        return Article::where('body', 'like', "%{$query}%")
            ->orWhere('title', 'like', "%{$query}%")
            ->get();
    }
}