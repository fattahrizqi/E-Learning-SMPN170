<?php

namespace App\helpers;

class Validator
{
    private $errors = [];

    public function registerValidate($inputs)
    {
        // Validasi nama
        if (empty($inputs['name'])) {
            $this->addError('name', 'Name required.');
        } elseif (strlen($inputs['name']) < 3) {
            $this->addError('name', 'Name too short');
        }

        // Validasi email
        if (empty($inputs['email'])) {
            $this->addError('email', 'Email required.');
        } elseif (!filter_var($inputs['email'], FILTER_VALIDATE_EMAIL)) {
            $this->addError('email', 'Email format invalid.');
        }

        // Validasi password
        if (empty($inputs['password'])) {
            $this->addError('password', 'Password required.');
        } elseif (strlen($inputs['password']) < 3) {
            $this->addError('password', 'Password must be have 3 or more characters');
        } elseif (empty($inputs['confirm'])) {
            $this->addError('confirm', 'Confirm password required.');
        } elseif ($inputs['confirm'] !== $inputs['password']) {
            $this->addError('confirm', 'Confirm password doesnt match');
        }

        return $this->errors;
    }

    public function ucValidate($inputs)
    {
        // Validasi nama
        if (empty($inputs['name'])) {
            $this->addError('name', 'Name required.');
        } elseif (strlen($inputs['name']) < 3) {
            $this->addError('name', 'Name too short');
        }

        // Validasi email
        if (empty($inputs['email'])) {
            $this->addError('email', 'Email required.');
        } elseif (!filter_var($inputs['email'], FILTER_VALIDATE_EMAIL)) {
            $this->addError('email', 'Email format invalid.');
        }

        // Validasi password
        if (empty($inputs['role'])) {
            $this->addError('role', 'Role required.');
        }

        return $this->errors;
    }

    public function postValidate($inputs)
    {
        // Validasi title
        if (empty($inputs['title'])) {
            $this->addError('title', 'Title required.');
        } elseif (strlen($inputs['title']) < 3) {
            $this->addError('title', 'Title too short');
        }

        // Validasi deskripsi
        if (empty($inputs['description'])) {
            $this->addError('description', 'Description required.');
        } elseif (strlen($inputs['description']) > 1000) {
            $this->addError('description', 'Description more than 1000 characters');
        }

        // Validasi password
        if (empty($inputs['categories'])) {
            $this->addError('categories', 'Categories required.');
        }

        return $this->errors;
    }

    private function addError($field, $message)
    {
        $this->errors[$field] = $message;
    }
}