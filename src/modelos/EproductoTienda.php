<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/modelos/conexion.php');

class EproductoTienda extends conexion
{
  function aumentarStock($idSolicitud)
  {
    $this->conectar();
    $sql = "SELECT * FROM Detalle_solicitud_envio WHERE id_solicitud = '$idSolicitud'";
    $respuesta = $this->conn->query($sql);

    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return null;
    }

    while ($fila = $respuesta->fetch_assoc()) {
      $idProductoAlmacen = $fila['id_producto_almacen'];
      $cantidad = $fila['cantidad'];

      $sqlCantidad = "SELECT cantidad FROM Producto_tienda WHERE id_producto_tienda = '$idProductoAlmacen'";
      $respuestaCantidad = $this->conn->query($sqlCantidad);
      $filaCantidad = $respuestaCantidad->fetch_assoc();
      $cantidadActual = $filaCantidad['cantidad'];

      if ($cantidadActual == null) {
        $sqlProductoAlmacen = "SELECT * FROM Producto_almacen WHERE id_producto_almacen = '$idProductoAlmacen'";
        $respuestaProductoAlmacen = $this->conn->query($sqlProductoAlmacen);

        if ($respuestaProductoAlmacen->num_rows == 0) {
          $this->desconectar();
          return null;
        }

        $filaProductoAlmacen = $respuestaProductoAlmacen->fetch_assoc();
        $nombreProducto = $filaProductoAlmacen['nombre_producto'];
        $descripcion = $filaProductoAlmacen['descripcion'];
        $precioUnitario = $filaProductoAlmacen['precio_unitario'];
        $sqlInsert = "INSERT INTO Producto_tienda (id_producto_tienda, nombre_producto, descripcion, cantidad, precio_unitario) VALUES ('$idProductoAlmacen', '$nombreProducto', '$descripcion', '$cantidad', '$precioUnitario')";

        $this->conn->query($sqlInsert);
      } else {
        $cantidadActual += $cantidad;

        $sqlUpdate = "UPDATE Producto_tienda SET cantidad = '$cantidadActual' WHERE id_producto_tienda = '$idProductoAlmacen'";
        $this->conn->query($sqlUpdate);
      }
    }

    $this->desconectar();

    return true;
  }
}
