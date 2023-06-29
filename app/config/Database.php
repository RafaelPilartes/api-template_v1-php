<?php

class Database
{
  private $host = 'localhost';
  private $dbname = 'template';
  private $username = 'root';
  private $password = '';

  public function getConnection()
  {
    $conn = null;

    try {
      $conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      echo 'Erro na conexão com o banco de dados: ' . $e->getMessage();
    }

    return $conn;
  }
}