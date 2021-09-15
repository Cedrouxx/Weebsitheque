<?php
namespace App\Model;

class UserList extends Model{

    protected static function defaultSelect(Orm $orm): Orm{
        return $orm->select('artwork.id', 
                            'user_list_status.name AS status',
                            'user_list_status.id AS status_id',
                            'artwork.id', 
                            'artwork.name', 
                            'artwork.slug',
                            'author.name AS author', 
                            'number_volume', 
                            'type.name AS type', 
                            'genre.name AS genre', 
                            'artwork.image', 
                            'comment.note AS note');
    }

    protected static function from(Orm $orm): Orm{
        return $orm->from('user_list');
    }

    protected static function with(Orm $orm): Orm{
        return $orm
        ->with('user_list_status', 'user_list_status.id', 'user_list.user_list_status_id ')
        ->with('user', 'user.id', 'user_list.user_id ')
        ->with('artwork', 'user_list.artwork_id', 'artwork.id')
        ->with('author', 'artwork.author_id', 'author.id')
        ->with('type', 'artwork.type_id', 'type.id')
        ->with('artwork_genre', 'artwork.id', 'artwork_genre.artwork_id', 'LEFT')
        ->with('genre', 'artwork_genre.genre_id', 'genre.id', 'LEFT')
        ->with('comment', 'artwork.id', 'comment.artwork_id', 'LEFT');
    }

}