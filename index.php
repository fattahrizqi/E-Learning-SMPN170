<?php
set_time_limit(420);

if( !session_id() ) session_start();

require_once 'app/init.php';

$app = new App;