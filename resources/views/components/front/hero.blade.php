@props(['article'])

<div class="s-hero__slide">

    <div class="s-hero__slide-bg" style="background-image: url({{ asset('storage/files/'.$article->id.'/'.$article->images) }})"></div>
{{--    <img src="{{ @url('storage/files/'. $article->user->id.'/'.$article->image) }}">--}}
    <div class="row s-hero__slide-content animate-this">
        <div class="column">
            <div class="s-hero__slide-meta">
              <span class="cat-links">
                  @foreach($article->categories as $category)
                      <a href="#">{{ $category->title }}</a>
                  @endforeach
              </span>
                <span class="byline">
                  @lang('Posted By')
                  <span class="author">
                      <a href="#">{{ $article->user->name }}</a>
                  </span>
              </span>
            </div>
            <h1 class="s-hero__slide-text">
                <a href="#">{{ $article->title }}</a>
            </h1>
        </div>
    </div>

</div>
