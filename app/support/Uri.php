<?php
// Método estático para retornar a URI

namespace app\support;

class Uri
{
  public static function get()
  {
    // trim() -> retirar espaços em branco
    return trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
  }
};
