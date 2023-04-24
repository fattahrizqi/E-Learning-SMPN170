<?php

class AboutController extends Controller {
    public function index()
    {
        $data['style'] = 'profil';
        $data['title'] = 'Profil';

        $this->view('partials/header', $data);
        $this->view('about');
        $this->view('partials/footer');
    }
}