<?php

use App\helpers\Flasher as Flasher;
use App\helpers\Validator as Validator;
use App\middlewares\AuthMiddleware as Auth;

class ClassController extends Controller{

    public function __construct()
    {
        Auth::isAuthenticated();
        Auth::isUser();
    }

    public function index()
    {
        $data['style'] = 'classSiswa';
        $data['title'] = 'Siswa';

        $this->view('partials/elearn-header', $data);
        $this->view('partials/sidebar');
        $this->view('e-learning/classroom');
    }

}