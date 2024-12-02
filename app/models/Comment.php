<?php

class Comment {

    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function addComment($data) {
        $this->db->query('INSERT INTO comments (comment, id_post, id_user) VALUES (:comment, :id_post, :id_user)');
        $this->db->bind(':comment', $data['comment']);
        $this->db->bind(':id_post', $data['id_post']);
        $this->db->bind(':id_user', $data['id_user']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getCommentsByPost($id) {
        $this->db->query('SELECT comments.*, users.nom as userNom
        FROM comments
        JOIN users
        ON comments.id_user = users.id
        WHERE comments.id_post = :id_post
        ORDER BY comments.date DESC');
        $this->db->bind(':id_post', $id);
        return $this->db->findAll();
    }
}