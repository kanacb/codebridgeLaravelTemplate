<?php

namespace App\Repositories;

use App\Interfaces\CommentRepositoryInterface;
use App\Models\Comment;
use App\Http\Resources\CommentResource;

class CommentRepository implements CommentRepositoryInterface
{
    public function getAllComments()
    {
        $comments = Comment::all();
        return CommentResource::collection($comments);
    }

    public function getCommentById($CommentId)
    {
        $comments = Comment::findOrFail($CommentId);
        return CommentResource::collection($comments);
    }

    public function deleteComment($CommentId)
    {
        Comment::destroy($CommentId);
    }

    public function createComment(array $CommentDetails)
    {
        return Comment::create($CommentDetails);
    }

    public function updateComment($CommentId, array $newDetails)
    {
        return Comment::whereId($CommentId)->update($newDetails);
    }
}
