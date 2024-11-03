<?php

namespace App\Interfaces;

interface CommentRepositoryInterface
{
    public function getAllComments();
    public function getCommentById($commentId);
    public function deleteComment($commentId);
    public function createComment(array $commentDetails);
    public function updateComment($commentId, array $newDetails);
}
