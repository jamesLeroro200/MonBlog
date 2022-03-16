<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\SearchRequest;
use App\Models\Categories;
use App\Models\Tag;
use App\Models\User;
use App\Repositories\ArticleRepository;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    protected $articleRepository;
    protected $nbrPages;

   public function __construct(ArticleRepository $articleRepository)
   {
       $this->articleRepository = $articleRepository;
       $this->nbrPages = config('app.nbrPages.articles');
   }

   public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
   {
       $articles = $this->articleRepository->getActiveOrderByDate($this->nbrPages);
       $heros = $this->articleRepository->getHeros();

       return view('front.index', compact('articles', 'heros'));
   }

    public function show(Request $request, $slug)
    {
        $article = $this->articleRepository->getArticleBySlug($slug);

        return view('front.article', compact('article'));
    }

    public function category(Categories $category): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $articles = $this->articleRepository->getActiveOrderByDateForCategory($this->nbrPages, $category->slug);
        $title = __('Articles for category ') . '<strong>' . $category->title . '</strong>';

        return view('front.index', compact('articles', 'title'));
    }

    public function user(User $user): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $articles = $this->articleRepository->getActiveOrderByDateForUser($this->nbrPages, $user->id);
        $title = __('Posts for author ') . '<strong>' . $user->name . '</strong>';
        return view('front.index', compact('articles', 'title'));
    }

    public function tag(Tag $tag): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $articles = $this->articleRepository->getActiveOrderByDateForTag($this->nbrPages, $tag->slug);
        $title = __('Articles for tag ') . '<strong>' . $tag->title . '</strong>';
        return view('front.index', compact('articles', 'title'));
    }

    //pour la recherche
    public function search(SearchRequest $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $search = $request->search;
        $articles = $this->articleRepository->search($this->nbrPages, $search);
        $title = __('Articles found with search: ') . '<strong>' . $search . '</strong>';
        return view('front.index', compact('articles', 'title'));
    }
}
