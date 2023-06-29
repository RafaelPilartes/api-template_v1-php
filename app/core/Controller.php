<?php

namespace app\core;

use Exception;

class Controller
{
  public function execute(string $router)
  {
    // Verificar de o @ existe no $router
    if (!str_contains($router, '@')) {
      throw new Exception("A rota está registada com o formato errado");
    }

    // Remover o @ do $router, e atribuir o que está antes e o depois para duas variaveis:
    list($controller, $method) = explode('@', $router);

    $namespace = "app\controllers\\";

    $controllerNamespace = $namespace . $controller;

    // Verificar se esse o controller existe
    if (!class_exists($controllerNamespace)) {
      throw new Exception("O controller {$controllerNamespace} não existe");
    }

    $controller = new $controllerNamespace;

    // Verificar se esse o método existe
    if (!method_exists($controller, $method)) {
      throw new Exception("O método {$method} não existe no controller {$controllerNamespace}");
    }

    // $params = new ControllerParams;
    // $params = $params->get($router);

    $controller->$method();
  }
}