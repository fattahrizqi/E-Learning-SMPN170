<?php

use App\helpers\Flasher as Flasher;
use App\middlewares\AuthMiddleware as Auth;

class LoginController extends Controller {
    
    public function __construct()
    {
        Auth::guest();
    }

    public function index()
    {
        $data['style'] = 'login';
        $data['title'] = 'Login';

        $this->view('partials/header', $data);
        $this->view('login/index');
    }

    public function authenticate()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        // Retrieve the hashed password from the database based on the user's email
        $user = $this->model('User_model')->getUserByEmail($email);
        $hashed_password = $user['password'];
    
        // Verify that the entered password matches the hashed password
        if(password_verify($password, $hashed_password)) {
            // Login successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            Flasher::setFlash('success', 'Welcome back, ' . $user['name']);
            header('Location: ' . BASEURL . 'class');
            exit();
        } else {
            // Login failed
            Flasher::setFlash('error', 'Login failed!');
            header('Location: ' . BASEURL . 'login');
            exit();
        }
    }

    // Logout action
    public function logout()
    {
        // Destroy the user session
        session_start();
        session_unset();
        session_destroy();

        // Redirect the user to the login page
        header('Location: ' . BASEURL . 'login');
        exit();
    }


}