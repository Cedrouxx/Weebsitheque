<?php
namespace App\Model;

class UserList extends Model{

    protected static function defaultSelect(Orm $orm): Orm{
        return $orm->select('artwork.id', 
                            'status AS status',
                            'artwork.id', 
                            'artwork.name', 
                            'artwork.slug',
                            'author.name AS author', 
                            'number_volume', 
                            'type', 
                            'GROUP_CONCAT(DISTINCT genre.name, \' \') AS genre', 
                            'artwork.image', 
                            'AVG(DISTINCT comment.note) AS note')
        ->groupBy('artwork.id');
    }

    protected static function from(Orm $orm): Orm{
        return $orm->from('user_list');
    }

    protected static function with(Orm $orm): Orm{
        return $orm
        ->with('user', 'user.id', 'user_list.user_id ')
        ->with('artwork', 'user_list.artwork_id', 'artwork.id')
        ->with('author', 'artwork.author_id', 'author.id')
        ->with('artwork_genre', 'artwork.id', 'artwork_genre.artwork_id', 'LEFT')
        ->with('genre', 'artwork_genre.genre_id', 'genre.id', 'LEFT')
        ->with('comment', 'artwork.id', 'comment.artwork_id', 'LEFT');
    }

}