<?php

namespace Src\Controllers;

use CoffeeCode\Router\Router;

class App extends Controller
{
  public function __construct(Router $router)
  {
    parent::__construct($router);
  }
}
