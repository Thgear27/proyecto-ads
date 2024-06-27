<?php
class conexion
{
  public $conn;

  public function conectar()
  {
    $this->conn = new mysqli('db', 'root', '123', 'mboutique');

    if ($this->conn->connect_error) {
      die('Connection failed: ' . $this->conn->connect_error);
    }
  }

  public function desconectar()
  {
    if ($this->conn) {
      $this->conn->close();
    }
  }
}
