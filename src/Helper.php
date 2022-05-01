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
 * Criar sessão com criptografia.
 *
 * @param string $key
 * @param mixed $value
 * @return void
 */
function setSession(string $key, $value)
{
  $valueToString = json_encode($value);

  $_SESSION[$key] = encrypt($valueToString);
}

/**
 * Recuperar o texto da sessão.
 *
 * @param string $key
 * @return string
 */
function getSession(string $key)
{
  $hash = $_SESSION[$key];
  $value = decrypt($hash);

  return json_decode($value);
}

/**
 * Apagar a sessão.
 *
 * @param string $key
 * @return void
 */
function unsetSession(string $key)
{
  unset($_SESSION[$key]);
}

/**
 * Descriptografar o hash e recuperar a mensagem.
 *
 * @param string $hash
 * @return string
 */
function decrypt(string $hash)
{
  $text = base64_decode($hash);
  $cipherIvLength = openssl_cipher_iv_length('AES-256-CBC');

  $iv = mb_substr($text, 0, $cipherIvLength, '8bit');
  $hashOpenssl = mb_substr($text, $cipherIvLength, null, '8bit');

  return openssl_decrypt($hashOpenssl, 'AES-256-CBC', SITE['key'], OPENSSL_RAW_DATA, $iv);
}

/**
 * Criptografar a mensagem informada.
 *
 * @param string $text
 * @return void
 */
function encrypt(string $text)
{
  $iv = random_bytes(openssl_cipher_iv_length('AES-256-CBC'));
  $hash = openssl_encrypt($text, 'AES-256-CBC', SITE['key'], OPENSSL_RAW_DATA, $iv);

  return base64_encode($iv . $hash);
}
