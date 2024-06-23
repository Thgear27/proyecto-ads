<?php
class Conexion
{
  private $conn;

  public function conectar()
  {
    $this->conn = new mysqli('db', 'dev', '123', 'mboutique');

    // Check connection
    if ($this->conn->connect_error) {
      die('Connection failed: ' . $this->conn->connect_error);
    }

    echo $this->conn->query('SELECT 1 + 1;');
  }

  protected function desConectar()
  {
    if ($this->conn) {
      $this->conn->close();
    }
  }
}
