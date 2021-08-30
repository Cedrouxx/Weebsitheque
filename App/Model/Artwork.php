<?php

namespace App\Model;

class Artwork extends Model{

    public function getAllArtwork(): array{
        return $this->select('artwork.id', 'artwork.name', 'author.name AS author', 'original_artwork', 'number_volume', 'type.name AS type', 'genre.name AS genre')
        ->from('artwork')
        ->with('author', 'author_id', 'author.id')
        ->with('type', 'type_id', 'type.id')
        ->with('artwork_genre', 'artwork.id', 'artwork_genre.artwork_id')
        ->with('genre', 'artwork_genre.genre_id', 'genre.id')
        ->getAll();
    }

    public function getAllAnime(): array{
        return $this->select('artwork.id', 'artwork.name', 'author.name AS author', 'original_artwork', 'number_volume', 'type.name AS type', 'genre.name AS genre')
        ->from('artwork')
        ->with('author', 'author_id', 'author.id')
        ->with('type', 'type_id', 'type.id')
        ->with('artwork_genre', 'artwork.id', 'artwork_genre.artwork_id')
        ->with('genre', 'artwork_genre.genre_id', 'genre.id')
        ->where('type.name', 'Anime')
        ->getAll();
    }

    public function getAllManga(): array{
        return $this->select('artwork.id', 'artwork.name', 'author.name AS author', 'original_artwork', 'number_volume', 'type.name AS type', 'genre.name AS genre')
        ->from('artwork')
        ->with('author', 'author_id', 'author.id')
        ->with('type', 'type_id', 'type.id')
        ->with('artwork_genre', 'artwork.id', 'artwork_genre.artwork_id')
        ->with('genre', 'artwork_genre.genre_id', 'genre.id')
        ->where('type.name', 'Manga')
        ->getAll();
    }

}