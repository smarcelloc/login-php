<?php

namespace Src\Controllers;

use CoffeeCode\Optimizer\Optimizer;
use CoffeeCode\Router\Router;
use League\Plates\Engine;

abstract class Controller
{
  /**
   * @var \League\Plates\Engine
   */
  protected $view;

  /**
   * @var \CoffeeCode\Router\Router
   */
  protected $router;

  /**
   * @var \CoffeeCode\Optimizer\Optimizer
   */
  protected $seo;

  public function __construct(Router $router)
  {
    $this->router = $router;
    $this->setView();
    $this->setSeo();
  }

  /**
   * Configuração da View
   *
   * @return void
   */
  private function setView(): void
  {
    $this->view = new Engine(PATH['views'], 'php');
    $this->view->addData([
      'router' => $this->router
    ]);
  }

  /**
   * Configuração da otimização SEO
   *
   * @return void
   */
  private function setSeo(): void
  {
    $this->seo = new Optimizer();
    $this->seo->openGraph(SITE['name'], SITE['locale'], 'article');
    $this->seo->publisher(SOCIAL['facebook']['page'], SOCIAL['facebook']['author']);
    $this->seo->twitterCard(SOCIAL['twitter']['creator'], SOCIAL['twitter']['site'], SITE['domain']);
    $this->seo->facebook(SOCIAL['facebook']['app_id']);
  }

  /**
   * Renderização da página WEB
   *
   * @param string $view
   * @param array $data
   * @return void
   */
  protected function page(string $page, array $data = []): void
  {
    ob_start();
    echo $this->view->render('pages/' . $page, $data);
    ob_end_flush();
  }

  /**
   * Response via JSON
   *
   * @param integer $status
   * @param array $data
   * @return never
   */
  protected function json(string $params, array $data = [])
  {
    header('Content-Type: application/json');
    echo json_encode([$params => $data]);
    exit;
  }
}
