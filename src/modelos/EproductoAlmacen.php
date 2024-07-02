<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/modelos/conexion.php');

class EproductoAlmacen extends conexion
{
    function buscarProductoPorNombre($txtProducto)
    {
        $this->conectar();
        $sql = "SELECT * FROM Producto_almacen WHERE nombre_producto = '$txtProducto'";
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
}
