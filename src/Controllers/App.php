<?php

namespace Src\Controllers;

use CoffeeCode\Router\Router;
use Src\Models\User;

class App extends Controller
{

  /**
   * @var User
   */
  private $user;

  public function __construct(Router $router)
  {
    parent::__construct($router);

    if (empty($_SESSION[SESSION_USER_LOGGED])) {
      $router->redirect('web.login');
    }

    $this->user = getSession(SESSION_USER_LOGGED);
  }

  public function home()
  {
    $head = $this->seo->optimize(
      "Bem vindo(a) {$this->user->first_name} | " . SITE['name'],
      SITE['description'],
      $this->router->route('app.home'),
      routeImage('home')
    )->render();

    $this->page('/dashboard', ['head' => $head, 'user' => $this->user]);
  }

  public function me()
  {
  }

  public function logoff()
  {
    unsetSession(SESSION_USER_LOGGED);

    setFlash('message', [
      'type' => 'info',
      'message' => "Você saiu com sucesso, volte logo {$this->user->first_name}."
    ]);

    $this->router->redirect('web.login');
  }
}
