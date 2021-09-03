<?php

namespace App\Model;

use App\Core\Str;

class Artwork extends Model{

    public function getAllArtwork(): array{
        return $this->select(   'artwork.id', 
                                'artwork.name', 
                                'artwork.slug',
                                'author.name AS author', 
                                'number_volume', 
                                'type.name AS type', 
                                'genre.name AS genre', 
                                'artwork.image', 
                                'comment.note AS note')
        ->from('artwork')
        ->with('author', 'author_id', 'author.id')
        ->with('type', 'type_id', 'type.id')
        ->with('artwork_genre', 'artwork.id', 'artwork_genre.artwork_id')
        ->with('genre', 'artwork_genre.genre_id', 'genre.id')
        ->with('comment', 'artwork.id', 'comment.artwork_id', 'LEFT')
        ->getAll();
    }

    public function getAllAnime(): array{
        return $this->select(   'artwork.id', 
                                'artwork.name', 
                                'artwork.slug',
                                'author.name AS author', 
                                'number_volume', 
                                'type.name AS type', 
                                'genre.name AS genre', 
                                'artwork.image', 
                                'comment.note AS note')
        ->from('artwork')
        ->with('author', 'author_id', 'author.id')
        ->with('type', 'type_id', 'type.id')
        ->with('artwork_genre', 'artwork.id', 'artwork_genre.artwork_id')
        ->with('genre', 'artwork_genre.genre_id', 'genre.id')
        ->with('comment', 'artwork.id', 'comment.artwork_id', 'LEFT')
        ->where('type.name', 'Anime')
        ->getAll();
    }

    public function getAllManga(): array{
        return $this->select(   'artwork.id',
                                'artwork.name', 
                                'artwork.slug',
                                'author.name AS author', 
                                'number_volume', 
                                'type.name AS type', 
                                'genre.name AS genre', 
                                'artwork.image', 
                                'comment.note AS note')
        ->from('artwork')
        ->with('author', 'author_id', 'author.id')
        ->with('type', 'type_id', 'type.id')
        ->with('artwork_genre', 'artwork.id', 'artwork_genre.artwork_id', 'LEFT')
        ->with('genre', 'artwork_genre.genre_id', 'genre.id', 'LEFT')
        ->with('comment', 'artwork.id', 'comment.artwork_id', 'LEFT')
        ->where('type.name', 'Manga')
        ->getAll();
    }

    public function getOneArtworkBySlug(string $slug): ModelOutput{
        return $this->select(   'artwork.id', 
                                'artwork.name', 
                                'artwork.slug',
                                'author.name AS author', 
                                'number_volume', 
                                'type.name AS type', 
                                'genre.name AS genre', 
                                'artwork.image', 
                                'comment.note AS note')
        ->from('artwork')
        ->with('author', 'author_id', 'author.id')
        ->with('type', 'type_id', 'type.id')
        ->with('artwork_genre', 'artwork.id', 'artwork_genre.artwork_id', 'LEFT')
        ->with('genre', 'artwork_genre.genre_id', 'genre.id', 'LEFT')
        ->with('comment', 'artwork.id', 'comment.artwork_id', 'LEFT')
        ->where('artwork.slug', $slug)
        ->getOne();
    }

    public function getOneArtworkById(int $id): ModelOutput{
        return $this->select(   'artwork.id', 
                                'artwork.name', 
                                'artwork.slug',
                                'author.name AS author', 
                                'number_volume', 
                                'type.name AS type', 
                                'genre.name AS genre', 
                                'artwork.image', 
                                'comment.note AS note')
        ->with('author', 'author_id', 'author.id')
        ->with('type', 'type_id', 'type.id')
        ->with('artwork_genre', 'artwork.id', 'artwork_genre.artwork_id', 'LEFT')
        ->with('genre', 'artwork_genre.genre_id', 'genre.id', 'LEFT')
        ->with('comment', 'artwork.id', 'comment.artwork_id', 'LEFT')
        ->from('artwork')
        ->where('artwork.id', $id)
        ->getOne();
    }

    public function getOneArtworkIdByName(string $name): ModelOutput{
        return $this->select('id')
        ->from('artwork')
        ->where('name', $name)
        ->getOne();
    }

    public function insertOneArtwork(string $name, int $authorId, int $numberVolume, int $typeId, string $image) :void{
        $slug = Str::slug($name);
        
        $this->from('artwork')->values([
            'name' => $name,
            'slug' => $slug,
            'author_id' => $authorId,
            'number_volume' => $numberVolume,
            'type_id' => $typeId,
            'image' => $image
        ])->insert();
    }

    public function AddGenre(int $artworkId, int $genreId) :void{
        $this->from('artwork_genre')->values([
            'artwork_id' => $artworkId,
            'genre_id' => $genreId
        ])->insert();
    }


}