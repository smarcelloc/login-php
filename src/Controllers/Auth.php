<?php

namespace Src\Controllers;

use CoffeeCode\Router\Router;
use Src\Support\Email;
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

  public function forget(array $data)
  {
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
      $this->json('message', [
        'type' => 'error',
        'message' => 'Informe o seu e-mail válido para recuperar a sua senha'
      ]);
    }

    /** @var User */
    $user = (new User())->find('email=:email', "email=" . $data['email'])->fetch();
    if (!$user) {
      $this->json('message', [
        'type' => 'error',
        'message' => 'Este E-mail não existe em nosso sistema'
      ]);
    }

    $user->password_forget = md5(uniqid(rand(), true));
    $user->save();

    setSession('user_id', $user->id);

    $linkForget = $this->router->route('web.reset', [
      'email' => $user->email,
      'forget' => $user->password_forget
    ]);

    // $email = new Email();
    // $templateEmail = $this->view->render('emails/recover', [
    //   'user' => $user,
    //   'link' => $linkForget
    // ]);

    // $email->add(
    //   'Recupera a sua senha ' . SITE['name'],
    //   $templateEmail,
    //   $user->first_name . ' ' . $user->last_name,
    //   $user->email
    // )->send();

    setFlash('message', [
      'type' => 'success',
      'message' => 'Você receberá um link de recuperação no E-MAIL informado' . $linkForget
    ]);

    $this->json('redirect', [
      'url' => $this->router->route('web.login')
    ]);
  }

  public function reset(array $data)
  {
    if (!sessionExist('user_id') || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
      $this->json('redirect', ['url' => $this->router->route('web.login')]);
    }

    /** @var User */
    $user = (new User())->findById(getSession('user_id'));

    $data = filter_var_array($data, FILTER_DEFAULT);
    if (!$user || $user->email !== $data['email'] || $user->password_forget !== $data['forget']) {
      setFlash('message', ['type' => 'error', 'message' => 'Não foi possível recuperar a sua senha, por favor tente novamente.']);
      $this->json('redirect', ['url' => $this->router->route('web.login')]);
    }

    if ($data['password'] !== $data['password_re']) {
      $this->json('message', [
        'type' => 'error',
        'message' => 'Você informou duas senhas diferentes'
      ]);
    }

    $user->password_forget = null;
    $user->password = $data['password'];
    if (!$user->save()) {
      $this->json('message', ['type' => 'error', 'message' => $user->fail()->getMessage()]);
    }

    unsetSession('user_id');
    setFlash('message', [
      'type' => 'success',
      'message' => 'A sua nova senha foi cadastro com sucesso'
    ]);
    $this->json('redirect', ['url' => $this->router->route('web.login')]);
  }
}
