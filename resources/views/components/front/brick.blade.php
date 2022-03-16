@props(['article'])

<article class="brick entry" data-aos="fade-up">

    <div class="entry__thumb">
        <a href="{{ route('articles.display', $article->slug) }}" class="thumb-link">
            <img src="{{ getImage($article, true) }}" alt="" style="width:100%">
        </a>
    </div>

    <div class="entry__text">
        <div class="entry__header">
            <h1 class="entry__title"><a href="{{ route('articles.display', $article->slug) }}">{{ $article->title }}</a></h1>
            <div class="entry__meta">
                <span class="byline">@lang('By:')
                <span class='author'>
                      <a href="{{ route('author', $article->user->id) }}">{{ $article->user->name }}</a>
                  </span>
                </span>
            </div>
        </div>
        <div class="entry__excerpt">
            <p>{{ $article->sumary }}</p>
        </div>
        <a class="entry__more-link" href="{{ route('articles.display', $article->slug) }}">@lang('Read More')</a>
    </div>

</article>
