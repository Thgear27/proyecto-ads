<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/modelos/conexion.php');

class EproductoAlmacen extends conexion
{
  function reducirStock($idSolicitud)
  {
    $this->conectar();
    $sql = "SELECT * FROM Detalle_solicitud_envio WHERE id_solicitud = '$idSolicitud'";
    $respuesta = $this->conn->query($sql);

    // Verificar si se encontró alguna fila
    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return null;
    }

    while ($fila = $respuesta->fetch_assoc()) {
      $idProductoAlmacen = $fila['id_producto_almacen'];
      $cantidad = $fila['cantidad'];

      $sqlCantidad = "SELECT cantidad FROM Producto_almacen WHERE id_producto_almacen = '$idProductoAlmacen'";
      $respuestaCantidad = $this->conn->query($sqlCantidad);
      $filaCantidad = $respuestaCantidad->fetch_assoc();
      $cantidadActual = $filaCantidad['cantidad'];

      $cantidadActual -= $cantidad;

      $sqlUpdate = "UPDATE Producto_almacen SET cantidad = '$cantidadActual' WHERE id_producto_almacen = '$idProductoAlmacen'";
      $this->conn->query($sqlUpdate);
    }

    $this->desconectar();
    return true;
  }

  function actualizarProducto($txtProducto, $txtDescripcion, $txtCantidad, $txtPrecio, $txtId)
  {
    $this->conectar();

    $sql = "UPDATE Producto_almacen 
            SET nombre_producto = '$txtProducto', 
                descripcion = '$txtDescripcion', 
                cantidad = '$txtCantidad', 
                precio_unitario = '$txtPrecio' 
            WHERE id_producto_almacen = '$txtId'";

    $result = $this->conn->query($sql);

    $this->desconectar();

    // Verificar si la consulta fue exitosa
    if ($result === TRUE) {
      return true;
    } else {
      return false;
    }
  }

  function verificarProductoPorNombre($txtProducto, $txtId = null)
  {
    $this->conectar();
    $sql = "SELECT * FROM Producto_almacen WHERE nombre_producto = '$txtProducto'";

    if ($txtId != null) {
      $sql .= " AND id_producto_almacen != '$txtId'";
    }

    $respuesta = $this->conn->query($sql);

    // Verificar si se encontró alguna fila
    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return null;
    }

    $this->desconectar();
    return true;
  }

  function registrarProducto($txtProducto, $txtDescripcion, $txtCantidad, $txtPrecio)
  {
    $this->conectar();
    $sql = "INSERT INTO Producto_almacen (nombre_producto, descripcion, cantidad, precio_unitario) VALUES ('$txtProducto', '$txtDescripcion', '$txtCantidad', '$txtPrecio')";
    $this->conn->query($sql);
    $this->desconectar();
  }

  public function obtenerProductosAlmacen()
  {
    $this->conectar();
    $sql = "SELECT * FROM Producto_almacen";
    $respuesta = $this->conn->query($sql);

    // Verificar si se encontró alguna fila
    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return null;
    }

    // Crear un array para almacenar los productos
    $productos = array();
    while ($fila = $respuesta->fetch_assoc()) {
      $productos[] = $fila;
    }

    $this->desconectar();
    return $productos;
  }

  public function obtenerProductosAlmacenPorNombre($nombre)
  {
    $this->conectar();
    $sql = "SELECT * FROM Producto_almacen WHERE nombre_producto LIKE '%$nombre%'";
    $respuesta = $this->conn->query($sql);

    // Verificar si se encontró alguna fila
    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return null;
    }

    // Crear un array para almacenar los productos
    $productos = array();
    while ($fila = $respuesta->fetch_assoc()) {
      $productos[] = $fila;
    }

    $this->desconectar();
    return $productos;
  }

  public function eliminarProductoAlmacen($idProductoAlmacen)
  {
    $this->conectar();
    $sql = "DELETE FROM Producto_almacen WHERE id_producto_almacen = '$idProductoAlmacen'";
    $this->conn->query($sql);
    $this->desconectar();
  }
}
