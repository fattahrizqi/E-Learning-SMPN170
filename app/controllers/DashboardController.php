<?php

use App\middlewares\AuthMiddleware as Auth;

class DashboardController extends Controller {

    public function __construct()
    {
        Auth::isAuthenticated();
        Auth::isAdmin();
    }

    public function index()
    {
        $data['style'] = 'dashboardAdmin';
        $data['title'] = 'Dashboard';

        $this->view('partials/elearn-header', $data);
        $this->view('dashboard/index');
    }

    public function dataakun()
    {
        
    }
}