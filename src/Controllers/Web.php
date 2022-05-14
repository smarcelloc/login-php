<?php

namespace Src\Controllers;

use CoffeeCode\Router\Router;
use Src\Models\User;

class Web extends Controller
{
  public function __construct(Router $router)
  {
    parent::__construct($router);

    if (!empty($_SESSION[SESSION_USER_LOGGED])) {
      $router->redirect('app.home');
    }
  }

  public function login(): void
  {
    $head = $this->seo->optimize(
      'Acessa a sua conta | ' . SITE['name'],
      SITE['description'],
      $this->router->route('web.login'),
      routeImage('login')
    );

    $this->page('login', ['head' => $head->render()]);
  }

  public function register(): void
  {
    $head = $this->seo->optimize(
      'Crie a sua conta gratuitamente | ' . SITE['name'],
      SITE['description'],
      $this->router->route('web.login'),
      routeImage('cadastrar')
    );

    $this->page('register', ['head' => $head->render()]);
  }

  public function forget(): void
  {
    $head = $this->seo->optimize(
      'Recupera a sua senha | ' . SITE['name'],
      SITE['description'],
      $this->router->route('web.forget'),
      routeImage('recupera')
    );

    $this->page('forget', ['head' => $head->render()]);
  }

  public function reset(array $params)
  {
    if (!sessionExist('user_id') || !filter_var($params['email'], FILTER_VALIDATE_EMAIL)) {
      $this->router->redirect('web.login');
    }

    $head = $this->seo->optimize(
      'Cria uma nova senha | ' . SITE['name'],
      SITE['description'],
      $this->router->route('web.reset'),
      routeImage('recuperar')
    );

    $this->page('reset', [
      'head' => $head->render(),
      'email' => $params['email'],
      'forget' => $params['forget']
    ]);
  }

  public function error(array $params)
  {
    $errorCode = filter_var($params['errcode'], FILTER_VALIDATE_INT);

    if ($errorCode === false) {
      $errorCode = 500;
    }

    $head = $this->seo->optimize(
      "Ops! ${errorCode} | " . SITE['name'],
      SITE['description'],
      $this->router->route('web.error'),
      routeImage('error')
    );

    $this->page('error', ['head' => $head->render(), 'error' => $errorCode]);
  }
}
