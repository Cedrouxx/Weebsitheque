<?php

namespace App\Model;

class Artwork extends Model{

    public function getAllArtwork(): array{
        return $this->select('artwork.id', 'artwork.name', 'author.name AS author', 'number_volume', 'type.name AS type', 'genre.name AS genre', 'artwork.image')
        ->from('artwork')
        ->with('author', 'author_id', 'author.id')
        ->with('type', 'type_id', 'type.id')
        ->with('artwork_genre', 'artwork.id', 'artwork_genre.artwork_id')
        ->with('genre', 'artwork_genre.genre_id', 'genre.id')
        ->getAll();
    }

    public function getAllAnime(): array{
        return $this->select('artwork.id', 'artwork.name', 'author.name AS author', 'number_volume', 'type.name AS type', 'genre.name AS genre', 'artwork.image')
        ->from('artwork')
        ->with('author', 'author_id', 'author.id')
        ->with('type', 'type_id', 'type.id')
        ->with('artwork_genre', 'artwork.id', 'artwork_genre.artwork_id')
        ->with('genre', 'artwork_genre.genre_id', 'genre.id')
        ->where('type.name', 'Anime')
        ->getAll();
    }

    public function getAllManga(): array{
        return $this->select('artwork.id', 'artwork.name', 'author.name AS author', 'number_volume', 'type.name AS type', 'genre.name AS genre', 'artwork.image')
        ->from('artwork')
        ->with('author', 'author_id', 'author.id')
        ->with('type', 'type_id', 'type.id')
        ->with('artwork_genre', 'artwork.id', 'artwork_genre.artwork_id')
        ->with('genre', 'artwork_genre.genre_id', 'genre.id')
        ->where('type.name', 'Manga')
        ->getAll();
    }

    public function getOneArtworkIdByName(string $name): ModelOutput{
        return $this->select('id')
        ->from('artwork')
        ->where('name', $name)
        ->getOne();
    }

    public function insertOneArtwork(string $name, int $authorId, int $numberVolume, int $typeId, string $image) :void{
        $this->from('artwork')->values([
            'name' => $name,
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