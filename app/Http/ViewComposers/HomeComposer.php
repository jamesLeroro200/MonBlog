<?php


namespace App\Http\ViewComposers;

use App\Models\Article;
use App\Models\Categories;
use Illuminate\View\View;

class HomeComposer
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'categories' => Categories::has('articles')->get(),
        ]);
    }
}

