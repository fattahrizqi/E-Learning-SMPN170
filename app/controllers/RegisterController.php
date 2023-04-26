<?php

use App\helpers\Flasher as Flasher;
use App\helpers\Validator as Validator;

class RegisterController extends Controller{

    public function index()
    {
        $data['style'] = 'signin';
        $data['title'] = 'Register';

        $this->view('partials/header', $data);
        $this->view('register/index');

        unset($_SESSION['errors']);
        unset($_SESSION['old']);
    }

    public function store()
    {
        
        $validator = new Validator();
        $errors = $validator->registerValidate($_POST);

        if (count($errors) > 0) {
            // Jika terdapat error, kembalikan ke halaman kontak dengan pesan error
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            header('Location: ' . BASEURL . 'register');
            exit;
        }
        unset($_SESSION['errors']);
        unset($_SESSION['old']);
        
        $existing_user = $this->model('User_model')->getUserByEmail($_POST['email']);

        if ($existing_user) {
            Flasher::setFlash('error', 'An account with that email address already exists.');
            header('Location: ' . BASEURL . 'register');
            exit;
        } else {
            $user_id = $this->model('User_model')->createUser($_POST);
            if ($user_id) {
                Flasher::setFlash('success', 'Register successful! now sign in your account');
                header('Location: ' . BASEURL . 'login');
                exit();
            } else {
                Flasher::setFlash('error', 'There was an error creating your account.');
                header('Location: ' . BASEURL . 'register');
                exit;
            }
        }

    }

}