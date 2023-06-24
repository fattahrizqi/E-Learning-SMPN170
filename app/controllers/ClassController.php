<?php

use App\helpers\Flasher as Flasher;
use App\helpers\Validator as Validator;
use App\helpers\Request as Request;
use App\helpers\Unique as Unique;
use App\helpers\Handler as Handler;
use App\helpers\Time as Time;
use App\middlewares\AuthMiddleware as Auth;

class ClassController extends Controller{

    // method to check that user was authenticated and not admin before interact with this controller
    public function __construct()
    {
        Auth::isAuthenticated();
        Auth::isUser();
    }

    public function index()
    {
        $data['user'] = $this->model('User_model')->getUserById($_SESSION['user_id']);
        $data['topbar'] = 1;

        // authorization
        if ($_SESSION['role'] === 'siswa') {
            $data['style'] = 'classSiswa';
            $data['title'] = 'Siswa';
            $data['class'] = $this->model('Class_model')->getUserClass($_SESSION['user_id']);
        } elseif ($_SESSION['role'] === 'guru') {
            $data['style'] = 'classGuru';
            $data['title'] = 'Guru';
            $data['class'] = $this->model('Class_model')->getTeacherClass($_SESSION['user_id']);
        }
        
        // return user class list view
        $this->view('partials/elearn-header', $data);
        $this->view('partials/topbar', $data);
        $this->view('partials/sidebar', $data);
        $this->view('e-learning/classroom', $data);
    }

    // dc (detail class) with url param format ...class/dc/{class-code}-{random-unique}
    public function dc($code = null)
    {
        // if the parameter wasn't set
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

    // recap (mark)
    public function rc($param = null){
        // check if url parameter is not set
        if (empty($param)) {
            header('Location: ' . BASEURL . 'class');
            exit();
        }

        // get user detail
        $data['user'] = $this->model('User_model')->getUserById($_SESSION['user_id']);
        $data['topbar'] = 2;
        
        // set page css, title, and identity of class teacher
        $data['style'] = 'recap';
        $data['title'] = 'Recap';
        $data['class'] = $this->model('Class_model')->getTeacherClass($_SESSION['user_id']);

        // explode the paramater with '-' as separator and will be array in index[0] = class code, and index[1] = post slug
        $param = explode('-', $param);
        $data['slug'] = $param[1];
        $data['class_code'] = $param[0];
        
        // check if class exist
        $data['detail_class'] = $this->model('Class_model')->getClassByCode($param[0]);
        if (empty($data['detail_class'])) {
            Flasher::setFlash('error', 'Class not found.');
            header('Location: ' . BASEURL . 'class');
            exit();
        } else {
            // check if user that access this page is teacher or admin
            if ($_SESSION['user_id'] == $data['detail_class']['teacher'] || $_SESSION['role'] === 'admin') {
                // get class all post
                $data['post'] = $this->model('Class_model')->getRecapPost($data['detail_class']['id']);
                $data['students'] = $this->model('Class_model')->getClassMember($data['detail_class']['id']);
                foreach ($data['students'] as &$students) {
                    $item = $this->model('Class_model')->getMemberMark($students['id'], $data['detail_class']['id']);
                    $students['mark'] = $item;
                }

                // return view
                $this->view('partials/elearn-header', $data);
                $this->view('partials/topbar', $data);
                $this->view('partials/sidebar', $data);
                $this->view('e-learning/recap', $data);

                // unset all error session
                unset($_SESSION['errors']);
                unset($_SESSION['old']);
            } else {
                Flasher::setFlash('error', 'Join the class first! get the class code from your teacher.');
                header('Location: ' . BASEURL . 'class');
                exit();
            }
        }
    }

    // export recap as excel
    public function rcxls($param = null){
        // check if url parameter is not set
        if (empty($param)) {
            header('Location: ' . BASEURL . 'class');
            exit();
        }

        // get user detail
        $data['user'] = $this->model('User_model')->getUserById($_SESSION['user_id']);
        $data['topbar'] = 2;
        
        // set page css, title, and identity of class teacher
        $data['style'] = 'recap';
        $data['title'] = 'Recap';
        $data['class'] = $this->model('Class_model')->getTeacherClass($_SESSION['user_id']);

        $data['class_code'] = $param;
        
        // check if class exist
        $data['detail_class'] = $this->model('Class_model')->getClassByCode($data['class_code']);
        if (empty($data['detail_class'])) {
            Flasher::setFlash('error', 'Error!');
            header('Location: ' . BASEURL . 'class');
            exit();
        } else {
            // check if user that access this page is teacher or admin
            if ($_SESSION['user_id'] == $data['detail_class']['teacher'] || $_SESSION['role'] === 'admin') {
                // get class all post
                $data['post'] = $this->model('Class_model')->getRecapPost($data['detail_class']['id']);
                $data['students'] = $this->model('Class_model')->getClassMember($data['detail_class']['id']);
                foreach ($data['students'] as &$students) {
                    $item = $this->model('Class_model')->getMemberMark($students['id'], $data['detail_class']['id']);
                    $students['mark'] = $item;
                }

                $this->view('e-learning/recap-excel', $data);

                // unset all error session
                unset($_SESSION['errors']);
                unset($_SESSION['old']);
            } else {
                Flasher::setFlash('error', 'Error!');
                header('Location: ' . BASEURL . 'class');
                exit();
            }
        }
    }

    // join class (for students)
    public function jc(){
        // HTTP method check - can't accessed this method if server request method is GET
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
                    // set user assignment if there's post assignment before user join
                    $posts = $this->model('Class_model')->getPostByClass($_POST['class_id']);
                    $param = [];
                    foreach ($posts as $post) {
                        if ($post['categories'] === 'tugas') {
                            $param['post_id'] = $post['id'];
                            $param['user_id'] = $_SESSION['user_id'];
                            $this->model('Class_model')->setAssignment($param);
                        }
                    }

                    // return with flash message
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

    // class create (for teacher)
    public function c()
    {
        // HTTP method check - can't accessed this method if server request method is GET
        Request::requestMethod();
        
        // set param for create class
        $_POST['grade'] = $_POST['kelas'] . $_POST['abjad'];
        $_POST['code'] = Unique::generate(rand(5,7)); // set unique identifier for class with 5 - 7 digit characters
        $_POST['teacher'] = $_SESSION['user_id']; // set the submittor id as a teacher
        $_POST['pict'] = $_POST['subject'] . '.png'; // store the picture of class card by its subject

        // check if class exist and prevent duplicate unique identifier
        $data['detail_class'] = $this->model('Class_model')->getClassByCode($_POST['code']);

        if ($data['detail_class']) {
            Flasher::setFlash('error', 'Error, please try again!.');
            header('Location: ' . BASEURL . 'class');
            exit();
        } else {
            // create class query
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

    // ps (post store), handle class post form
    public function ps()
    {
        // HTTP method check - can't accessed this method if server request method is GET
        Request::requestMethod();

        // Initiate File Handler object and Form Validator object from App\helpers
        $handler = new Handler();
        $validator = new Validator();

        // Do $_POST validate with Form Validator Object
        $errors = $validator->postValidate($_POST);
        
        if (count($errors) > 0) {
            // If error is set, return back to previous url with error message
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
        
        // set parameter for create post
        $_POST['description'] = htmlspecialchars($_POST['description']);
        $_POST['author'] = $_SESSION['user_id'];
        $_POST['slug'] = Unique::generate(24); // generate unique code for slug with 24 characters include nums

        // create post query
        $createPost = $this->model('Class_model')->createPost($_POST);
        if ($createPost || !empty($createPost)) {
            // if create post query success, we fetch the post with the slug we set before
            $post = $this->model('Class_model')->getPostBySlug($_POST['slug']);
            $class = $this->model('Class_model')->getClassById($post['class_id']); // get the class by its id
                
                //  if the teacher choose the post as assignment, then it will make assignment for all class member
                if ($_POST['categories'] === 'tugas') {
                    $users = $this->model('Class_model')->getClassMember($post['class_id']);
                    $param = [];
                    foreach ($users as $user) {
                        $param['post_id'] = $post['id'];
                        $param['user_id'] = $user['user_id'];
                        $this->model('Class_model')->setAssignment($param);
                    }
                }

                // Validate if query success
                if ($post) {
                    // handle $_FILES request with Handlers object helpers
                    $file = $handler->file($_FILES['attachment']); // first attachment
                    if (!empty($file)) {
                        $file['post_id'] = $post['id'];
                    }

                    $file2 = $handler->file($_FILES['attachment2']); // second attachment
                    if (!empty($file2)) {
                        $file2['post_id'] = $post['id'];
                    }

                    if ($file && $file2) { // if both $_FILES isn't null
                        $setAttachment = $this->model('Class_model')->setAttachment($file);
                        $setAttachment2 = $this->model('Class_model')->setAttachment($file2);

                        Flasher::setFlash('success', 'Posting success!');
                        header('Location: ' . BASEURL . 'class/dc/' . $class['code'] . '-' . Unique::generate(12));
                        exit;
                    } elseif ($file && !$file2) { // if just first $_FILES that is set
                        $setAttachment = $this->model('Class_model')->setAttachment($file);
                        
                        Flasher::setFlash('success', 'Posting success!');
                        header('Location: ' . BASEURL . 'class/dc/' . $class['code'] . '-' . Unique::generate(12));
                        exit;
                    } elseif (!$file && $file2) { // if just second $_FILES that is set
                        $setAttachment2 = $this->model('Class_model')->setAttachment($file2);

                        Flasher::setFlash('success', 'Posting success!');
                        header('Location: ' . BASEURL . 'class/dc/' . $class['code'] . '-' . Unique::generate(12));
                        exit;
                    } elseif (!$file && !$file2) { // if both $_FILES isn't set, it will return success post with no attachment
                        Flasher::setFlash('success', 'Posting success!');
                        header('Location: ' . BASEURL . 'class/dc/' . $class['code'] . '-' . Unique::generate(12));
                        exit;
                    } 
                }
            } else {
                Flasher::setFlash('error', 'There was an error creating your post.');
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
    }

    // ln(lembar nilai) with url parameter format ..class/ln/{class unique code}-{post slug}
    public function ln($param = null)
    {
        // check if url parameter is not set
        if (empty($param)) {
            header('Location: ' . BASEURL . 'class');
            exit();
        }

        // get user detail
        $data['user'] = $this->model('User_model')->getUserById($_SESSION['user_id']);
        $data['topbar'] = 2;
        
        // set page css, title, and identity of class teacher
        $data['style'] = 'lembarNilai';
        $data['title'] = 'Mark';
        $data['class'] = $this->model('Class_model')->getTeacherClass($_SESSION['user_id']);

        // explode the paramater with '-' as separator and will be array in index[0] = class code, and index[1] = post slug
        $param = explode('-', $param);
        $data['slug'] = $param[1];
        $data['class_code'] = $param[0];
        
        // check if class exist
        $data['detail_class'] = $this->model('Class_model')->getClassByCode($param[0]);
        if (empty($data['detail_class'])) {
            Flasher::setFlash('error', 'Class not found.');
            header('Location: ' . BASEURL . 'class');
            exit();
        } else {
            // check if user that access this page is teacher or admin
            if ($_SESSION['user_id'] == $data['detail_class']['teacher'] || $_SESSION['role'] === 'admin') {
                // condition to check if there any user filter data request
                if (isset($param[1])) {
                    if (!isset($_POST['filter'])) {
                        $data['post_assignment'] = $this->model('Class_model')->getPostAndAssignment($param[1]);
                        $data['option'] = null;
                    } elseif ($_POST['filter'] === 'assigned') {
                        $data['post_assignment'] = $this->model('Class_model')->getPostAndAssignment($param[1], $_POST['filter']);
                        $data['option'] = 'assigned';
                    } elseif ($_POST['filter'] === 'submitted') {
                        $data['post_assignment'] = $this->model('Class_model')->getPostAndAssignment($param[1], $_POST['filter']);
                        $data['option'] = 'submitted';
                    } elseif ($_POST['filter'] === 'marked') {
                        $data['post_assignment'] = $this->model('Class_model')->getPostAndAssignment($param[1], $_POST['filter']);
                        $data['option'] = 'marked';
                    }
                    else {
                        $data['post_assignment'] = null;
                    }
                } else {
                    $data['post_assignment'] = null;
                }
                // get class all post
                $data['post'] = $this->model('Class_model')->getClassPost($data['detail_class']['id']);

                // return view
                $this->view('partials/elearn-header', $data);
                $this->view('partials/topbar', $data);
                $this->view('partials/sidebar', $data);
                $this->view('e-learning/mark', $data);

                // unset all error session
                unset($_SESSION['errors']);
                unset($_SESSION['old']);
            } else {
                Flasher::setFlash('error', 'Join the class first! get the class code from your teacher.');
                header('Location: ' . BASEURL . 'class');
                exit();
            }
        }
    }

    // dp (delete post)
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

    // sbtgs (submit tugas) - for students
    public function sbtgs()
    {
        // HTTP method check - can't accessed this method if server request method is GET
        Request::requestMethod();

        // initate Handler object for handle $_FILES request
        $handler = new Handler();
        $file = $handler->file($_FILES['assignment']);
        if ($file) {
            $file['post_id'] = $_POST['post_id'];
            $file['user_id'] = $_SESSION['user_id'];
            $submit = $this->model('Class_model')->submitWork($file);
            
            // return with flash message
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

    // set mark method
    public function mark()
    {
        // HTTP method check - can't accessed this method if server request method is GET
        Request::requestMethod();

        // setMark query with Class model
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

    // dt (detail tugas) - with url param format ...class/dt/{class-code}-{post-slug}-{user-id}-{3-digit-unique}
    public function dt($param = null)
    {
        // check if url parameter is not set
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

        // check if post exist
        $data['detail_post'] = $this->model('Class_model')->getPostBySlug($param[1]);

        if (empty($data['detail_post'])) {
            Flasher::setFlash('error', 'Post not found.');
            header('Location: ' . BASEURL . 'class/dc/' . $param[0] . '-' . Unique::generate(12));
            exit();
        } else {
            // get the user data as class members
            $member = $this->model('Class_model')->getMemberById($_SESSION['user_id']);

            // change timestamp to user-friendly time
            $timeFormatter = new Time();
            $data['detail_post']['created_at'] = $timeFormatter->friendlyTime($data['detail_post']['created_at']);
            $data['files'] = $this->model('Class_model')->getAttachment($data['detail_post']['id']);

            // authorization - (if the post categoried as assignment)
            if ($_SESSION['role'] === 'siswa' && $data['detail_post']['categories'] === 'tugas') {
                $data['user_assignment'] = $this->model('Class_model')->getAssignment($_SESSION['user_id'], $data['detail_post']['id']);
            } elseif ($_SESSION['role'] === 'guru') {
                $data['user_assignment'] = $this->model('Class_model')->getAssignment($param[2], $data['detail_post']['id']);
            }

            // check if user that access this page is class member or its author or teacher and admin before return the view
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