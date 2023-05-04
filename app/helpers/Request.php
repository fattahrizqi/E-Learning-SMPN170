<?php

namespace App\helpers;

class Request {

    public static function requestMethod()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            // Code to execute if the request method isn't POST

            // Redirect the user to the previous URL
            header("Location: " . BASEURL . 'class');
            exit();
        } 
    }

}