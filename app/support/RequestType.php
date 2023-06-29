<?php
// Método estático para retornar a URI

namespace app\support;

class RequestType
{
  public static function get()
  {
    return strtolower($_SERVER['REQUEST_METHOD']);
  }
};