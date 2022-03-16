<?php

namespace App\Repositories;

use App\Models\Article;

class ArticleRepository
{
    protected function queryActive()
    {
        return Article::select(
            'id',
            'slug',
            'images',
            'title',
            'sumary',
            'user_id')
            ->with('user:id,name')
            ->whereActive(true);
    }

    protected function queryActiveOrderByDate()
    {
        return $this->queryActive()->latest();
    }

    public function getActiveOrderByDate($nbrPages)
    {
        return $this->queryActiveOrderByDate()->paginate($nbrPages);
    }

    public function getHeros()
    {
        return $this->queryActive()->with('categories')->latest('updated_at')->take(5)->get();
    }

    public function getArticleBySlug($slug)
    {
        // Article for slug with user, tags and categories
        $article = Article::with(
            'user:id,name,email',
            'tags:id,title,slug',
            'categories:title,slug'
        )
           // ->withCount('validComments')
            ->whereSlug($slug)
            ->firstOrFail();

        // Previous article
        $article->previous = $this->getPreviousArticle($article->id);

        // Next post
        $article->next = $this->getNextArticle($article->id);

        return $article;
    }

    protected function getPreviousArticle($id)
    {
        return Article::select('title', 'slug')
            ->whereActive(true)
            ->latest('id')
            ->firstWhere('id', '<', $id);
    }

    protected function getNextArticle($id)
    {
        return Article::select('title', 'slug')
            ->whereActive(true)
            ->oldest('id')
            ->firstWhere('id', '>', $id);
    }

    public function getActiveOrderByDateForCategory($nbrPages, $category_slug)
    {
        return $this->queryActiveOrderByDate()
            ->whereHas('categories', function ($q) use ($category_slug) {
                $q->where('categories.slug', $category_slug);
            })->paginate($nbrPages);
    }

    public function getActiveOrderByDateForUser($nbrPages, $user_id)
    {
        return $this->queryActiveOrderByDate()
            ->whereHas('user', function ($q) use ($user_id) {
                $q->where('users.id', $user_id);
            })->paginate($nbrPages);
    }

    public function getActiveOrderByDateForTag($nbrPages, $tag_slug)
    {
        return $this->queryActiveOrderByDate()
            ->whereHas('tags', function ($q) use ($tag_slug) {
                $q->where('tags.slug', $tag_slug);
            })->paginate($nbrPages);
    }

    public function search($n, $search)
    {
        return $this->queryActiveOrderByDate()
            ->where(function ($q) use ($search) {
                $q->where('sumary', 'like', "%$search%")
                    ->orWhere('body', 'like', "%$search%")
                    ->orWhere('title', 'like', "%$search%");
            })->paginate($n);
    }
}