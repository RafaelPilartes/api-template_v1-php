<?php

namespace app\utils;

class Response
{
  public static function send($status, $data)
  {
    header('Content-Type: application/json');
    http_response_code($status);
    echo json_encode($data);
  }
}
