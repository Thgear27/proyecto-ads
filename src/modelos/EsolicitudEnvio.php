<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/modelos/conexion.php');

/*
-- --------------------------------------------------------
-- Tabla para productos en tienda
-- --------------------------------------------------------

CREATE TABLE `Producto_tienda` (
  `id_producto_tienda` int(11) NOT NULL,
  `nombre_producto` varchar(60) DEFAULT NULL,
  `descripcion` varchar(90) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_unitario` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcado de datos para la tabla `Producto_tienda`
INSERT INTO `Producto_tienda` (`id_producto_tienda`, `nombre_producto`, `descripcion`, `cantidad`, `precio_unitario`) VALUES
(1, 'Mochila', 'Azul', 5, 30);

-- Indices de la tabla `Producto_tienda`
ALTER TABLE `Producto_tienda`
  ADD PRIMARY KEY (`id_producto_tienda`);

-- AUTO_INCREMENT de la tabla `Producto_tienda`
ALTER TABLE `Producto_tienda`
  MODIFY `id_producto_tienda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

-- --------------------------------------------------------
-- Tabla para solicitudes de envío
-- --------------------------------------------------------

CREATE TABLE `Solicitud_envio` (
  `id_solicitud` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_solicitud` datetime DEFAULT CURRENT_TIMESTAMP,
  `estado` enum('pendiente','enviado','recibido') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Indices de la tabla `Solicitud_envio`
ALTER TABLE `Solicitud_envio`
  ADD PRIMARY KEY (`id_solicitud`),
  ADD KEY `id_usuario` (`id_usuario`);

-- AUTO_INCREMENT de la tabla `Solicitud_envio`
ALTER TABLE `Solicitud_envio`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- --------------------------------------------------------
-- Tabla para detalles de la solicitud de envío
-- --------------------------------------------------------

CREATE TABLE `Detalle_solicitud_envio` (
  `id_detalle` int(11) NOT NULL,
  `id_solicitud` int(11) NOT NULL,
  `id_producto_almacen` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Indices de la tabla `Detalle_solicitud_envio`
ALTER TABLE `Detalle_solicitud_envio`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_solicitud` (`id_solicitud`),
  ADD KEY `id_producto_almacen` (`id_producto_almacen`);

-- AUTO_INCREMENT de la tabla `Detalle_solicitud_envio`
ALTER TABLE `Detalle_solicitud_envio`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- Restricciones para tablas volcadas
ALTER TABLE `Solicitud_envio`
  ADD CONSTRAINT `solicitud_envio_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `Usuario` (`id_usuario`);

ALTER TABLE `Detalle_solicitud_envio`
  ADD CONSTRAINT `detalle_solicitud_envio_ibfk_1` FOREIGN KEY (`id_solicitud`) REFERENCES `Solicitud_envio` (`id_solicitud`),
  ADD CONSTRAINT `detalle_solicitud_envio_ibfk_2` FOREIGN KEY (`id_producto_almacen`) REFERENCES `Producto_almacen` (`id_producto_almacen`);

*/


/*
  Consulta para Generar una Solicitud con los Productos que Quieras
  Para esta acción, necesitas ejecutar dos consultas: una para insertar la solicitud y otra para insertar los detalles de la solicitud.

  Insertar la solicitud:

  sql
  Copy code
  INSERT INTO Solicitud_envio (id_usuario) VALUES (2);
  Nota: Reemplaza 2 con el ID del usuario que está haciendo la solicitud.

  Obtener el ID de la última solicitud insertada:

  sql
  Copy code
  SELECT LAST_INSERT_ID() AS id_solicitud;
  Insertar los detalles de la solicitud:

  sql
  Copy code
  INSERT INTO Detalle_solicitud_envio (id_solicitud, id_producto_almacen, cantidad) VALUES 
  (LAST_INSERT_ID(), 1, 3),
  (LAST_INSERT_ID(), 2, 5),
  (LAST_INSERT_ID(), 3, 10);
  Nota: Reemplaza 1, 2, 3 con los IDs de los productos de almacén que deseas solicitar, y 3, 5, 10 con las cantidades correspondientes.
 */

class EsolicitudEnvio extends conexion
{
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
