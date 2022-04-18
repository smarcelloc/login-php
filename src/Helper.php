<?php

/**
 * Verifica se aplicação está local
 *
 * @return boolean
 */
function isLocal(): bool
{
  return SITE['env'] === 'local';
}

/**
 * Verifica se aplicação está em produção
 *
 * @return boolean
 */
function isProduction(): bool
{
  return SITE['env'] === 'production';
}

/**
 * Retorna o caminho do arquivo contido no diretório assets
 *
 * @param string $path
 * @return string
 */
function asset(string $path): string
{
  if (isLocal()) {
    $path .= '?time=' . time();
  }

  return SITE['url'] . '/assets' . $path;
}

/**
 * Image da página Web para otimização SEO
 *
 * @param string $urlImage
 * @return string
 */
function routeImage(?string $urlImage = null): string
{
  if (empty($urlImage)) {
    return '';
  }

  return 'https://via.placeholder.com/150/0000FF/808080?Text=' . $urlImage;
}

/**
 * Criar uma sessão flash
 *
 * @param string $key
 * @param string $value
 * @return void
 */
function setFlash(string $key, string $value): void
{
  $_SESSION[SESSION_FLASH][$key] = $value;
}

/**
 * Retorna o valor da sessão flash
 *
 * @param string $key
 * @return string|null
 */
function getFlash(string $key): ?string
{
  if (!isset($_SESSION[SESSION_FLASH][$key])) {
    return null;
  }

  $value = $_SESSION[SESSION_FLASH][$key];
  unset($_SESSION[SESSION_FLASH][$key]);

  return $value;
}

/**
 * Destrói toda sessão flash
 *
 * @return void
 */
function destroyFlash(): void
{
  unset($_SESSION[SESSION_FLASH]);
}

/**
 * Verificar se o usuário está logado no sistema
 *
 * @return boolean
 */
function isUserLogged(): bool
{
  return !empty($_SESSION[SESSION_USER_LOGGED]);
}
