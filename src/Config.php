<?php

/**
 * SITE CONFIG
 */
define('SITE', [
  'name' => 'Login PHP',
  'env' => 'local', // local | production
  'description' => 'Aprenda a construir uma aplicação de autenticação MVC de um sistema',
  'url' => 'http://localhost/login-php',
  'locale' => 'pt_BR',
  'domain' => 'localauth.com',
  'key' => 'btVJNfT78WtAZ2xWkTcntPxpMZYjL2eM'
]);

/**
 * PATH
 */
$dirRoot = dirname(__DIR__, 1);
define('PATH', [
  'root' => $dirRoot,
  'src' => $dirRoot . '/src',
  'views' => $dirRoot . '/views',
  'assets' => $dirRoot . '/assets'
]);

/**
 * SITE MINIFY
 */
if (SITE['env'] === 'local') {
  include PATH['src'] . '/Minify.php';
}

/**
 * DATABASE CONNECT
 */
define('DATA_LAYER_CONFIG', [
  "driver" => "mysql",
  "host" => "localhost",
  "port" => "3306",
  "dbname" => "login_php",
  "username" => "root",
  "passwd" => "password",
  "options" => [
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_CASE => PDO::CASE_NATURAL
  ]
]);

/**
 * SOCIAL CONFIG
 */
define('SOCIAL', [
  'facebook' => [
    'page' => '',
    'author' => '',
    'app_id' => ''
  ],
  'twitter' => [
    'creator' => '',
    'site' => ''
  ]
]);

/**
 * SESSION NAME
 */
define('SESSION_FLASH', 'flash');
define('SESSION_USER_LOGGED', 'user');
