<?php

if (!function_exists('getImage')) {
    function getImage($article, $thumb = false): string
    {
        $url = "storage/files/{$article->user->id}";
        if($thumb) $url .= '/thumbs';
        return asset("{$url}/{$article->images}");
    }
}

if (!function_exists('currentRoute')) {
    function currentRoute($route): string
    {
        return Route::currentRouteNamed($route) ? ' class=current' : '';
    }
}

if (!function_exists('formatDate')) {
    function formatDate($date): string
    {
        return ucfirst(utf8_encode ($date->formatLocalized('%d %B %Y')));
    }
}
