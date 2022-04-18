<?php

namespace Src\Controllers;

use CoffeeCode\Router\Router;
use Exception;
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
      $this->json('redirect', ['url' => $this->router->route('web.login')]);
    }

    $this->json('message', [
      'type' => 'error',
      'message' => $user->fail()->getMessage()
    ]);
  }

  // private function validateUser(array $data)
  // {
  //   $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

  //   if (in_array('', $data)) {
  //     $this->jsonError('Preencha todo os campos');
  //   }

  //   if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
  //     $this->jsonError('Preencha o campo e-mail corretamente');
  //   }

  //   $checkIfExistEmail = (new User())->find('email = :e', 'e=' . $data['email'])->count();
  //   if ($checkIfExistEmail) {
  //     $this->jsonError('Existe e-mail já existe cadastrado em nosso sistema');
  //   }
  // }
}
