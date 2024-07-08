<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/modelos/conexion.php');

class EsolicitudEnvio extends conexion
{
  public function confirmarIngresoProductos($idSolicitud)
  {
    $this->conectar();
    $sql = "UPDATE Solicitud_envio SET estado = 'recibido' WHERE id_solicitud = $idSolicitud";
    $respuesta = $this->conn->query($sql);
    $this->desconectar();
    return $respuesta === true;
  }

  public function obtenerSolicitud($idSolicitud)
  {
    $this->conectar();
    $sql = "SELECT * FROM Solicitud_envio WHERE id_solicitud = $idSolicitud";
    $respuesta = $this->conn->query($sql);

    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return null;
    }

    $solicitud = $respuesta->fetch_assoc();
    $this->desconectar();
    return $solicitud;
  }

  public function cambiarEstadoSolicitud($idSolicitud, $estado)
  {
    $this->conectar();
    $sql = "UPDATE Solicitud_envio SET estado = '$estado' WHERE id_solicitud = $idSolicitud";
    $respuesta = $this->conn->query($sql);
    $this->desconectar();
    return $respuesta === true;
  }

  public function obtenerProductosSolicitud($idSolicitud)
  {

    $this->conectar();
    $sql = "SELECT * FROM Detalle_solicitud_envio WHERE id_solicitud = $idSolicitud";
    $respuesta = $this->conn->query($sql);

    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return null;
    }

    $productos = array();

    while ($fila = $respuesta->fetch_assoc()) {
      $id_producto_almacen = $fila['id_producto_almacen'];
      $cantidad = $fila['cantidad'];

      $sql = "SELECT * FROM Producto_almacen WHERE id_producto_almacen = $id_producto_almacen";
      $respuesta_producto = $this->conn->query($sql);

      if ($respuesta_producto->num_rows == 0) {
        $this->desconectar();
        return null;
      }

      $producto = $respuesta_producto->fetch_assoc();
      $producto['cantidad_solicitada'] = $cantidad;
      $productos[] = $producto;
    }

    $this->desconectar();

    return $productos;
  }

  public function obtenerSolicitudes()
  {
    $this->conectar();
    $sql = "SELECT * FROM Solicitud_envio";
    $respuesta = $this->conn->query($sql);

    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return null;
    }

    $solicitudes = array();
    while ($fila = $respuesta->fetch_assoc()) {
      $solicitudes[] = $fila;
    }

    // Obtener la cantidad total productos que se van a ralizar en este envio

    foreach ($solicitudes as $key => $solicitud) {
      $id_solicitud = $solicitud['id_solicitud'];
      $sql = "SELECT SUM(cantidad) AS cantidad_total FROM Detalle_solicitud_envio WHERE id_solicitud = $id_solicitud";
      $respuesta = $this->conn->query($sql);

      if ($respuesta->num_rows == 0) {
        $this->desconectar();
        return null;
      }

      $fila = $respuesta->fetch_assoc();
      $solicitudes[$key]['cantidad_total'] = $fila['cantidad_total'];
    }


    $this->desconectar();
    return $solicitudes;
  }

  public function generarSolicitudEnvioProductos($productos, $email)
  {
    $this->conectar();
    $sql = "SELECT id_usuario FROM Usuario WHERE email = '$email'";
    $respuesta = $this->conn->query($sql);

    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return false;
    }

    $fila = $respuesta->fetch_assoc();
    $id_usuario = $fila['id_usuario'];

    // Insertar la solicitud
    $sql = "INSERT INTO Solicitud_envio (id_usuario) VALUES ($id_usuario)";
    if (!$this->conn->query($sql)) {
      $this->desconectar();
      return false;
    }

    // Obtener el ID de la última solicitud insertada
    $sql = "SELECT LAST_INSERT_ID() AS id_solicitud";
    $respuesta = $this->conn->query($sql);

    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return false;
    }

    $fila = $respuesta->fetch_assoc();
    $id_solicitud = $fila['id_solicitud'];

    foreach ($productos as $producto) {
      $id_producto_almacen = $producto['id'];
      $cantidad = $producto['cantidad'];

      $sql = "INSERT INTO Detalle_solicitud_envio (id_solicitud, id_producto_almacen, cantidad) VALUES ($id_solicitud, $id_producto_almacen, $cantidad)";
      if (!$this->conn->query($sql)) {
        $this->desconectar();
        return false;
      }
    }

    $this->desconectar();
    return true;
  }
}
