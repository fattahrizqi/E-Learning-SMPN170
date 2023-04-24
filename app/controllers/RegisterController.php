<?php

class RegisterController extends Controller{

    public function index()
    {
        $data['style'] = 'signin';
        $data['title'] = 'Register';

        $this->view('partials/header', $data);
        $this->view('register/index');
    }

}