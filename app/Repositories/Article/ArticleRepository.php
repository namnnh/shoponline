<?php

namespace App\Repositories\Article;

use Illuminate\Database\Eloquent\Collection;

interface ArticleRepository
{
    public function search(string $query = ""): Collection;
}