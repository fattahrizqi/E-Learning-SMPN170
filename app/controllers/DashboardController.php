<?php

use App\middlewares\AuthMiddleware as Auth;
use App\helpers\Flasher as Flasher;
use App\helpers\Request as Request;
use App\helpers\Validator as Validator;

class DashboardController extends Controller {

    // method to check that user was authenticated and have admin role before interact with this controller
    public function __construct()
    {
        Auth::isAuthenticated();
        Auth::isAdmin();
    }

    public function index()
    {
        $data['topbar'] = 1;
        $data['style'] = 'dashboardAdmin';
        $data['title'] = 'Dashboard';


        // count all students classified by gender
        $data['L'] = $this->model('User_model')->getAllStudent('L');
        $data['P'] = $this->model('User_model')->getAllStudent('P');

        // get all teacher
        $data['teacher'] = $this->model('User_model')->getAllTeacher();

        // get all admin
        $data['admin'] = $this->model('User_model')->getAllAdmin();

        $this->view('partials/elearn-header', $data);
        $this->view('partials/topbar', $data);
        $this->view('partials/admin-sidebar');
        $this->view('dashboard/index', $data);
    }

    // ac (account centre) with url param format ...dashboard/ac/{pagination}, default : page-1
    public function ac($param = "page-1")
    {
        $data['topbar'] = 1;
        $data['style'] = 'dataAkunAdmin';
        $data['title'] = 'Data Akun';


        $param = explode('-', $param);

        // pagination config
        $data['records_per_page'] = 10;
        $data['data_sum'] = count($this->model('User_model')->getAllUser());
        $data['total_page'] = ceil($data['data_sum'] / $data['records_per_page']);
        
        
        $data['current_page'] = (isset($param[1])) ? $param[1] : 1;
        $data['offset'] = ( $data['records_per_page'] * $data['current_page'] ) - $data['records_per_page'];
        
        // limit the number of pagination link buttons to 5
        $data['links_per_set'] = 5;

        // determine the start and end page numbers of the pagination
        $data['start_page'] = max(1, $data['current_page'] - floor($data['links_per_set'] / 2));
        $data['end_page'] = min($data['total_page'], $data['start_page'] + $data['links_per_set'] - 1);
        
        
        $data['user'] = $this->model('User_model')->getAllUserPage($data['offset'], $data['records_per_page']);
        
        $this->view('partials/elearn-header', $data);
        $this->view('partials/topbar', $data);
        $this->view('partials/admin-sidebar');
        $this->view('dashboard/account-data', $data);

        unset($_SESSION['errors']);
        unset($_SESSION['old']);
    }

    // acs (account centre search)
    public function acs($param = 'page-1')
    {
        // HTTP method check
        Request::requestMethod();
        $data['topbar'] = 1;
        $data['style'] = 'dataAkunAdmin';
        $data['title'] = 'Data Akun';
        $data['user'] = $this->model('User_model')->searchUser($_POST);

        // pagination config
        $data['records_per_page'] = 10;
        $data['data_sum'] = count($data['user']);
        $data['total_page'] = ceil($data['data_sum'] / $data['records_per_page']);
        
        $param = explode('-', $param);
        
        $data['current_page'] = (isset($param[1])) ? $param[1] : 1;
        $data['offset'] = ( $data['records_per_page'] * $data['current_page'] ) - $data['records_per_page'];
        
        // limit the number of pagination link buttons to 5
        $data['links_per_set'] = 5;

        // determine the start and end page numbers of the pagination
        $data['start_page'] = max(1, $data['current_page'] - floor($data['links_per_set'] / 2));
        $data['end_page'] = min($data['total_page'], $data['start_page'] + $data['links_per_set'] - 1);
        
        $this->view('partials/elearn-header', $data);
        $this->view('partials/topbar', $data);
        $this->view('partials/admin-sidebar');
        $this->view('dashboard/account-data', $data);

        unset($_SESSION['errors']);
        unset($_SESSION['old']);
    }

    public function uc()
    {
        // HTTP method check
        Request::requestMethod();
        
        // initiate new object of Validator class (helpers)
        $validator = new Validator();
        $errors = $validator->ucValidate($_POST); // form validate

        if (count($errors) > 0) {
            // If error is set, return back to previous url with error message
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            header('Location: ' . BASEURL . 'dashboard/ac');
            exit;
        }
        unset($_SESSION['errors']);
        unset($_SESSION['old']);
        
        $existing_user = $this->model('User_model')->getUserByEmail($_POST['email']);

        if ($existing_user) {
            Flasher::setFlash('error', 'An account with that email address already exists.');
            header('Location: ' . BASEURL . 'dashboard/ac');
            exit;
        } else {
            $user_id = $this->model('User_model')->createUserByAdmin($_POST);
            $createProfile = $this->model('User_model')->createProfile($_POST);
            if ($user_id && $createProfile) {
                Flasher::setFlash('success', 'Account create successfull!');
                header('Location: ' . BASEURL . 'dashboard/ac');
                exit();
            } else {
                Flasher::setFlash('error', 'There was an error creating your account.');
                header('Location: ' . BASEURL . 'dashboard/ac');
                exit;
            }
        }
    }

    // ud (user detail)
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

        $data['profil'] = $this->model('User_model')->getUserProfile($user_id);

        $this->view('partials/elearn-header', $data);
        $this->view('partials/topbar', $data);
        $this->view('partials/admin-sidebar', $data);
        $this->view('userprofil/index', $data);
    }
}