<?php

use App\helpers\Flasher as Flasher;
use App\helpers\Validator as Validator;
use App\helpers\Request as Request;
use App\helpers\Handler as Handler;

class ProfilController extends Controller {

    public function index($param = null){
        if (empty($param)) {
            header('Location: ' . BASEURL . 'class');
            exit;
        }
    }

    // ud (user detail)
    public function ud($param = null)
    {
        // check if param wasn't set
        if (empty($param)) {
            header('Location: ' . BASEURL . 'class');
            exit;
        }

        // authorization
        if ($_SESSION['role'] === 'siswa') {
            $data['class'] = $this->model('Class_model')->getUserClass($_SESSION['user_id']);
        } elseif ($_SESSION['role'] === 'guru') {
            $data['class'] = $this->model('Class_model')->getTeacherClass($_SESSION['user_id']);
        }

        $data['style'] = 'account';
        $data['title'] = 'Profil';
        $data['topbar'] = 1;

        $param = explode('-', $param);
        $user_id = $param[0];

        // get user by id from param
        $data['user'] = $this->model('User_model')->getUserById($_SESSION['user_id']);
        $data['profil'] = $this->model('User_model')->getUserProfile($user_id);

        if ($data['profil']) {
            // return view
            $this->view('partials/elearn-header', $data);
            $this->view('partials/topbar', $data);
            $this->view('partials/sidebar', $data);
            $this->view('userprofil/index', $data);
        } else {
            header('Location: ' . BASEURL . 'class');
            exit();
        }
    }

    // ep (edit profil)
    public function ep()
    {
        // HTTP request method check
        Request::requestMethod();
        
        $files = new Handler();

        $old_pic = $_POST['old_pic'];

        //cek apakah gambar diupdate
        if ( $_FILES['profpic']['error'] === 4 ) {
            $_POST['profpic'] = $old_pic;
        }
        else{
            $_POST['profpic'] = $files->profpic($_FILES['profpic']);
        }

        $editProfil = $this->model('User_model')->editProfil($_POST);
        if ($editProfil) {
            Flasher::setFlash('success', 'Edit profil success!');
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            Flasher::setFlash('error', 'Edit profil failed!');
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }

    // ucp (user change password)
    public function ucp()
    {
        // HTTP request method check
        Request::requestMethod();

        $old_pass = $_POST['old_pass'];
        $new_pass = $_POST['new_pass'];
        $confirm_pass = $_POST['confirm_pass'];
        $user_id = $_POST['user_id'];
        
        // Retrieve the hashed password from the database based on the user's email
        $user = $this->model('User_model')->getUserById($user_id);
        $hashed_password = $user['password'];

        if ($confirm_pass === $new_pass) {
            // Verify that the entered old password matches the old password
            if(password_verify($old_pass, $hashed_password)) {
                // change password query
                $ucp = $this->model('User_model')->changeUserPassword($user_id, $new_pass);

                if ($ucp) {
                    Flasher::setFlash('success', 'Change password success!');
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                    exit();
                }
            } else {
                // failed
                Flasher::setFlash('error', 'Wrong password');
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit();
            }
        } else {
            // failed
            Flasher::setFlash('error', 'Password confirm didnt match!');
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

    }
}