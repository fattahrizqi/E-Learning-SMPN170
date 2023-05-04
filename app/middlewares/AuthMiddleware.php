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
        if ($_SESSION['user_id'] !== 'admin') {
          header('Location: ' . BASEURL . 'class');
          exit();
        } else {
          header('Location: ' . BASEURL . 'dashboard');
          exit();
        }
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
    if ($_SESSION['role'] === 'admin') {
        header('Location: ' . BASEURL . 'dashboard');
        exit();
    }
  }
  
}