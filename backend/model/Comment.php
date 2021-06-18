<?php


class Comment
{
    private int $id, $author_id, $user_id, $score;
    private string $comment;
    private DB $db;

    public function __construct( $id, $author_id, $user_id, $score, $comment)
    {
        $this->db = new DB();
        $this->id = $id;
        $this->author_id = $author_id;
        $this->user_id = $user_id;
        $this->score = $score;
        $this->comment = $comment;

    }

    public function save()
    {
        $this->db->saveComment($this->author_id, $this->user_id, $this->score, $this->comment);
    }
}
