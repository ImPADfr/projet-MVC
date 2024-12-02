<?php  

class Post {

    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getPosts() {
        $this->db->query('SELECT *, posts.id as postId 
        FROM posts 
        JOIN users 
        ON posts.id_user = users.id 
        ORDER BY posts.dateCreated DESC');
        return $this->db->findAll();
    }

    public function getPostById($id) {
        $this->db->query('SELECT posts.*, users.nom as userNom 
        FROM posts
        JOIN users
        ON posts.id_user = users.id 
        WHERE posts.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->findOne();
    }

    public function addPost($data) {
        $this->db->query('INSERT INTO posts (title, content, id_user) VALUES (:title, :content, :id_user)');
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':id_user', $data['user_id']);
        if ($this->db->execute()) {
            return true;
        } else {            
            return false;
        }
    }

    public function deletePost($id) {
        $this->db->query('DELETE FROM posts WHERE id = :id');
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function modifPost($dataToUpdate) {
        $clauseSet= [];
        $parameters = [];
        foreach ($dataToUpdate as $key => $value) {
            if ($key !== 'id') {
            $clauseSet[] = "$key = :$key";
            $parameters[":$key"] = $value;
            } else {
                $parameters[":id"] = $value;
            }
        }
        $sql = "UPDATE posts SET " . implode(',', $clauseSet) . " WHERE id = :id";
        $this->db->query($sql);
        foreach ($parameters as $key => $value) {
            $this->db->bind($key, $value);
        }
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function searchPost($data) {

        $this->db->query('SELECT posts.*, users.nom as userNom 
        FROM posts
        JOIN users
        ON posts.id_user = users.id 
        WHERE posts.title
        LIKE :search
        OR posts.content 
        LIKE :search');
        $this->db->bind(':search', '%' . $data['search'] . '%');
        return $this->db->findAll();
        
    }
}