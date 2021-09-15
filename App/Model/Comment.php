<?php

namespace App\Model;

class Comment extends Model{

    protected static function defaultSelect(Orm $orm): Orm{
        return $orm->select('comment.id', 'user.username AS user', 'comment.note', 'comment.content');
    }

    protected static function from(Orm $orm): Orm{
        return $orm->from('comment');
    }

    protected static function with(Orm $orm): Orm{
        return $orm
        ->with('user', 'user_id', 'user.id');
    }

    // public function getAllCommentByArtworkId($artworkId): array{
    //     return $this->select('comment.id', 'user.username AS user', 'comment.note', 'comment.content')
    //     ->from('comment')
    //     ->orderBy('comment.created_at DESC')
    //     ->with('user', 'user_id', 'user.id')
    //     ->where('comment.artwork_id', $artworkId)
    //     ->getAll();
    // }

    // public function insertOneComment(int $userId, int $artworkId, int $note, string $content) :void{
        
    //     $this->from('comment')->values([
    //         'user_id' => $userId,
    //         'artwork_id' => $artworkId,
    //         'note' => $note,
    //         'content' => $content,
    //     ])->insert();
    // }

}