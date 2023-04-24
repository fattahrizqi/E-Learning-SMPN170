<?php

class LoginController extends Controller {
    
    public function index()
    {
        $data['style'] = 'login';
        $data['title'] = 'Login';

        $this->view('partials/header', $data);
        $this->view('login/index');
    }

}