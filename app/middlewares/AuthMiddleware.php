<?php

namespace App\middlewares;

class AuthMiddleware {
  public static function isAuthenticated() {

    if(!isset($_SESSION['user_id'])) {
      header('Location: ' . BASEURL . 'login');
      exit();
    }
  }

  public static function guest()
  {
    if (isset($_SESSION['user_id'])) {
        header('Location: ' . BASEURL . 'class');
        exit();
    }
  }

  public static function isAdmin()
  {
    if ($_SESSION['role'] !== 'admin') {
        header('Location: ' . BASEURL . 'class');
        exit();
    }
  }

  public static function isUser()
  {
    if ($_SESSION['role'] !== 'siswa' || $_SESSION['role'] !== 'guru') {
        header('Location: ' . BASEURL . 'dashboard');
    }
  }
}