<?php

class Users extends AbstractController {

    private $userModel;

    public function __construct() {
        $this->userModel = $this->model('User');
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (empty(trim($_POST['username']))) {
                flash('flashName', 'Veuillez saisir un nom', 'alert alert-danger');
            }

            if (empty(trim($_POST['email']))) {
                flash('flashEmail', 'Veuillez saisir un email', 'alert alert-danger');
            } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                flash('flashEmail', 'Veuillez saisir un email valide', 'alert alert-danger');
            } else if ($this->userModel->findUserByEmail($_POST['email'])) {
                flash('flashEmail', 'Cet email est deja utilisé', 'alert alert-danger');
            }

            if (empty(trim($_POST['password']))) {
                flash('flashPassword', 'Veuillez saisir un mot de passe', 'alert alert-danger');
            }

            if (empty(trim($_POST['confirm_password']))) {
                flash('flashConfirm', 'Veuillez confirmer votre mot de passe', 'alert alert-danger');
            }

            if (trim($_POST['password']) !== trim($_POST['confirm_password'])) {
                flash('flashConfirm2', 'Les mots de passe ne correspondent pas', 'alert alert-danger');
            }

            if (empty($_SESSION['flashName']) && empty($_SESSION['flashEmail']) && empty($_SESSION['flashPassword']) && empty($_SESSION['flashConfirm']) && empty($_SESSION['flashConfirm2'])) {

                $username = htmlspecialchars($_POST['username']); 
                $email = htmlspecialchars($_POST['email']);
                $password = htmlspecialchars($_POST['password']);

                $passwordH = password_hash($password, PASSWORD_DEFAULT);               
                
                if ($this->userModel->register([
                    'nom' => $username,
                    'email' => $email,
                    'password' => $passwordH
                ])) {
                    redirect('users/login');
                } else {
                    flash('flashRegister', 'Une erreur est survenue lors de l\'inscription', 'alert alert-danger');
                }
            } else {
                $this->render('register', []);
            }                           
        } else {
            $this->render('register', []);
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (empty(trim($_POST['email']))){
                flash('flashEmail', 'Veuillez saisir un email', 'alert alert-danger');
            } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                flash('flashEmail', 'Veuillez saisir un email valide', 'alert alert-danger');
            } else if (!$this->userModel->findUserByEmail($_POST['email'])) {
                flash('flashEmail', 'Cet email n\'existe pas', 'alert alert-danger');
            }

            if (empty(trim($_POST['password']))) {
                flash('flashPassword', 'Veuillez saisir un mot de passe', 'alert alert-danger');
            }           
            $userExist = $this->userModel->findUser($_POST['email']);
            if (!empty($_POST['password']) && !password_verify(trim($_POST['password']), $userExist->password)) {
                flash('flashPassword2', 'Mot de passe incorrect', 'alert alert-danger');
            }
            
            if (empty($_SESSION['flashEmail']) && empty($_SESSION['flashPassword']) && empty($_SESSION['flashPassword2'])) {
                $_SESSION['user_email'] = $userExist->email;
                $_SESSION['user_id'] = $userExist->id;
                $_SESSION['username'] = $userExist->nom;
                redirect('posts/index');
            } else {
                redirect('users/login');
            }
        } else {    
            $this->render('login', []);
        }
    }

    public function logout() {
        session_destroy();
        redirect('users/login');
    }
        
}