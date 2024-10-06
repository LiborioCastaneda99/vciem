$(document).ready(function () {
  cargar_proveedores("", "lstProveedoresFact", "");
  cargar_bodega("", "lstBodegaFact", "");
  cargar_vendedores("", "lstVendedoresFact", "");
  cargar_oficinas("", "lstSucursalFact", "");
  cargar_tipos_movimientos("", "lstTipoMovimientoFact", "");
  cargar_transportadores("", "lstTransporteFact", "");
  cargar_factura("", "lstFacturaFact", "");
  actualizarTotales();
  mostrarNoHayRegistros();

  const inputFecha = document.getElementById("fechaFact");
  const today = new Date().toISOString().split("T")[0]; // Obtiene la fecha actual en formato YYYY-MM-DD
  inputFecha.value = today;
});

// Funcion para cargar las listas select con opcion de busqueda
$("#btnBuscarProducto").click(function () {
  $("#buscarProductos").modal("show");
  cargar_productos();
});

// Función para mostrar el mensaje de error debajo del input de cambio
function mostrarMensajeError(mensaje) {
  // Verificar si ya hay un mensaje de error presente
  var errorMessage = document.querySelector(".error-message");
  if (!errorMessage) {
    // Crear un elemento para el mensaje de error
    errorMessage = document.createElement("div");
    errorMessage.className = "error-message text-danger";
    errorMessage.textContent = mensaje;

    // Insertar el mensaje de error después del input de cambio
    var facCambioInput = document.getElementById("fac_cambio");
    facCambioInput.parentNode.insertBefore(
      errorMessage,
      facCambioInput.nextSibling
    );
  }
}

// Función para ocultar el mensaje de error
function ocultarMensajeError() {
  var errorMessage = document.querySelector(".error-message");
  if (errorMessage) {
    errorMessage.parentNode.removeChild(errorMessage);
  }
}

// cargamos la tabla de los productos
function cargar_productos() {
  $("#tablaListadoProductos").dataTable().fnDestroy();
  $("#tablaListadoProductos").DataTable({
    responsive: true,
    dom: "lfrtip",
    columnDefs: [
      {
        // El numero correspode a la ultima columna iniciando en 0
        targets: [2, 3, 4, 5],
        orderable: false,
        width: "70px",
        className: "text-center",
      },
      {
        // El numero correspode a la ultima columna iniciando en 0
        targets: [0],
        width: "90px",
      },
    ],
    language: {
      url: "vendors/datatables.net/spanish.txt",
    },
    lengthMenu: [10, 25, 50, 75, 100, 500, 1000],
    lengthChange: true,
    order: [[0, "desc"]],
    processing: true,
    serverSide: true,
    serverMethod: "post",
    ajax: {
      url: "ajax/articulosajax.php",
      data: {
        proceso: "listado_productos",
      },
      method: "POST",
    },
    columns: [
      {
        data: "codigo",
      },
      {
        data: "nombre",
      },
      {
        data: "existencia",
      },
      {
        data: "vlr_minimo",
      },
      {
        data: "vlr_sugerido",
      },
      {
        data: "comprar",
      },
    ],
    drawCallback: function () {
      $(".btn-group").addClass("btn-group-sm");
    },
  });
}

var contadorProductos = 0;

// agregar producto a los inputs
function agregar(id) {
  // Hacer la solicitud AJAX al servidor
  var urlprocess = "ajax/articulosajax.php";
  $.ajax({
    type: "POST",
    url: urlprocess,
    data: "id=" + id + "&proceso=get_id",
    dataType: "json",
    success: function (data) {
      // Función para agregar un nuevo campo de entrada para un producto
      contadorProductos++; // Incrementar el contador de productos

      document.getElementById("codigo").value = data[0].codigo;
      document.getElementById("descripcion").value = data[0].nombre;
      document.getElementById("um").value = data[0].umedida;
      document.getElementById("cant").value = 1;
      document.getElementById("vlr_unitario").value = data[0].pv1;
      document.getElementById("desc").value = data[0].pdes;
      document.getElementById("imp").value = data[0].iva;
      document.getElementById("vlr_total").value = parseFloat(data[0].pv1);
      $("#buscarProductos").modal("hide");

      const codigoCampo = document.getElementById("codigo");

      // Obtener referencia a los demás campos de entrada de texto
      const campos = document.querySelectorAll(
        'input[type="text"]:not(#codigo)'
      );

      // Verificar si el campo de código está vacío
      if (codigoCampo.value.trim() === "") {
        // Si está vacío, iterar sobre los otros campos y deshabilitarlos
        campos.forEach(function (campo) {
          campo.disabled = true;
        });
      } else {
        // Si el campo de código tiene un valor, habilitar los otros campos
        campos.forEach(function (campo) {
          campo.disabled = false;
        });
      }
    },
    error: function () {
      // Error en la inserción, muestra mensaje de error con SweetAlert
      notificacion("Error", "error", response.message);
    },
  });
}

//onchange para buscar el codigo y si existe que pinte datos
$("#codigo").change(function () {
  // Obtener el valor del código
  var codigo = $(this).val();

  // Realizar la solicitud AJAX al servidor
  $.ajax({
    url: "ajax/articulosajax.php", // La URL del script PHP que maneja la solicitud
    method: "POST", // El método de solicitud
    dataType: "json", // El tipo de datos que esperamos recibir del servidor
    data: { id: codigo, proceso: "get_id_productos" }, // Los datos que se enviarán al servidor

    // Función que se ejecuta cuando la solicitud se completa con éxito
    success: function (response) {
      // Verificar si se encontraron datos
      if (response.status == "success") {
        // Mostrar los datos obtenidos en los campos de entrada

        document.getElementById("codigo").value = response.datos[0].codigo;
        document.getElementById("descripcion").value = response.datos[0].nombre;
        document.getElementById("um").value = response.datos[0].umedida;
        document.getElementById("cant").value = 1;
        document.getElementById("vlr_unitario").value = response.datos[0].pv1;
        document.getElementById("desc").value = response.datos[0].pdes;
        document.getElementById("imp").value = response.datos[0].iva;
        document.getElementById("vlr_total").value = parseFloat(
          response.datos[0].pv1
        );
        // Y así sucesivamente con los demás campos

        const codigoCampo = document.getElementById("codigo");

        // Obtener referencia a los demás campos de entrada de texto
        const campos = document.querySelectorAll(
          'input[type="text"]:not(#codigo)'
        );
        // Verificar si el campo de código está vacío
        if (codigoCampo.value.trim() === "") {
          // Si está vacío, iterar sobre los otros campos y deshabilitarlos
          campos.forEach(function (campo) {
            campo.disabled = true;
          });
        } else {
          // Si el campo de código tiene un valor, habilitar los otros campos
          campos.forEach(function (campo) {
            campo.disabled = false;
          });
        }
      } else {
        notificacion("Error", "error", response.message);

        // Si no se encontraron datos, limpiar los campos
        document.getElementById("codigo").value = "";
        document.getElementById("descripcion").value = "";
        document.getElementById("um").value = "";
        document.getElementById("cant").value = "";
        document.getElementById("vlr_unitario").value = "";
        document.getElementById("desc").value = "";
        document.getElementById("imp").value = "";
        document.getElementById("vlr_total").value = "";
      }
    },

    // Función que se ejecuta si hay un error en la solicitud
    error: function (xhr, status, error) {
      // Manejar el error según sea necesario
      console.error("Error en la solicitud AJAX:", error);
    },
  });
});

// onchange de los campos manipulables para hacer calculos si se mueve alguno
$('.datos_productos input[type="text"]').change(function () {
  // Obtener el valor de la cantidad y del valor unitario
  var cantidad = parseFloat($("#cant").val());
  var valorUnitario = parseFloat($("#vlr_unitario").val());
  var imp = parseFloat($("#imp").val());
  var descuento = parseFloat($("#desc").val());

  // Calcular el valor del descuento y el valor final
  var nuevoValorUnitario = valorUnitario;
  var valorFinal = nuevoValorUnitario * cantidad;
  var valorImp = (valorFinal * imp) / 100;
  var valorDesc = (valorFinal * descuento) / 100;

  // Calcular el valor del descuento y el valor final
  var nuevoValorUnitario = valorUnitario;
  var valorFinal = Math.ceil(nuevoValorUnitario * cantidad + valorImp);

  // $("#vlr_unit_final").val(nuevoValorUnitario);
  $("#vlr_total").val(valorFinal);
});

// onchange de los campos manipulables para hacer calculos si se mueve alguno
$('.datos_factuacion input[type="text"]').change(function () {
  // Obtener el valor de la cantidad y del valor unitario
  var valorRetefuenteFact = parseFloat($("#valorRetefuenteFact").val());
  var valorParcialFact = parseFloat($("#valorParcialFact").val());

  // Calcular el valor del descuento y el valor final
  var valorParcialOpe = valorParcialFact - valorRetefuenteFact;
  // actualizarTotales();
  // $("#vlr_unit_final").val(nuevoValorUnitario);
  $("#valorParcialFact").val(valorParcialOpe);
});

// Obtener referencias a los elementos de entrada de texto
const campos_agg_producto = document.querySelectorAll('input[type="text"]');

// Iterar sobre los campos y agregar un evento de escucha para validar los números positivos
campos_agg_producto.forEach(function (campo) {
  campo.addEventListener("input", function () {
    // Verificar si el campo es 'ordenFact'; si es así, salir de la función
    if (this.id === "ordenFact" || this.id === "documentoFact") {
      return; // No aplicar validación a este campo
    }

    // Obtener el valor actual del campo
    let valor = this.value.trim(); // Eliminar espacios en blanco al principio y al final

    // Verificar si el valor contiene solo dígitos positivos
    if (!/^\d*\.?\d+$/.test(valor)) {
      // Si no contiene solo dígitos positivos, establecer el valor del campo en blanco
      this.value = "";
      // Opcionalmente, puedes mostrar un mensaje de error o realizar otra acción
    }
  });
});

// Capturar el evento onchange del select
$("#lstTipoMovimientoFact").change(function () {
  // Obtener el valor seleccionado
  var facturaSeleccionada = $(this).val();
  infoTipoMovimiento = document.getElementById("infoTipoMovimientoFact");

  // Por ejemplo, mostrar el valor seleccionado en la consola
  console.log("Factura seleccionada:", facturaSeleccionada);

  if (facturaSeleccionada === "1") {
    infoTipoMovimiento.value = "COMPRAS";
    infoTipoMovimiento.style.backgroundColor = "blue"; // Fondo azul
    infoTipoMovimiento.style.color = "yellow"; // Letras amarillas
    infoTipoMovimiento.style.fontWeight = "bold"; // Letras en negrita
  } else {
    infoTipoMovimiento.value = "OTRO";
  }
});

// onchange de los campos manipulables para hacer calculos si se mueve alguno del modal
$('.formEditar input[type="text"]').change(function () {
  // Obtener el valor de la cantidad y del valor unitario
  var cantidad = parseFloat($("#cantidadEditar").val());
  var valorUnitario = parseFloat($("#vlrUnitarioEditar").val());
  var imp = parseFloat($("#impuestoEditar").val());
  var descuento = parseFloat($("#descuentoEditar").val());

  // Calcular el valor del descuento y el valor final
  var nuevoValorUnitario = valorUnitario;
  var valorFinal = nuevoValorUnitario * cantidad;
  var valorImp = (valorFinal * imp) / 100;
  var valorDesc = (valorFinal * descuento) / 100;

  // Calcular el valor del descuento y el valor final
  var nuevoValorUnitario = valorUnitario;
  var valorFinal = Math.ceil(nuevoValorUnitario * cantidad + valorImp);

  // $("#vlr_unit_final").val(nuevoValorUnitario);
  $("#vlrTotalEditar").val(valorFinal);
});

var contadorTabla = 0;
var valores = {};
var totales = 0;
var subtotal = 0;
var descuentos = 0;
var totalImpuestos = 0;
var total = 0;
var vlrImp = 0;
var valorAntImp = 0;

// agregar a la tabla
$("#btnAgregarProducto").click(function () {
  var inputs = document.querySelectorAll('.datos_productos input[type="text"]');
  var todosInputsTienenInformacion = true;
  var valorParcial = document.getElementById("valorParcialFact");

  // Verificar si todos los inputs tienen información
  inputs.forEach(function (input) {
    if (input.value === "") {
      todosInputsTienenInformacion = false;
      return false; // Salir del bucle forEach
    }
  });

  // Si falta información en algún input, mostrar un mensaje de error
  if (!todosInputsTienenInformacion) {
    notificacion(
      "Complete todos los campos",
      "warning",
      "Por favor complete todos los campos antes de agregar el producto."
    );
    return; // Salir de la función sin agregar el producto
  }

  // Obtener el código del producto a agregar
  var codigoProductoNuevo = document.getElementById("codigo").value;

  // Verificar si el producto ya está en la tabla
  var productoExistente = Object.values(valores).some(function (item) {
    return item.codigo === codigoProductoNuevo;
  });

  // Si el producto ya existe en la tabla, mostrar un mensaje de error
  if (productoExistente) {
    notificacion(
      "Producto duplicado",
      "warning",
      "El producto ya está en la tabla, debe editarlo si desea modificarlo."
    );
    limpiarInputs();
    return; // Salir de la función sin agregar el producto
  }

  contadorTabla++;

  if (contadorTabla == 1) {
    ocultarNoHayRegistros();
  }

  // Inicializar un objeto para almacenar los valores de esta fila
  valores[contadorTabla] = {};

  // Iterar sobre cada input y obtener su valor
  inputs.forEach(function (input) {
    // Obtener el nombre del campo (atributo "name" del input)
    var nombreCampo = input.name;
    // Obtener el valor del input
    var valorCampo = input.value;
    // Asignar el valor al objeto de valores
    valores[contadorTabla][nombreCampo] = valorCampo;
  });

  // cargamos la tabla y le pasamos los valores por arreglo
  tabla_factura(valores);

  // Asignar un valor utilizando textContent
  $("#valorAntesDescuentoFact").val(0); // Redondear el total a dos decimales
  $("#descuentoFact").val(0); // Redondear el total a dos decimales
  $("#ImpuestoFact").val(valorAntImp.toFixed(2)); // Redondear el total a dos decimales
  $("#valorImpFact").val(Math.ceil(vlrImp.toFixed(2))); // Redondear el total a dos decimales
  if (total > 0) {
    valorParcial.style.backgroundColor = "red"; // Fondo azul
    valorParcial.style.color = "yellow"; // Letras amarillas
    valorParcial.style.fontWeight = "bold"; // Letras en negrita
    valorParcial.style.textAlign = "center"; // Letras en negrita
  }
  $("#valorParcialFact").val(total.toFixed(2)); // Redondear el total a dos decimales

  // Limpiar los inputs después de agregar el producto
  limpiarInputs();
});

// Funcion para cargar las listas select con opcion de busqueda
function editar(id) {
  // Buscar el producto en la tabla
  var producto = obtenerProductoPorId(id);
  console.table(producto);

  $("#editarModal").modal("show");

  // Llenar los campos del modal con los valores del producto
  $("#idProducto").val(id);
  $("#codigoEditar").val(producto.codigo);
  $("#descripcionEditar").val(producto.descripcion);
  $("#vlrUnitarioEditar").val(producto.vlr_unitario);
  $("#cantidadEditar").val(producto.cant);
  $("#descuentoEditar").val(producto.desc);
  $("#impuestoEditar").val(producto.imp.replace("%", ""));
  $("#vlrTotalEditar").val(producto.vlr_total);
  // Forzar la apertura del modal (si no se abre automáticamente)
}

// Función para obtener un producto por su ID desde la tabla
function obtenerProductoPorId(id) {
  var productoEncontrado = null;

  // Iterar sobre las filas de la tabla
  $("#tablaProductos tbody tr").each(function () {
    // Obtener el ID de la fila actual
    var idFila = $(this).find(".codigo").text();

    // Verificar si el ID de la fila coincide con el ID proporcionado
    if (idFila == id) {
      // Extraer los valores de la fila y crear un objeto producto
      productoEncontrado = {
        codigo: $(this).find(".codigo").text(),
        descripcion: $(this).find(".descripcion").text(),
        cant: $(this).find(".cant").text(),
        vlr_unitario: $(this).find(".vlr_unitario").text(),
        desc: $(this).find(".desc").text(),
        imp: $(this).find(".imp").text(),
        vlr_total: $(this).find(".vlr_total").text(),
      };

      // Salir del bucle forEach
      return false;
    }
  });

  return productoEncontrado;
}

// Capturar el evento de clic en el botón "Modificar" producto
$(".btnModificar").click(function () {
  // Obtener el ID del producto a editar
  var idProducto = $("#idProducto").val();

  // Obtener los nuevos valores de los campos de entrada
  var cantidad = $("#cantidadEditar").val();
  var vlrUnitario = $("#vlrUnitarioEditar").val();
  var impuesto = $("#impuestoEditar").val();
  var descuento = $("#descuentoEditar").val();
  var vlrTotal = $("#vlrTotalEditar").val();

  // Actualizar los valores en la tabla
  $("#tablaProductos tbody tr").each(function () {
    // Obtener el ID de la fila actual
    var idFila = $(this).find(".codigo").text();

    // Verificar si el ID de la fila coincide con el ID del producto a editar
    if (idFila == idProducto) {
      // Actualizar los valores de los campos en la fila correspondiente
      $(this).find(".vlr_unitario").text(vlrUnitario);
      $(this).find(".cant").text(cantidad);
      $(this).find(".desc").text(descuento);
      $(this).find(".imp").text(impuesto);
      $(this).find(".vlr_total").text(vlrTotal);

      // Salir del bucle forEach
      return false;
    }
  });

  //actualizar el subtotal,descuento, valor total
  actualizarTotales();

  // Para cerrar el modal después de modificar los datos
  $("#editarModal").modal("hide");
});

// Capturar el evento de clic en el botón "Facturar" producto
$(".btnFacturar").click(function () {
  // Obtener valores de los campos
  const fecha = document.getElementById("fechaFact").value;
  const tipoMovimiento = document.getElementById("lstTipoMovimientoFact").value;
  const plazo = document.getElementById("plazoFact").value;
  const infoTipoMovimiento = document.getElementById(
    "infoTipoMovimientoFact"
  ).value;
  const proveedores = document.getElementById("lstProveedoresFact").value;
  const sucursal = document.getElementById("lstSucursalFact").value;
  const documento = document.getElementById("documentoFact").value;
  const bodega = document.getElementById("lstBodegaFact").value;
  const vendedores = document.getElementById("lstVendedoresFact").value;
  const orden = document.getElementById("ordenFact").value;
  const transporte = document.getElementById("lstTransporteFact").value;
  const remision = document.getElementById("remisionFact").value;
  const nota = document.getElementById("notaFact").value;
  const valorAntesDescuento = document.getElementById(
    "valorAntesDescuentoFact"
  ).value;
  const descuento = document.getElementById("descuentoFact").value;
  const impuesto = document.getElementById("ImpuestoFact").value;
  const valorImp = document.getElementById("valorImpFact").value;
  const valorRetefuente = document.getElementById("valorRetefuenteFact").value;
  const valorReteIva = document.getElementById("valorReteIvaFact").value;
  const valorReteIca = document.getElementById("valorReteIcaFact").value;
  const valorParcial = document.getElementById("valorParcialFact").value;

  // Crear un objeto con los datos recolectados
  var datos = {
    fecha: fecha,
    tipoMovimiento: tipoMovimiento,
    plazo: plazo,
    infoTipoMovimiento: infoTipoMovimiento,
    proveedores: proveedores,
    sucursal: sucursal,
    documento: documento,
    bodega: bodega,
    vendedores: vendedores,
    orden: orden,
    transporte: transporte,
    remision: remision,
    nota: nota,
    valorAntesDescuento: valorAntesDescuento,
    descuento: descuento,
    impuesto: impuesto,
    valorImp: valorImp,
    valorRetefuente: valorRetefuente,
    valorReteIva: valorReteIva,
    valorReteIca: valorReteIca,
    valorParcial: valorParcial,
    detalles: [], // Aquí se agregarán los detalles de la factura
  };

  // Recorrer las filas de la tabla de detalles y agregar los datos de cada fila al objeto 'datos'
  $("#cuerpoTabla tr").each(function (index, fila) {
    var detalle = {
      codigo: $(fila).find(".codigo").text(),
      descripcion: $(fila).find(".descripcion").text(),
      um: $(fila).find(".um").text(),
      cant: $(fila).find(".cant").text(),
      vlr_unitario: $(fila).find(".vlr_unitario").text(),
      descuento: $(fila).find(".desc").text(),
      imp: $(fila).find(".imp").text(),
      vlr_total: $(fila).find(".vlr_total").text(),
    };
    datos.detalles.push(detalle);
  });

  // Realizar la solicitud AJAX al servidor
  $.ajax({
    url: "ajax/facturacioncomprasajax.php",
    method: "POST",
    dataType: "json",
    data: { proceso: "guardar", datos: datos },
    success: function (response) {
      console.log(response);
      if (response.status == "success") {
        notificacion("Exito", response.status, response.message);
        limpiarCamposFactura();

        valores = {};
        contadorTabla = 0;
        delete valores;

        tabla_factura(valores);
        actualizarTotales();
        mostrarNoHayRegistros();
      } else {
        notificacion("Error", response.status, response.message);
      }
    },
  });
});

function eliminarFila(id) {
  console.log(id);
  delete valores[id];
  tabla_factura(valores);
  actualizarTotales();

  // Verificar si el objeto 'valores' está vacío
  if (Object.keys(valores).length === 0) {
    console.log("No hay registros, mostrando mensaje.");
    mostrarNoHayRegistros();
  }
}

function mostrarNoHayRegistros() {
  let noHayRegistros = document.getElementById("no_hay_registros");

  // Si el elemento no existe, lo creamos
  if (!noHayRegistros) {
    const cuerpoTabla = document.getElementById("cuerpoTabla");

    // Crear una nueva fila <tr>
    noHayRegistros = document.createElement("tr");
    noHayRegistros.id = "no_hay_registros";

    // Crear la celda <td> con colspan y el mensaje
    const celda = document.createElement("td");
    celda.colSpan = 13;
    celda.className = "text-center";
    celda.textContent = "No hay registros agregados.";

    // Añadir la celda a la fila
    noHayRegistros.appendChild(celda);

    // Añadir la fila al tbody
    cuerpoTabla.appendChild(noHayRegistros);
  }

  // Mostrar la fila
  noHayRegistros.style.display = "";
}

function ocultarNoHayRegistros() {
  const noHayRegistros = document.getElementById("no_hay_registros");
  noHayRegistros.style.display = "None";
}

$(".btnNuevaFactura").click(function () {
  limpiarCamposFactura();

  valores = {};
  contadorTabla = 0;
  delete valores;

  tabla_factura(valores);
  actualizarTotales();
  mostrarNoHayRegistros();
});

function tabla_factura(valores) {
  // contadorTabla = contadorTabla - 1;
  $("#tablaProductos tbody").empty();

  subtotal = 0;
  descuentos = 0;
  total = 0;
  valorAntImp = 0;
  vlrImp = 0;
  valorAntDesc = 0;
  valorDesc = 0;

  $.each(valores, function (index, item) {
    $("#tablaProductos tbody").append(
      "<tr>" +
        '<td class="numero"><b>' +
        index +
        "</b></td>" +
        '<td class="codigo">' +
        item.codigo +
        "</td>" +
        '<td class="descripcion">' +
        item.descripcion +
        "</td>" +
        '<td class="um">' +
        item.um +
        "</td>" +
        '<td class="cant">' +
        item.cant +
        "</td>" +
        '<td class="vlr_unitario">' +
        item.vlr_unitario +
        "</td>" +
        '<td class="desc">' +
        item.desc +
        "</td>" +
        '<td class="imp">' +
        item.imp +
        "%</td>" +
        "</td>" +
        '<td class="vlr_total">' +
        item.vlr_total +
        "</td>" +
        '<td class="text-center"><button class="btn btn-outline-warning me-1 mb-1" type="button" onclick=editar("' +
        item.codigo +
        '")>' +
        '<span class="fas fa-edit ms-1" data-fa-transform="shrink-3"></span></button>' +
        '<button class="btn btn-outline-danger me-1 mb-1" type="button" onclick=eliminarFila(' +
        index +
        ")>" +
        '<span class="fas fa-trash ms-1" data-fa-transform="shrink-3"></span></button></td>' +
        "</tr>"
    );

    // Calcular el valor del descuento y el valor final
    var valorFinal = item.cant * item.vlr_unitario;
    vlrImp += (valorFinal * item.imp) / 100;
    valorAntImp += valorFinal;
    valorAntDesc += Math.ceil(item.vlr_total);
    valorDesc += Math.ceil(item.vlr_total * item.desc) / 100;

    total += parseFloat(item.vlr_total);
  });
}

// Función para limpiar los campos de la factura
function limpiarCamposFactura() {
  var lstProveedoresFact = $("#lstProveedoresFact");
  lstProveedoresFact.select2({});
  lstProveedoresFact.find("option").remove();
  cargar_proveedores("", "lstProveedoresFact", "");

  var lstBodegaFact = $("#lstBodegaFact");
  lstBodegaFact.select2({});
  lstBodegaFact.find("option").remove();
  cargar_bodega("", "lstBodegaFact", "");

  var lstVendedoresFact = $("#lstVendedoresFact");
  lstVendedoresFact.select2({});
  lstVendedoresFact.find("option").remove();
  cargar_vendedores("", "lstVendedoresFact", "");

  var lstSucursalFact = $("#lstSucursalFact");
  lstSucursalFact.select2({});
  lstSucursalFact.find("option").remove();
  cargar_oficinas("", "lstSucursalFact", "");

  var lstTipoMovimiento = $("#lstTipoMovimientoFact");
  lstTipoMovimiento.select2({});
  lstTipoMovimiento.find("option").remove();
  cargar_tipos_movimientos("", "lstTipoMovimientoFact", "");

  var lstTransporte = $("#lstTransporteFact");
  lstTransporte.select2({});
  lstTransporte.find("option").remove();
  cargar_tipos_movimientos("", "lstTransporteFact", "");

  var lstFacturaFact = $("#lstFacturaFact");
  lstFacturaFact.select2({});
  lstFacturaFact.find("option").remove();
  cargar_factura("", "lstFacturaFact", "");

  document.getElementById("documentoFact").value = ""; // Limpiar el consecutivo
  document.getElementById("fechaFact").value = ""; // Limpiar el consecutivo
  document.getElementById("notaFact").value = ""; // Limpiar el consecutivo
  document.getElementById("ordenFact").value = ""; // Limpiar el consecutivo
  document.getElementById("remisionFact").value = ""; // Limpiar el consecutivo
  document.getElementById("infoTipoMovimientoFact").value = ""; // Limpiar el consecutivo
  infoTipoMovimiento = document.getElementById("infoTipoMovimientoFact");
  infoTipoMovimiento.style = ""; // Elimina todos los estilos inline
}

// Función para calcular y actualizar el subtotal
function actualizarTotales() {
  var subtotal = 0;
  var total = 0;

  // Recorrer todas las filas de la tabla y sumar los valores parciales de cada producto
  $("#tablaProductos tbody tr").each(function () {
    var vlr_total = parseFloat($(this).find(".vlr_total").text());

    if (!isNaN(vlr_total)) {
      subtotal += vlr_total;
      total += vlr_total; // Si tienes descuentos o impuestos, podrías modificar el total aquí
    }
  });

  // Redondear el total hacia arriba
  total = Math.ceil(total);

  // Actualizar el valor del subtotal en la interfaz de usuario
  // Asignar un valor utilizando textContent
  $("#valorAntesDescuentoFact").val(0); // Redondear el total a dos decimales
  $("#descuentoFact").val(0); // Redondear el total a dos decimales
  $("#ImpuestoFact").val(valorAntImp.toFixed(2)); // Redondear el total a dos decimales
  $("#valorImpFact").val(Math.ceil(vlrImp.toFixed(2))); // Redondear el total a dos decimales
  $("#valorParcialFact").val(total.toFixed(2)); // Mostrar total con dos decimales
}

// Función para limpiar los inputs después de agregar un producto
function limpiarInputs() {
  var inputs = document.querySelectorAll('.datos_productos input[type="text"]');
  inputs.forEach(function (input) {
    input.value = "";
  });
}

function notificacion(titulo, icon, mensaje) {
  //Mensaje de notificación, muestra un mensaje con SweetAlert
  if (titulo == "Error") {
    color = "#EF5350";
  } else {
    color = "#2196f3";
  }
  Swal.fire({
    title: titulo,
    html: mensaje,
    icon: icon,
    confirmButtonColor: color,
  });
}

$("#btnBusquedaProveedoresFact").click(function () {
  cargar_proveedores("", "lstProveedoresFact", "");
});
function cargar_proveedores(Id, nameSelect, Modal) {
  var lstRoles = $("#" + nameSelect);

  if (Id != "") {
    lstRoles.select2({});

    lstRoles.find("option").remove();
    var searchTerm = "";
    $.ajax({
      type: "POST",
      dataType: "json",
      url: "ajax/proveedoresajaxv1.php",
      data: {
        searchTerm: searchTerm,
        proceso: "combo_proveedores",
        id: Id,
      },
    }).then(function (registros) {
      $(registros).each(function (i, v) {
        lstRoles.append(
          '<option selected value="' + v.id + '">' + v.text + "</option>"
        );
      });
      lstRoles.trigger({
        type: "select2:select",
        params: {
          data: registros,
        },
      });
    });
  } else {
    lstRoles.select2({
      placeholder: "Seleccione un proveedor",
      ajax: {
        url: "ajax/proveedoresajaxv1.php",
        type: "post",
        dataType: "json",
        delay: 150,
        data: function (params) {
          return {
            searchTerm: params.term,
            proceso: "combo_proveedores",
            id: Id,
          };
        },
        processResults: function (response) {
          return {
            results: response,
          };
        },
        cache: true,
      },
    });
  }
}

$("#btnBusquedaFacturaFact").click(function () {
  cargar_factura("", "lstFacturaFact", "");
});
function cargar_factura(Id, nameSelect, Modal) {
  var lstRoles = $("#" + nameSelect);

  if (Id != "") {
    lstRoles.select2({});
    // var lstRoles = $lstRoles
    lstRoles.find("option").remove();
    var searchTerm = "";
    $.ajax({
      type: "POST",
      dataType: "json",
      url: "ajax/nombodsajax.php",
      data: {
        searchTerm: searchTerm,
        proceso: "combo_factura",
        id: Id,
      },
    }).then(function (registros) {
      $(registros).each(function (i, v) {
        lstRoles.append(
          '<option selected value="' + v.id + '">' + v.text + "</option>"
        );
      });
      lstRoles.trigger({
        type: "select2:select",
        params: {
          data: registros,
        },
      });
    });
  } else {
    lstRoles.select2({
      placeholder: "Seleccione un factura",
      ajax: {
        url: "ajax/nombodsajax.php",
        type: "post",
        dataType: "json",
        delay: 150,
        data: function (params) {
          return {
            searchTerm: params.term,
            proceso: "combo_factura",
            id: Id,
          };
        },
        processResults: function (response) {
          return {
            results: response,
          };
        },
        cache: true,
      },
    });
  }
}

$("#btnBusquedaBodegaFact").click(function () {
  cargar_bodega("", "lstBodegaFact", "");
});
function cargar_bodega(Id, nameSelect, Modal) {
  var lstRoles = $("#" + nameSelect);

  if (Id != "") {
    lstRoles.select2({});
    // var lstRoles = $lstRoles
    lstRoles.find("option").remove();
    var searchTerm = "";
    $.ajax({
      type: "POST",
      dataType: "json",
      url: "ajax/nombodsajax.php",
      data: {
        searchTerm: searchTerm,
        proceso: "combo_caja",
        id: Id,
      },
    }).then(function (registros) {
      $(registros).each(function (i, v) {
        lstRoles.append(
          '<option selected value="' + v.id + '">' + v.text + "</option>"
        );
      });
      lstRoles.trigger({
        type: "select2:select",
        params: {
          data: registros,
        },
      });
    });
  } else {
    lstRoles.select2({
      placeholder: "Seleccione una bodega",
      ajax: {
        url: "ajax/nombodsajax.php",
        type: "post",
        dataType: "json",
        delay: 150,
        data: function (params) {
          return {
            searchTerm: params.term,
            proceso: "combo_caja",
            id: Id,
          };
        },
        processResults: function (response) {
          return {
            results: response,
          };
        },
        cache: true,
      },
    });
  }
}

$("#btnBusquedaSucursalFact").click(function () {
  cargar_oficinas("", "lstSucursalFact", "");
});
function cargar_oficinas(Id, nameSelect, Modal) {
  var lstRoles = $("#" + nameSelect);

  if (Id != "") {
    lstRoles.select2({});

    lstRoles.find("option").remove();
    var searchTerm = "";
    $.ajax({
      type: "POST",
      dataType: "json",
      url: "ajax/ciudadesajax.php",
      data: {
        searchTerm: searchTerm,
        proceso: "combo_ciudades",
        id: Id,
      },
    }).then(function (registros) {
      $(registros).each(function (i, v) {
        lstRoles.append(
          '<option selected value="' + v.id + '">' + v.text + "</option>"
        );
      });
      lstRoles.trigger({
        type: "select2:select",
        params: {
          data: registros,
        },
      });
    });
  } else {
    lstRoles.select2({
      placeholder: "Seleccione una sucursal",
      ajax: {
        url: "ajax/ciudadesajax.php",
        type: "post",
        dataType: "json",
        delay: 150,
        data: function (params) {
          return {
            searchTerm: params.term,
            proceso: "combo_ciudades",
            id: Id,
          };
        },
        processResults: function (response) {
          return {
            results: response,
          };
        },
        cache: true,
      },
    });
  }
}

$("#btnBusquedaVendedoresFact").click(function () {
  cargar_vendedores("", "lstVendedoresFact", "");
});
function cargar_vendedores(Id, nameSelect, Modal) {
  var lstRoles = $("#" + nameSelect);

  if (Id != "") {
    lstRoles.select2({});

    lstRoles.find("option").remove();
    var searchTerm = "";
    $.ajax({
      type: "POST",
      dataType: "json",
      url: "ajax/clientesajaxv1.php",
      data: {
        searchTerm: searchTerm,
        proceso: "combo_vendedores",
        id: Id,
      },
    }).then(function (registros) {
      $(registros).each(function (i, v) {
        lstRoles.append(
          '<option selected value="' + v.id + '">' + v.text + "</option>"
        );
      });
      lstRoles.trigger({
        type: "select2:select",
        params: {
          data: registros,
        },
      });
    });
  } else {
    lstRoles.select2({
      placeholder: "Seleccione un vendedor",
      ajax: {
        url: "ajax/clientesajaxv1.php",
        type: "post",
        dataType: "json",
        delay: 150,
        data: function (params) {
          return {
            searchTerm: params.term,
            proceso: "combo_vendedores",
            id: Id,
          };
        },
        processResults: function (response) {
          return {
            results: response,
          };
        },
        cache: true,
      },
    });
  }
}

$("#btnBusquedaTipoMovimientoFact").click(function () {
  cargar_tipos_movimientos("", "lstTipoMovimientoFact", "");
});
function cargar_tipos_movimientos(Id, nameSelect, Modal) {
  var lstRoles = $("#" + nameSelect);

  if (Id != "") {
    lstRoles.select2({});
    lstRoles.find("option").remove();
    var searchTerm = "";
    $.ajax({
      type: "POST",
      dataType: "json",
      url: "ajax/tipomoinsajax.php",
      data: {
        searchTerm: searchTerm,
        proceso: "combo_tipofact",
        id: Id,
      },
    }).then(function (registros) {
      $(registros).each(function (i, v) {
        lstRoles.append(
          '<option selected value="' + v.id + '">' + v.text + "</option>"
        );
      });
      lstRoles.trigger({
        type: "select2:select",
        params: {
          data: registros,
        },
      });
    });
  } else {
    lstRoles.select2({
      placeholder: "Seleccione un tipo de movimiento",
      ajax: {
        url: "ajax/tipomoinsajax.php",
        type: "post",
        dataType: "json",
        delay: 150,
        data: function (params) {
          return {
            searchTerm: params.term,
            proceso: "combo_tipofact",
            id: Id,
          };
        },
        processResults: function (response) {
          return {
            results: response,
          };
        },
        cache: true,
      },
    });
  }
}

$("#btnBusquedaTransporteFact").click(function () {
  cargar_transportadores("", "lstTransporteFact", "");
});
function cargar_transportadores(Id, nameSelect, Modal) {
  var lstRoles = $("#" + nameSelect);

  if (Id != "") {
    lstRoles.select2({});

    lstRoles.find("option").remove();
    var searchTerm = "";
    $.ajax({
      type: "POST",
      dataType: "json",
      url: "ajax/transportadoresajax.php",
      data: {
        searchTerm: searchTerm,
        proceso: "combo_transportadores",
        id: Id,
      },
    }).then(function (registros) {
      $(registros).each(function (i, v) {
        lstRoles.append(
          '<option selected value="' + v.id + '">' + v.text + "</option>"
        );
      });
      lstRoles.trigger({
        type: "select2:select",
        params: {
          data: registros,
        },
      });
    });
  } else {
    lstRoles.select2({
      placeholder: "Seleccione un transporte",
      ajax: {
        url: "ajax/transportadoresajax.php",
        type: "post",
        dataType: "json",
        delay: 150,
        data: function (params) {
          return {
            searchTerm: params.term,
            proceso: "combo_transportadores",
            id: Id,
          };
        },
        processResults: function (response) {
          return {
            results: response,
          };
        },
        cache: true,
      },
    });
  }
}
