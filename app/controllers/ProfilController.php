<?php

class ProfilController extends Controller {
    public function index($param = null)
    {
        $data['style'] = 'account';
        $data['title'] = 'Profil';
        $data['topbar'] = 1;

        $data['user'] = $this->model('User_model')->getUserById($_SESSION['user_id']);

        $this->view('partials/elearn-header', $data);
        $this->view('partials/topbar', $data);
        $this->view('partials/sidebar', $data);
        $this->view('userprofil/index', $data);
    }
}