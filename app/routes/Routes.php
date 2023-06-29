<?php

namespace app\routes;

class Routes
{
  public static function get()
  {
    return [
      'get' => [
        // BASE ROUTES
        '/user/getall' => 'UserController@getAllUsers',
      ],
      'post' => [
        // '/search/.*' => 'UserController@getUserById',
        '/user/search/[0-9]+' => 'UserController@getUserById',
        '/user/create' => 'UserController@createUser',
      ],
      'delete' => [
        '/user/delete/[0-9]+' => 'UserController@deleteUserById',
      ],
      'put' => [
        '/user/update/[0-9]+' => 'UserController@updateUser',
      ],
    ];
  }
};
