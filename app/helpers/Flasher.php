<?php

namespace App\helpers;

class Flasher {
    
    public static function setFlash($type, $messege)
    {
        $_SESSION['flash'] = [
            'messege' => $messege,
            'type' => $type
        ];
    }

    public static function flash()
    {
        if ( isset($_SESSION['flash']) ) {
            echo '<label>
            <input type="checkbox" class="alertCheckbox" autocomplete="off" />
            <div class="alert ' . $_SESSION['flash']['type'] . '">
              <span class="alertClose">X</span>
              <span class="alertText">' . $_SESSION['flash']['messege'] . '
              <br class="clear"/></span>
            </div>
          </label>'; 
        }
        unset($_SESSION['flash']);
    }
}