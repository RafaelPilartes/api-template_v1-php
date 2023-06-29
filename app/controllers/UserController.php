<?php

namespace app\controllers;

require_once(__DIR__ . '/../models/User.php');
require_once(__DIR__ . '/../utils/Response.php');
require_once(__DIR__ . '/../config/Database.php');

use app\models\User;
use app\utils\Response;
use Database;
use PDO;

class UserController
{
  private $db;
  private $userModel;

  public $lastPart;

  public function __construct()
  {
    $currentURL = $_SERVER['REQUEST_URI'];

    // Obtém a última parte da URI
    $parts = explode('/', $currentURL);

    $this->lastPart = end($parts);

    $database = new Database();
    $this->db = $database->getConnection();
    $this->userModel = new User($this->db);
  }

  public function index()
  {
    echo "home";
  }

  public function getAllUsers()
  {
    $result = $this->userModel->getAll();
    $num = $result->rowCount();

    if ($num > 0) {
      $users_arr = array();
      $users_arr['data'] = array();

      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $user_item = array(
          'id' => $id,
          'name' => $name,
          'email' => $email
        );

        array_push($users_arr['data'], $user_item);
      }

      Response::send(200, $users_arr);
    } else {
      Response::send(404, array('message' => 'Nenhum usuário encontrado.'));
    }
  }

  public function getUserById()
  {
    $id = $this->lastPart;

    $result = $this->userModel->getById($id);
    $num = $result->rowCount();

    if ($num > 0) {
      $row = $result->fetch(PDO::FETCH_ASSOC);
      extract($row);
      $user_item = array(
        'id' => $id,
        'name' => $name,
        'email' => $email
      );

      Response::send(200, $user_item);
    } else {
      Response::send(404, array('message' => 'Usuário não encontrado.'));
    }
  }

  public function createUser()
  {
    // Obtém o conteúdo do corpo da requisição
    $requestBody = file_get_contents('php://input');

    // Decodifica o JSON em um array associativo
    $data = json_decode($requestBody, true);

    // var_dump($data);

    $name = $data['name'] ?? '';
    $email = $data['email'] ?? '';

    if (!empty($name) && !empty($email)) {
      if ($this->userModel->createNew($name, $email)) {
        Response::send(201, array('message' => 'Usuário criado com sucesso.'));
      } else {
        Response::send(500, array('message' => 'Ocorreu um erro ao criar o usuário.'));
      }
    } else {
      Response::send(400, array('message' => 'Dados insuficientes para criar o usuário.'));
    }
  }

  public function deleteUserById()
  {
    $id = $this->lastPart;

    if ($this->userModel->deleteById($id)) {
      Response::send(200, array('message' => 'Usuário excluído com sucesso.'));
    } else {
      Response::send(500, array('message' => 'Ocorreu um erro ao excluir o usuário.'));
    }
  }

  public function updateUser()
  {
    $id = $this->lastPart;

    // Obtém o conteúdo do corpo da requisição
    $requestBody = file_get_contents('php://input');

    // Decodifica o JSON em um array associativo
    $data = json_decode($requestBody, true);

    $name = $data['name'] ?? '';
    $email = $data['email'] ?? '';

    if (!empty($name) && !empty($email)) {
      if ($this->userModel->update($id, $name, $email)) {
        Response::send(200, array('message' => 'Usuário atualizado com sucesso.'));
      } else {
        Response::send(500, array('message' => 'Ocorreu um erro ao atualizar o usuário.'));
      }
    } else {
      Response::send(400, array('message' => 'Dados insuficientes para atualizar o usuário.'));
    }
  }


  // 404
  public function notFound()
  {
    echo "404";
  }
}
