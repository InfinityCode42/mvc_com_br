<?php
require 'backoffice/vendor/autoload.php';
require 'backoffice/src/config/routes/routers.php';
require 'backoffice/src/config/database/db.php';

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
