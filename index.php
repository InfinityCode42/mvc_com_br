<?php
require 'backoffice/vendor/autoload.php';
require 'backoffice/src/routes/routers.php';


if ($_SERVER['HTTP_HOST'] == 'www.novastack.tech') {
  define('HOSTNAME', '127.0.0.1');
  define('PORT', '3306');
  define('USERNAME', 'u483821734_root');
  define('PASSWORD', 'alexandrE123&');
  define('DATABASE', 'u483821734_novastack');
}

if ($_SERVER['HTTP_HOST'] == 'localhost') {
  define('HOSTNAME', 'localhost');
  define('PORT', '3306');
  define('USERNAME', 'root');
  define('PASSWORD', 'root');
  define('DATABASE', 'xandinhouiui');
}

try {

  $pdo = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DATABASE . ";charset=utf8", USERNAME, PASSWORD);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  
} catch (PDOException $e) {
   echo 'Erro de conexão';
}

try {
  $uri = parse_url($_SERVER["REQUEST_URI"])["path"];
  $request = $_SERVER["REQUEST_METHOD"];

  if (!isset($router[$request])) {
    throw new Exception("A rota não existe");
  }

  if (!array_key_exists($uri, $router[$request])) {
    throw new Exception("A rota não existe");
  }

  $controller = $router[$request][$uri];
  $controller();
} catch (Exception $e) {
  $e->getMessage();
}
