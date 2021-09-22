<?php

namespace App\Model;

class Artwork extends Model{

    protected static function defaultSelect(Orm $orm): Orm{
        return $orm->select('artwork.id', 
                            'artwork.name', 
                            'artwork.slug',
                            'author.name AS author', 
                            'number_volume', 
                            'type', 
                            'GROUP_CONCAT(DISTINCT genre.name, \' \') AS genre', 
                            'artwork.image', 
                            'AVG(DISTINCT comment.note) AS note',
                            'artwork.release_date')
        ->groupBy('artwork.id');
    }

    protected static function from($orm): Orm{
        return $orm->from('artwork');
    }

    protected static function with($orm): Orm{
        return $orm
        ->with('author', 'author_id', 'author.id')
        ->with('artwork_genre', 'artwork.id', 'artwork_genre.artwork_id', 'LEFT')
        ->with('genre', 'artwork_genre.genre_id', 'genre.id', 'LEFT')
        ->with('comment', 'artwork.id', 'comment.artwork_id', 'LEFT');
    }

}