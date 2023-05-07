<?php

class HomeController extends Controller {
    public function index()
    {
        $data['style'] = 'homepage';
        $data['title'] = 'Home';

        $this->view('partials/header', $data);
        $this->view('home');
        $this->view('partials/footerHome');
    }
}