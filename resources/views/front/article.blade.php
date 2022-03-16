@extends('front.layout')

@section('main')

    <!-- post
================================================== -->
    <div class="row">
        <div class="column large-12">

            <article class="s-content__entry format-standard">

                <div class="s-content__media">
                    <div class="s-content__post-thumb">
                        <img src="{{ getImage($article) }}" alt="" style="width:100%">
                    </div>
                </div>

                <div class="s-content__entry-header">
                    <h1 class="s-content__title s-content__title--post">{{ $article->title }}</h1>
                </div>

                <div class="s-content__primary">

                    <div class="s-content__entry-content">

                        {!! $article->body !!}

                    </div>

                    <div class="s-content__entry-meta">

                        <div class="entry-author meta-blk">
                            <div class="author-avatar">
                                <img class="avatar" src="{{ \Creativeorange\Gravatar\Facades\Gravatar::get($article->user->email) }}" alt="">
                            </div>
                            <div class="byline">
                                <span class="bytext">@lang('Posted By')</span>
                                <a href="{{ route('author', $article->user->id) }}">{{ $article->user->name }}</a>
                            </div>
                        </div>

                        <div class="meta-bottom">

                            <div class="entry-cat-links meta-blk">
                                <div class="cat-links">
                                    <span>@lang('In')</span>
                                    @foreach ($article->categories as $category)
                                        <a href="{{ route('category', $category->slug) }}">{{ $category->title }}</a>
                                    @endforeach
                                </div>

                                <span>@lang('On')</span>
                                {{ formatDate($article->created_at) }}
                            </div>

                            <div class="entry-tags meta-blk">
                                <span class="tagtext">@lang('Tags')</span>
                                @foreach($article->tags as $tag)
                                    <a href="{{ route('tag', $tag->slug) }}">{{ $tag->title }}</a>
                                @endforeach
                            </div>

                        </div>

                    </div>

                    <div class="s-content__pagenav">
                        @isset($article->previous)
                            <div class="prev-nav">
                                <a href="{{ route('articles.display', $article->previous->slug) }}" rel="prev">
                                    <span>@lang('Previous')</span>
                                    {{ $article->previous->title }}
                                </a>
                            </div>
                        @endisset
                        @isset($article->next)
                            <div class="next-nav">
                                <a href="{{ route('articles.display', $article->next->slug) }}" rel="next">
                                    <span>@lang('Next One')</span>
                                    {{ $article->next->title }}
                                </a>
                            </div>
                        @endisset
                    </div>

                </div>
            </article>

        </div>
    </div>

@endsection