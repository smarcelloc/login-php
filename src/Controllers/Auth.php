<?php

namespace Src\Controllers;

use CoffeeCode\Router\Router;
use Src\Models\User;

class Auth extends Controller
{
  public function __construct(Router $router)
  {
    parent::__construct($router);
  }

  public function register(array $data)
  {
    $user = new User();
    $user->first_name = $data['first_name'] ?? '';
    $user->last_name = $data['last_name'] ?? '';
    $user->email = $data['email'] ?? '';
    $user->password = $data['password'] ?? '';

    if ($user->save()) {
      $_SESSION[SESSION_USER_LOGGED] = $user;
      $this->json('redirect', ['url' => $this->router->route('web.login')]);
    }

    $this->json('message', [
      'type' => 'error',
      'message' => $user->fail()->getMessage()
    ]);
  }
}
