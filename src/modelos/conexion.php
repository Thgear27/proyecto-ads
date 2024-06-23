<?php
class Conexion
{
  private $conn;

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
    $this->conectar();
    $result = $this->conn->query($sql);
    $this->desConectar();
    return $result;
  }

  public function execute($sql)
  {
    $this->conectar();
    $result = $this->conn->query($sql);
    $this->desConectar();
    return $result;
  }
}
