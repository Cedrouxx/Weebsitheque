<?php

namespace App\Model;

use App\Core\Str;

class Artwork extends Model{

    // DEFAULT ARTWORK
        // GET ALL
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

        // GET ONE
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

        // INSERT
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

        // OTHER
    public function AddGenre(int $artworkId, int $genreId) :void{
        $this->from('artwork_genre')->values([
            'artwork_id' => $artworkId,
            'genre_id' => $genreId
        ])->insert();
    }

    // USER LIST
        // GET ALL
    public function getAllArtworkInUserList(int $userId): array{
        return $this->select(   'artwork.id',
                                'artwork.name', 
                                'artwork.slug',
                                'author.name AS author', 
                                'number_volume', 
                                'type.name AS type', 
                                'genre.name AS genre', 
                                'artwork.image', 
                                'comment.note AS note',
                                'user_list_status.name AS status',
                                'user_list.user_list_status_id AS status_id')
        ->from('user_list')
        ->with('user_list_status', 'user_list_status.id', 'user_list.user_list_status_id ')
        ->with('artwork', 'user_list.artwork_id', 'artwork.id')
        ->with('author', 'author_id', 'author.id')
        ->with('type', 'type_id', 'type.id')
        ->with('artwork_genre', 'artwork.id', 'artwork_genre.artwork_id', 'LEFT')
        ->with('genre', 'artwork_genre.genre_id', 'genre.id', 'LEFT')
        ->with('comment', 'artwork.id', 'comment.artwork_id', 'LEFT')
        ->where('user_list.user_id', $userId)
        ->getAll();
    }

    public function getAllAnimeInUserList(int $userId): array{
        return $this->select(   'artwork.id',
                                'artwork.name', 
                                'artwork.slug',
                                'author.name AS author', 
                                'number_volume', 
                                'type.name AS type', 
                                'genre.name AS genre', 
                                'artwork.image', 
                                'comment.note AS note',
                                'user_list_status.name AS status',
                                'user_list.user_list_status_id AS status_id')
        ->from('user_list')
        ->with('user_list_status', 'user_list_status.id', 'user_list.user_list_status_id ')
        ->with('artwork', 'user_list.artwork_id', 'artwork.id')
        ->with('author', 'author_id', 'author.id')
        ->with('type', 'type_id', 'type.id')
        ->with('artwork_genre', 'artwork.id', 'artwork_genre.artwork_id', 'LEFT')
        ->with('genre', 'artwork_genre.genre_id', 'genre.id', 'LEFT')
        ->with('comment', 'artwork.id', 'comment.artwork_id', 'LEFT')
        ->where('user_list.user_id', $userId)
        ->where('type.name', 'anime')
        ->getAll();
    }

    public function getAllMangaInUserList(int $userId): array{
        return $this->select(   'artwork.id',
                                'artwork.name', 
                                'artwork.slug',
                                'author.name AS author', 
                                'number_volume', 
                                'type.name AS type', 
                                'genre.name AS genre', 
                                'artwork.image', 
                                'comment.note AS note',
                                'user_list_status.name AS status',
                                'user_list.user_list_status_id AS status_id')
        ->from('user_list')
        ->with('user_list_status', 'user_list_status.id', 'user_list.user_list_status_id ')
        ->with('artwork', 'user_list.artwork_id', 'artwork.id')
        ->with('author', 'author_id', 'author.id')
        ->with('type', 'type_id', 'type.id')
        ->with('artwork_genre', 'artwork.id', 'artwork_genre.artwork_id', 'LEFT')
        ->with('genre', 'artwork_genre.genre_id', 'genre.id', 'LEFT')
        ->with('comment', 'artwork.id', 'comment.artwork_id', 'LEFT')
        ->where('user_list.user_id', $userId)
        ->where('type.name', 'manga')
        ->getAll();
    }

    public function getAllArtworkStatusInUserList(int $userId): array{
        return $this->select(   'artwork.id', 'user_list_status.name AS status')
        ->from('user_list')
        ->with('user_list_status', 'user_list_status.id', 'user_list.user_list_status_id ')
        ->with('artwork', 'user_list.artwork_id', 'artwork.id')
        ->where('user_list.user_id', $userId)
        ->getAll();
    }

        //GET ONE
    public function getOneArtworkInUserListByArtworkId(int $userId, int $artworkId): ModelOutput{
        return $this->from('user_list')
        ->where('user_id', $userId)
        ->where('artwork_id', $artworkId)
        ->getOne();
    }

        //REMOVE 
    public function removeOneArtworkInUserList(int $userId, int $artworkId): void{
        $this->from('user_list')
        ->where('user_id', $userId)
        ->where('artwork_id', $artworkId)
        ->delete();
    }
        // INSERT
    public function insertOneArtworkInUserList(int $userId, int $artworkId): void{
        $this->from('user_list')->values([
            'user_id' => $userId,
            'artwork_id' => $artworkId
        ])->insert();
    }

        // update
    public function updateOneArtworkStatus(int $userId, int $artworkId, int $statusId){
        $this->from('user_list')
        ->values([ 'user_list_status_id' => $statusId ])
        ->where('user_id' ,$userId)
        ->where('artwork_id', $artworkId)
        ->update();
    }


}