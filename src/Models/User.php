<?php

namespace Src\Models;

use CoffeeCode\DataLayer\DataLayer;
use Exception;

/**
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $password_forget 
 * @property string $facebook_id 
 * @property string $google_id 
 * @property string $photo 
 * @property string $created_at 
 * @property string $updated_at 
 */
class User extends DataLayer
{
  public function __construct()
  {
    $required = ['first_name', 'last_name', 'email', 'password'];
    parent::__construct('users', $required, 'id', true);
  }

  public function save(): bool
  {
    if (!$this->required()) {
      $this->fail = new Exception("Preencha os campos necessários");
      return false;
    }

    if (!$this->validateEmail()) {
      return false;
    }

    $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    return parent::save();
  }

  private function validateEmail(): bool
  {
    if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
      $this->fail = new Exception("Preencha um e-mail válido");
      return false;
    }

    if ($this->id) {
      $checkEmailExist = $this->find('email = :email AND id != :id', "email={$this->email}&id={$this->id}", 'id')->count();
    } else {
      $checkEmailExist = $this->find('email = :email', "email={$this->email}", 'id')->count();
    }


    if ($checkEmailExist) {
      $this->fail = new Exception("Este e-mail já existe em nosso sistema");
      return false;
    }

    return true;
  }
}
