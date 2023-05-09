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

    public function ud($param = null)
    {
        if (empty($param)) {
            header('Location: ' . BASEURL . 'class');
            exit;
        }

        $data['style'] = 'account';
        $data['title'] = 'Profil';
        $data['topbar'] = 1;

        $param = explode('-', $param);
        $user_id = $param[0];

        $data['user'] = $this->model('User_model')->getUserById($_SESSION['user_id']);
        $data['profil'] = $this->model('User_model')->getUserProfile($user_id);

        $this->view('partials/elearn-header', $data);
        $this->view('partials/topbar', $data);
        $this->view('partials/sidebar', $data);
        $this->view('userprofil/index', $data);
    }

    public function ue()
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
}