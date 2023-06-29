<?php

namespace app\controllers;

class BaseController
{
  public function index()
  {
    echo "home";
  }

  // 404
  public function notFound()
  {
    echo "404";
  }
}
