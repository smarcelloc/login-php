<?php

namespace Src\Controllers;

use CoffeeCode\Router\Router;
use Src\Models\User;

class Auth extends Controller
{
  public function __construct(Router $router)
  {
    parent::__construct($router);

    if (!empty($_SESSION[SESSION_USER_LOGGED])) {
      $this->json('redirect', ['url' => $router->route('app.home')]);
    }
  }

  public function register(array $data)
  {
    $user = new User();
    $user->first_name = $data['first_name'] ?? '';
    $user->last_name = $data['last_name'] ?? '';
    $user->email = $data['email'] ?? '';
    $user->password = $data['password'] ?? '';

    if ($user->save()) {
      setSession(SESSION_USER_LOGGED, $user->data);
      $this->json('redirect', ['url' => $this->router->route('web.login')]);
    }

    $this->json('message', [
      'type' => 'error',
      'message' => $user->fail()->getMessage()
    ]);
  }

  public function login(array $data)
  {
    $email = filter_var($data['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $password = filter_var($data['password'] ?? '', FILTER_DEFAULT);

    if (!$email || !$password) {
      $this->json('message', [
        'type' => 'error',
        'message' => 'Informe seu e-mail e senha para acessar o sistema'
      ]);
    }

    $user = new User();
    $user->email = $email;
    $user->password = $password;

    $userAuth = $user->login();

    if (empty($userAuth)) {
      $this->json('message', [
        'type' => 'error',
        'message' => $user->fail->getMessage()
      ]);
    }

    setSession(SESSION_USER_LOGGED, $userAuth->data);
    $this->json('redirect', ['url' => $this->router->route('app.home')]);
  }
}
