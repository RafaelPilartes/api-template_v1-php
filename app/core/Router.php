<?php

namespace app\core;

class Router
{
  public static function run()
  {
    try {
      $routerRegistered = new RoutersFilter;
      $router = $routerRegistered->get();

      $controller = new Controller;
      $controller->execute($router);
    } catch (\Throwable $th) {
      echo $th->getMessage();
    }
  }
}
