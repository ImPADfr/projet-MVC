<?php

class Posts extends AbstractController {

    private $postModel;
    private $commentModel;

    public function __construct() {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        $this->postModel = $this->model('Post');
        $this->commentModel = $this->model('Comment');
    }

    public function index() {
        $post = $this->postModel->getPosts();

        $data = [
            'title' => 'Posts page',
            'posts' => $post
        ];

        $this->render('index', $data);
    }

    public function details($id) {
        
            $post = $this->postModel->getPostById($id);
            $comment = $this->commentModel->getCommentsByPost($id);

            // if (!$post) {               
            //     header('Location: ' . URLROOT . '/posts');
            //     exit;
            // }

            $data = [
                'title' => 'Details',
                'posts' => $post,
                'comments' => $comment
            ];

            $this->render('details', $data);
        
    }

    public function addPost() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            
            $data = [
                'title' => trim(htmlspecialchars($_POST['title'])),
                'content' => trim(htmlspecialchars($_POST['content'])),
                'user_id' => $_SESSION['user_id']
            ];
            
            if (empty($data['title'])) {
                flash('flashTitle', 'Veuillez saisir un titre', 'alert alert-danger');
            } 
            if (empty($data['content'])) {
                flash('flashContent', 'Veuillez saisir un contenu', 'alert alert-danger');
            }

            if (empty($_SESSION['flashTitle']) && empty($_SESSION['flashContent'])) {
                if ($this->postModel->addPost($data)) {
                    flash('flashAdd', 'Votre post a bien été ajouté', 'alert alert-success');
                    redirect('posts/index');
                } else {
                    flash('flashFailure', 'Votre post n\'a pas pu être ajouté', 'alert alert-danger');
                    redirect('posts/addPost');
                }
            } else {
            redirect('posts/addPost');
            }
        } else {           
        $data = [];
        $this->render('addPost', []);
        }
    }

    function deletePost($id) {
        if ($post->id_user != $_SESSION['user_id']) {
                redirect('posts/index');
            } else {
            if ($this->postModel->deletePost($id)) {
                redirect('posts/index');
                flash('flashDelete', 'Votre post a bien été supprimé', 'alert alert-danger');
            } else {
                redirect('posts/index');
                flash('flashFailure', 'Votre post n\'a pas pu être supprimé', 'alert alert-danger');
            }
        }

    }

    function modifPost($id) { 
        $post = $this->postModel->getPostById($id);

        if ($post->id_user != $_SESSION['user_id']) {
            redirect('posts/index');
        } else {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
                $data = [
                    'id' => $id,
                    'title' => trim(htmlspecialchars($_POST['title'])),
                    'content' => trim(htmlspecialchars($_POST['content']))
                ];
                if ($post) {
                    redirect('posts/index');
                }
                if (empty($data['title'])) {
                    flash('flashTitle', 'Veuillez saisir un titre', 'alert alert-danger');
                }
                if (empty($data['content'])) {
                    flash('flashContent', 'Veuillez saisir un contenu', 'alert alert-danger');
                }
            
                if (empty($_SESSION['flashTitle']) && empty($_SESSION['flashContent'])) {
                    $dataToUpdate['id'] = $id;
                    if ($data['title'] != $post->title) {
                        $dataToUpdate['title'] = $data['title'];
                    }
                    if ($data['content'] != $post->content) {
                        $dataToUpdate['content'] = $data['content'];
                    }
                    if ($this->postModel->modifPost($dataToUpdate)) {
                        flash('flashAdd', 'Votre post a bien été modifié', 'alert alert-success');
                        redirect('posts/index');
                    } else {
                        flash('flashFailure', 'Votre post n\'a pas pu être modifié', 'alert alert-danger');
                        redirect('posts/modifPost/'.$id);
                    }
                } else {
                    redirect('posts/modifPost/'.$id);
                }
            } else {
                $data = [
                    'title' => 'Modifier le post',
                    'posts' => $post,
                ];
            $this->render('modifPost', $data);
            }
        }
    }

    public function addComment($id) {
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'comment' => trim(htmlspecialchars($_POST['body'])),
                'id_post' => $id,
                'id_user' => $_SESSION['user_id']
            ];
            if (empty($data['comment'])) {
                flash('flashCommentFailure', 'Veuillez saisir un commentaire', 'alert alert-danger');
                redirect('posts/details/'.$id);
            } else {               
                if (empty($_SESSION['flashComment'])) {
                    if ($this->commentModel->addComment($data)) {
                        flash('flashComment', 'Votre commentaire a bien été ajouté', 'alert alert-success');
                        redirect('posts/details/'.$id);
                    } else {
                        flash('flashComment', 'Erreur lors de l\'ajout du commentaire', 'alert alert-danger');
                        redirect('posts/details/'.$id);
                    }
                }
            }
        } else {
            redirect('posts/details/'.$id);
        }

    }

    public function searchPost() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'search' => trim(htmlspecialchars($_POST['search']))
            ];

            if (empty($data['search'])) {
                flash('flashSearch', 'Veuillez saisir un mot clef', 'alert alert-danger');
                redirect('posts/searchPost');
            } else {
                $searchResult = $this->postModel->searchPost($data);

                if (!empty($searchResult)) {
                    $data = [
                        'search' => $searchResult
                    ];
                    $this->render('searchPost', $data);
                } else {
                    flash('flashSearch', 'Aucun résultat à votre recherche', 'alert alert-danger');
                    redirect('posts/searchPost');
                }
            }
        } else {
            $this->render('searchPost', []);
        }
    }
}