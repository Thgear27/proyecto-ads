<?php
class Conexion
{
  public $conn;

  public function conectar()
  {
    $this->conn = new mysqli('db', 'root', '123', 'mboutique');

    if ($this->conn->connect_error) {
      die('Connection failed: ' . $this->conn->connect_error);
    }
  }

  public function desConectar()
  {
    if ($this->conn) {
      $this->conn->close();
    }
  }

  public function query($sql)
  {
    $result = $this->conn->query($sql);
    return $result;
  }

  public function execute($sql)
  {
    $result = $this->conn->query($sql);
    return $result;
  }
}
