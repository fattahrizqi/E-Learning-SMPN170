<?php

class User {
    private $nama = 'Kiki';

    private $dbh;
    private $stmt;

    public function __construct()
    {
        
    }

    public function getUser(){
        return $this->nama;
    }
}