<?php

namespace app\core;

use app\routes\Routes;
use app\support\RequestType;
use app\support\Uri;

// Tipos de rotas
class RoutersFilter
{
  private string $uri;
  private string $method;
  private array $routesRegistered;

  public function __construct()
  {
    $this->uri = Uri::get();
    $this->method = RequestType::get();
    $this->routesRegistered = Routes::get();
  }

  private function simpleRouter()
  {
    // uri - array - em que index
    if (array_key_exists($this->uri, $this->routesRegistered[$this->method])) {
      // Array de Rotas['GET']['/home']
      return $this->routesRegistered[$this->method][$this->uri];
    }

    return null;
  }
  private function dynamicRouter()
  {
    foreach ($this->routesRegistered[$this->method] as $index => $route) {
      $regex = str_replace('/', '\/', ltrim($index, '/'));
      if ($index !== '/' && preg_match("/^$regex$/", trim($this->uri, '/'))) {
        $routerRegisteredFound = $route;
        break;
      } else {
        $routerRegisteredFound = null;
      }
    }

    return $routerRegisteredFound;
  }

  public function get()
  {
    $router = $this->simpleRouter();

    // Verificar se a rota é simple
    if ($router) {
      return $router;
    }

    $router = $this->dynamicRouter();

    // Verificar se a rota é dinamica
    if ($router) {
      return $router;
    }

    return 'BaseController@notFound';
  }
}