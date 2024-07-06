function getProductoInfo(id) {
  let nombre = document.querySelector(`[data-producto-nombre="${id}"]`).innerHTML;
  let precio = document.querySelector(`[data-producto-precio-unitario="${id}"]`).innerHTML;
  let cantidad = document.querySelector(`[data-producto-cantidad="${id}"]`).innerHTML;
  let descripcion = document.querySelector(`[data-producto-descripcion="${id}"]`).innerHTML;

  return {
    id,
    nombre,
    precio: parseFloat(precio),
    cantidad: parseInt(cantidad),
    descripcion,
  };
}

function actualizarTablaProductosSolicitados() {
  let productos = JSON.parse(localStorage.getItem("productos_solicitados")) || [];
  let tbody = document.querySelector("[data-tbody-solicitar]");
  tbody.innerHTML = "";

  if (productos.length === 0) {
    tbody.innerHTML = `
      <tr>
        <td colspan="6">No se encontraron productos.</td>
      </tr>
    `;
  } else {
    productos.forEach((producto, index) => {
      tbody.innerHTML += `
        <tr>
          <td>${producto.id}</td>
          <td>${producto.nombre}</td>
          <td>${producto.descripcion}</td>
          <td><input data-input-cantidad="${producto.id}" style="width: 100px;" type="number" value="${producto.cantidad}"></td>
          <td>${producto.precio}</td>
          <td>
            <button data-button-eliminar="${producto.id}" class="destroy">Eliminar</button>
          </td>
        </tr>
      `;
    });
  }

  actualizarEliminarBotones();
  actualizarInputsCantidad();
}

// ----------------------------------------------------------------------
// Función evento para añadir un producto al los productos solicitados
function anadirProducto(id) {
  return () => {
    let producto = getProductoInfo(id);
    let productos = JSON.parse(localStorage.getItem("productos_solicitados")) || [];

    if (!productos.some((p) => p.id === producto.id)) {
      productos.push(producto);
    }

    localStorage.setItem("productos_solicitados", JSON.stringify(productos));
    actualizarTablaProductosSolicitados();
  };
}
// ----------------------------------------------------------------------

// ----------------------------------------------------------------------
// Función evento para eliminar un producto de los productos solicitados
function eliminarProducto(id) {
  return () => {
    let productos = JSON.parse(localStorage.getItem("productos_solicitados")) || [];
    let productosFiltrados = productos.filter((producto) => producto.id !== id);

    localStorage.setItem("productos_solicitados", JSON.stringify(productosFiltrados));
    actualizarTablaProductosSolicitados();
  };
}
// ----------------------------------------------------------------------

function actualizarEliminarBotones() {
  let eliminarBotones = document.querySelectorAll("[data-button-eliminar]");
  eliminarBotones.forEach((eliminarBoton) => {
    eliminarBoton.addEventListener("click", eliminarProducto(eliminarBoton.attributes["data-button-eliminar"].value));
  });
}

function actualizarAnadirBotones() {
  let anadirBotones = document.querySelectorAll("[data-button-anadir]");
  anadirBotones.forEach((anadirBoton) => {
    anadirBoton.addEventListener("click", anadirProducto(anadirBoton.attributes["data-button-anadir"].value));
  });
}

function modificarCantidadProductoSolicitado(id) {
  return () => {
    let productos = JSON.parse(localStorage.getItem("productos_solicitados")) || [];
    let producto = productos.find((producto) => producto.id === id);
    let cantidadProductoAlmacen = getProductoInfo(id).cantidad;

    if (producto) {
      let cantidadModificada = document.querySelector(`[data-input-cantidad="${id}"]`).value;
      if (cantidadModificada < 1) {
        producto.cantidad = 1;
      } else if (cantidadModificada > cantidadProductoAlmacen) {
        producto.cantidad = cantidadProductoAlmacen;
      } else {
        producto.cantidad =cantidadModificada 
      }
      document.querySelector(`[data-input-cantidad="${id}"]`).value = producto.cantidad;
    }

    localStorage.setItem("productos_solicitados", JSON.stringify(productos));
  };
}

function actualizarInputsCantidad() {
  let inputsCantidad = document.querySelectorAll("[data-input-cantidad]");
  inputsCantidad.forEach((inputCantidad) => {
    inputCantidad.addEventListener(
      "change",
      modificarCantidadProductoSolicitado(inputCantidad.attributes["data-input-cantidad"].value)
    );
  });
}

function generarSolicitud(event) {
  event.preventDefault();

  let productos = JSON.parse(localStorage.getItem("productos_solicitados")) || [];

  // Crear un formulario dinámicamente
  const form = document.createElement("form");
  form.method = "POST";
  form.action = "/moduloVentas/getEmitirSolicitudEnvioProducto.php";

  // Agregar los productos como un campo oculto
  const productosField = document.createElement("input");
  productosField.type = "hidden";
  productosField.name = "productos";
  productosField.value = JSON.stringify(productos);
  form.appendChild(productosField);

  // Agregar un campo de validación para verificar el botón
  const validacionBotonField = document.createElement("input");
  validacionBotonField.type = "hidden";
  validacionBotonField.name = "btnGenerarSolicitudEnvio";
  validacionBotonField.value = "miBoton";
  form.appendChild(validacionBotonField);

  // Agregar el formulario al cuerpo del documento y enviarlo
  document.body.appendChild(form);
  localStorage.removeItem("productos_solicitados");
  form.submit();
}

function actualizarBotonEmitirSolicitud() {
  let botonEmitirSolicitud = document.querySelector("[data-button-emitir-solicitud]");
  botonEmitirSolicitud.addEventListener("click", generarSolicitud);
}

document.addEventListener("DOMContentLoaded", function () {
  actualizarTablaProductosSolicitados();
  actualizarAnadirBotones();
  actualizarEliminarBotones();
  actualizarInputsCantidad();
  actualizarBotonEmitirSolicitud();
});
