<?php

use App\helpers\Flasher as Flasher;
use App\helpers\Validator as Validator;
use App\helpers\Request as Request;
use App\helpers\Unique as Unique;
use App\helpers\Handler as Handler;
use App\helpers\Time as Time;
use App\middlewares\AuthMiddleware as Auth;

class ClassController extends Controller{

    public function __construct()
    {
        Auth::isAuthenticated();
        Auth::isUser();
    }

    public function index()
    {
        $data['user'] = $this->model('User_model')->getUserById($_SESSION['user_id']);
        $data['topbar'] = 1;
        if ($_SESSION['role'] === 'siswa') {
            $data['style'] = 'classSiswa';
            $data['title'] = 'Siswa';
            $data['class'] = $this->model('Class_model')->getUserClass($_SESSION['user_id']);
        } elseif ($_SESSION['role'] === 'guru') {
            $data['style'] = 'classGuru';
            $data['title'] = 'Guru';
            $data['class'] = $this->model('Class_model')->getTeacherClass($_SESSION['user_id']);
        }
        
        $this->view('partials/elearn-header', $data);
        $this->view('partials/topbar', $data);
        $this->view('partials/sidebar', $data);
        $this->view('e-learning/classroom', $data);
    }

    // detail class
    public function dc($code = null)
    {
        if (empty($code)) {
            header('Location: ' . BASEURL . 'class');
            exit();
        }

        $data['user'] = $this->model('User_model')->getUserById($_SESSION['user_id']);
        $data['topbar'] = 2;

        // authorization
        if ($_SESSION['role'] === 'siswa') {
            $data['style'] = 'detailClassSiswa';
            $data['title'] = 'Forum';
            $data['class'] = $this->model('Class_model')->getUserClass($_SESSION['user_id']);
        } elseif ($_SESSION['role'] === 'guru') {
            $data['style'] = 'detailClassGuru';
            $data['title'] = 'Forum';
            $data['class'] = $this->model('Class_model')->getTeacherClass($_SESSION['user_id']);
        }

        $code = explode('-', $code);
        $data['class_code'] = $code[0];

        // check if class exist
        $data['detail_class'] = $this->model('Class_model')->getClassByCode($code[0]);

        if (empty($data['detail_class'])) {
            Flasher::setFlash('error', 'Class not found.');
            header('Location: ' . BASEURL . 'class');
            exit();
        } else {
            // check are user is a class member || teacher || admin
            $member = $this->model('Class_model')->getMemberById($_SESSION['user_id']);

            if ($member || $_SESSION['user_id'] == $data['detail_class']['teacher'] || $_SESSION['role'] === 'admin') {
                $data['post'] = $this->model('Class_model')->getClassPost($data['detail_class']['id']);

                $this->view('partials/elearn-header', $data);
                $this->view('partials/topbar', $data);
                $this->view('partials/sidebar', $data);
                $this->view('e-learning/class-detail', $data);

                unset($_SESSION['errors']);
                unset($_SESSION['old']);
            } else {
                Flasher::setFlash('error', 'Join the class first! get the class code from your teacher.');
                header('Location: ' . BASEURL . 'class');
                exit();
            }
        }
    }

    // join class
    public function jc(){
        // HTTP method check
        Request::requestMethod();
        
        // check if class exist
        $classCheck = $this->model('Class_model')->getClassByCode($_POST['code']);
        if (empty($classCheck)) {
            Flasher::setFlash('error', 'Class not found.');
            header('Location: ' . BASEURL . 'class');
            exit();
        } else {
            // check if user already class member
            $_POST['user_id'] = $_SESSION['user_id'];
            $_POST['class_id'] = $classCheck['id'];

            $member = $this->model('Class_model')->memberCheck($_POST);
            if ($member == false) {

                // query
                $joinClass = $this->model('Class_model')->joinClass($_POST);

                if ($joinClass) {
                    $posts = $this->model('Class_model')->getPostByClass($_POST['class_id']);
                    
                    $param = [];
                    foreach ($posts as $post) {
                        if ($post['categories'] === 'tugas') {
                            $param['post_id'] = $post['id'];
                            $param['user_id'] = $_SESSION['user_id'];
                            $this->model('Class_model')->setAssignment($param);
                        }
                    }

                    Flasher::setFlash('success', 'Welcome!');
                    header('Location: ' . BASEURL . 'class/dc/' . $_POST['code'] . '-' . Unique::generate(12));
                    exit();
                } else {
                    Flasher::setFlash('error', 'There was an error, please try again.');
                    header('Location: ' . BASEURL . 'class');
                    exit;
                }
            } else {
                Flasher::setFlash('error', 'You already a class member.');
                header('Location: ' . BASEURL . 'class');
                exit;
            }
        }
    }

    // class create
    public function c()
    {
        // HTTP method check
        Request::requestMethod();
        
        // set param
        $_POST['grade'] = $_POST['kelas'] . $_POST['abjad'];
        $_POST['code'] = Unique::generate(rand(5,7));
        $_POST['teacher'] = $_SESSION['user_id'];
        $_POST['pict'] = $_POST['subject'] . '.png';

        // check if class exist
        $data['detail_class'] = $this->model('Class_model')->getClassByCode($_POST['code']);

        if ($data['detail_class']) {
            Flasher::setFlash('error', 'Error, please try again!.');
            header('Location: ' . BASEURL . 'class');
            exit();
        } else {
            // query
            $createClass = $this->model('Class_model')->createClass($_POST);
            if ($createClass) {
                Flasher::setFlash('success', 'Class create success, now you can share the unique code');
                header('Location: ' . BASEURL . 'class/dc/' . $_POST['code'] . '-' . Unique::generate(12));
                exit();
            } else {
                Flasher::setFlash('error', 'There was an error creating your class.');
                header('Location: ' . BASEURL . 'class');
                exit;
            }
        }
    }

    // post store
    public function ps()
    {
        // HTTP method check
        Request::requestMethod();

        $handler = new Handler();
        $validator = new Validator();
        $errors = $validator->postValidate($_POST);

        if (count($errors) > 0) {
            // Jika terdapat error, kembalikan ke halaman kontak dengan pesan error
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        $_POST['description'] = htmlspecialchars($_POST['description']);
        $_POST['author'] = $_SESSION['user_id'];
        $_POST['slug'] = Unique::generate(24);

        $createPost = $this->model('Class_model')->createPost($_POST);
        if ($createPost || !empty($createPost)) {
            $post = $this->model('Class_model')->getPostBySlug($_POST['slug']);
            $class = $this->model('Class_model')->getClassById($post['class_id']);
                
                if ($_POST['categories'] === 'tugas') {
                    $users = $this->model('Class_model')->getClassMember($post['class_id']);
                    $param = [];
                    foreach ($users as $user) {
                        $param['post_id'] = $post['id'];
                        $param['user_id'] = $user['user_id'];
                        $this->model('Class_model')->setAssignment($param);
                    }
                }


                if ($post) {
                    $file = $handler->file($_FILES['attachment']);
                    if (!empty($file)) {
                        $file['post_id'] = $post['id'];
                    }

                    $file2 = $handler->file($_FILES['attachment2']);
                    if (!empty($file2)) {
                        $file2['post_id'] = $post['id'];
                    }

                    if ($file && $file2) {
                        $setAttachment = $this->model('Class_model')->setAttachment($file);
                        $setAttachment2 = $this->model('Class_model')->setAttachment($file2);

                        Flasher::setFlash('success', 'Posting success!');
                        header('Location: ' . BASEURL . 'class/dc/' . $class['code'] . '-' . Unique::generate(12));
                        exit;
                    } elseif ($file && !$file2) {
                        $setAttachment = $this->model('Class_model')->setAttachment($file);
                        
                        Flasher::setFlash('success', 'Posting success!');
                        header('Location: ' . BASEURL . 'class/dc/' . $class['code'] . '-' . Unique::generate(12));
                        exit;
                    } elseif (!$file && $file2) {
                        $setAttachment2 = $this->model('Class_model')->setAttachment($file2);

                        Flasher::setFlash('success', 'Posting success!');
                        header('Location: ' . BASEURL . 'class/dc/' . $class['code'] . '-' . Unique::generate(12));
                        exit;
                    } elseif (!$file && !$file2) {
                        Flasher::setFlash('success', 'Posting success!');
                        header('Location: ' . BASEURL . 'class/dc/ . ' . $class['code'] . '-' . Unique::generate(12));
                        exit;
                    } 
                }
            } else {
                Flasher::setFlash('error', 'There was an error creating your post.');
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
    }

    public function ln($param = null)
    {
        if (empty($param)) {
            header('Location: ' . BASEURL . 'class');
            exit();
        }

        $data['user'] = $this->model('User_model')->getUserById($_SESSION['user_id']);
        $data['topbar'] = 2;
        
        $data['style'] = 'lembarNilai';
        $data['title'] = 'Mark';
        $data['class'] = $this->model('Class_model')->getTeacherClass($_SESSION['user_id']);
        
        
        $param = explode('-', $param);
        $data['class_code'] = $param[0];
        $data['detail_class'] = $this->model('Class_model')->getClassByCode($param[0]);

        if (empty($data['detail_class'])) {
            Flasher::setFlash('error', 'Class not found.');
            header('Location: ' . BASEURL . 'class');
            exit();
        } else {
            if ($_SESSION['user_id'] == $data['detail_class']['teacher'] || $_SESSION['role'] === 'admin') {
                if (isset($param[1])) {
                    $data['post_assignment'] = $this->model('Class_model')->getPostAndAssignment($param[1]);
                } else {
                    $data['post_assignment'] = null;
                }
                $data['post'] = $this->model('Class_model')->getClassPost($data['detail_class']['id']);

                $this->view('partials/elearn-header', $data);
                $this->view('partials/topbar', $data);
                $this->view('partials/sidebar', $data);
                $this->view('e-learning/mark', $data);

                unset($_SESSION['errors']);
                unset($_SESSION['old']);
            } else {
                Flasher::setFlash('error', 'Join the class first! get the class code from your teacher.');
                header('Location: ' . BASEURL . 'class');
                exit();
            }
        }
    }

    public function dp($param = null)
    {
        // HTTP method check
        Request::requestMethod();

        $param = explode('-', $param);
        $delPost = $this->model('Class_model')->delPost($param[0]);
        if ($delPost) {
            Flasher::setFlash('success', 'Post delete successful!');
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            Flasher::setFlash('error', 'Post delete failed!');
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }

    public function sbtgs()
    {
        // HTTP method check
        Request::requestMethod();

        $handler = new Handler();
        $file = $handler->file($_FILES['assignment']);
        if ($file) {
            $file['post_id'] = $_POST['post_id'];
            $file['user_id'] = $_SESSION['user_id'];
            $submit = $this->model('Class_model')->submitWork($file);
            
            if ($submit) {
                Flasher::setFlash('success', 'Submit success!');
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            } else {
                Flasher::setFlash('error', 'Submit failed!');
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
        } 
    }

    public function mark()
    {
        // HTTP method check
        Request::requestMethod();

            $submit = $this->model('Class_model')->setMark($_POST);
            
            if ($submit) {
                Flasher::setFlash('success', 'Marking success!');
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            } else {
                Flasher::setFlash('error', 'Marking failed!');
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
    }

    public function dt($param = null)
    {
        if (empty($param)) {
            header('Location: ' . BASEURL . 'class');
            exit();
        }

        $data['user'] = $this->model('User_model')->getUserById($_SESSION['user_id']);
        $data['topbar'] = 2;
        $data['class_code'] = $param[0];

        // authorization
        if ($_SESSION['role'] === 'siswa') {
            $data['style'] = 'detailTugasSiswa';
            $data['title'] = 'Post';
            $data['class'] = $this->model('Class_model')->getUserClass($_SESSION['user_id']);
        } elseif ($_SESSION['role'] === 'guru') {
            $data['style'] = 'detailTugasGuru';
            $data['title'] = 'Post';
            $data['class'] = $this->model('Class_model')->getTeacherClass($_SESSION['user_id']);
        }

        $param = explode('-', $param);
        $data['class_code'] = $param[0];

        // check if class exist
        $data['detail_post'] = $this->model('Class_model')->getPostBySlug($param[1]);

        if (empty($data['detail_post'])) {
            Flasher::setFlash('error', 'Post not found.');
            header('Location: ' . BASEURL . 'class/dc/' . $param[0] . '-' . Unique::generate(12));
            exit();
        } else {
            // check are user is a class member || teacher || admin
            $member = $this->model('Class_model')->getMemberById($_SESSION['user_id']);

            
            $timeFormatter = new Time();
            $data['detail_post']['created_at'] = $timeFormatter->friendlyTime($data['detail_post']['created_at']);
            $data['files'] = $this->model('Class_model')->getAttachment($data['detail_post']['id']);

            if ($_SESSION['role'] === 'siswa' && $data['detail_post']['categories'] === 'tugas') {
                $data['user_assignment'] = $this->model('Class_model')->getAssignment($_SESSION['user_id'], $data['detail_post']['id']);
            } elseif ($_SESSION['role'] === 'guru') {
                $data['user_assignment'] = $this->model('Class_model')->getAssignment($param[2], $data['detail_post']['id']);
            }

            if ($member || $_SESSION['user_id'] == $data['detail_post']['author'] || $_SESSION['role'] === 'guru' || $_SESSION['role'] === 'admin') {
        
                $this->view('partials/elearn-header', $data);
                $this->view('partials/topbar', $data);
                $this->view('partials/sidebar', $data);
                $this->view('e-learning/post-detail', $data);

                unset($_SESSION['errors']);
                unset($_SESSION['old']);
            } else {
                Flasher::setFlash('error', 'Join the class first! get the class code from your teacher.');
                header('Location: ' . BASEURL . 'class');
                exit();
            }
        }
    }

}