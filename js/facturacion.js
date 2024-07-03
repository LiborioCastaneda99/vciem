$(document).ready(function() {
    cargar_clientes('', 'lstClientesFact', '');
    cargar_vendedores('', 'lstVendedoresFact', '');
    cargar_caja('', 'lstCajaFact', '');
    cargar_bodega('', 'lstBodegaFact', '');
    cargar_factura('', 'lstFacturaFact', '');
    actualizarTotales();
    mostrarNoHayRegistros();

    // validar que esten deshabilitado
    // Obtener referencia al campo de código
    const codigoCampo = document.getElementById('codigo');
    // Obtener referencia a los demás campos de entrada de texto
    const campos = document.querySelectorAll('input[type="text"]:not(#codigo)');
    // Verificar si el campo de código está vacío
    if (codigoCampo.value.trim() === '') {
        // Si está vacío, iterar sobre los otros campos y deshabilitarlos
        campos.forEach(function(campo) {
            campo.disabled = true;
        });
    } else {
        // Si el campo de código tiene un valor, habilitar los otros campos
        campos.forEach(function(campo) {
            campo.disabled = false;
        });
    }

});

// Funcion para cargar las listas select con opcion de busqueda
$('#btnBuscarProducto').click(function() {
    $('#buscarProductos').modal('show');
    cargar_productos();
});

// Funcion para cargar las listas select con opcion de busqueda
$('#btnPagar').click(function() {
    var total = parseFloat(document.getElementById("total").value);
    if (total === 0) {
        notificacion('Error', 'error', 'Debe llenar todos los campos.')
    } else {
        document.getElementById("pay_total_").textContent = total;
        $('#pagarFactura').modal('show');
    }
});

document.addEventListener("DOMContentLoaded", function() {
    var payForm = document.getElementById("payForm");
    var payFields = payForm.querySelectorAll(".pay-field");

    payFields.forEach(function(field) {
        field.addEventListener("change", function() {
            // console.log(fiel)
            validarSumaCampos();
        });
    });
});

// Función para validar la suma de los campos
function validarSumaCampos() {
    var fac_efecti = parseFloat(document.getElementById("fac_efecti").value);
    var fac_tdebit = parseFloat(document.getElementById("fac_tdebit").value);
    var fac_tcredi = parseFloat(document.getElementById("fac_tcredi").value);
    var fac_tchequ = parseFloat(document.getElementById("fac_tchequ").value);
    var fac_tvales = parseFloat(document.getElementById("fac_tvales").value);
    var total = parseFloat(document.getElementById("pay_total_").textContent);

    var sumaCampos = fac_efecti + fac_tdebit + fac_tcredi + fac_tchequ + fac_tvales;
    var facCambioInput = document.getElementById("fac_cambio");

    // Validar si la suma de los campos es menor que el total
    if (sumaCampos < total) {
        // Mostrar el mensaje de error debajo del input de cambio
        mostrarMensajeError("La suma de los campos debe ser mayor o igual al total.");
    } else {
        // Ocultar el mensaje de error si la validación pasa
        ocultarMensajeError();
    }

    // Actualizar el valor del input de cambio
    facCambioInput.value = sumaCampos - total;
}

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
        facCambioInput.parentNode.insertBefore(errorMessage, facCambioInput.nextSibling);
    }
}

// Función para ocultar el mensaje de error
function ocultarMensajeError() {
    var errorMessage = document.querySelector(".error-message");
    if (errorMessage) {
        errorMessage.parentNode.removeChild(errorMessage);
    }
}

// Funcion para cargar las listas select con opcion de busqueda
$('#btnConsultarFactEsp').click(function() {
    // $('#buscarProductos').modal('show');
    var cliente_id = parseFloat($('#lstClientesFactEsp').val());

    // Hacer la solicitud AJAX al servidor
    var urlprocess = 'ajax/facturacionajax.php';
    $.ajax({
        type: 'POST',
        url: urlprocess,
        data: 'cliente=' + cliente_id + '&proceso=consultar_factura_espera',
        dataType: 'json',
        success: function(response) {
            if (response.status == 'success') {

                tabla_factura(response.detalle)
                valores = response.detalle
                ventas = response.venta

                cargar_clientes(ventas.cliente, 'lstClientesFact', '');
                cargar_vendedores(ventas.atiende, 'lstVendedoresFact', '');
                cargar_bodega(ventas.bodega, 'lstBodegaFact', '');
                cargar_caja(ventas.caja, 'lstCajaFact', '');
                cargar_factura(ventas.factura, 'lstFacturaFact', '');

                document.getElementById('consecutivo').value = ventas.consecutivo
                    // Obtener el elemento textarea por su ID
                var textarea = document.getElementById('notaFact');
                // Establecer el texto dentro del textarea
                textarea.value = ventas.nota

                // document.getElementById('codigo').value = data[0].codigo
                // document.getElementById('codigo').value = data[0].codigo
                // document.getElementById('codigo').value = data[0].codigo
                actualizarTotales();

                $('#buscarFactura').modal('hide');


                // Función para agregar un nuevo campo de entrada para un producto
                // function agregarCampoProducto() {
                // contadorProductos++; // Incrementar el contador de productos

                // document.getElementById('codigo').value = data[0].codigo
                // document.getElementById('descripcion').value = data[0].nombre
                // document.getElementById('um').value = "N/A"
                // document.getElementById('cant').value = 1
                // document.getElementById('vlr_unitario').value = data[0].pv1
                // document.getElementById('desc').value = "%"
                // document.getElementById('vlr_descuento').value = 0
                // document.getElementById('vlr_unit_final').value = data[0].pv1
                // document.getElementById('imp').value = 19
                // document.getElementById('vlr_impuesto').value = (data[0].pv1 * 0.19)
                // document.getElementById('vlr_parcial').value = parseFloat(data[0].pv1)
                // $('#buscarProductos').modal('hide');

                // const codigoCampo = document.getElementById('codigo');

                // // Obtener referencia a los demás campos de entrada de texto
                // const campos = document.querySelectorAll('input[type="text"]:not(#codigo)');
                // // Verificar si el campo de código está vacío
                // if (codigoCampo.value.trim() === '') {
                //     // Si está vacío, iterar sobre los otros campos y deshabilitarlos
                //     campos.forEach(function(campo) {
                //         campo.disabled = true;
                //     });
                // } else {
                //     // Si el campo de código tiene un valor, habilitar los otros campos
                //     campos.forEach(function(campo) {
                //         campo.disabled = false;
                //     });
                // }
            } else {
                notificacion('Error', 'error', response.message);
            }

        },
        error: function() {
            // Error en la inserción, muestra mensaje de error con SweetAlert
            notificacion('Error', 'error', response.message);
        }
    });
});

// Funcion para cargar las listas select con opcion de busqueda
$('#btnBuscarFacturaEspera').click(function() {
    $('#buscarFactura').modal('show');
    cargar_clientes_modal('', 'lstClientesFactEsp', 'buscarFactura');
});

// cargamos la tabla de los productos
function cargar_productos() {
    $('#tablaListadoProductos').dataTable().fnDestroy();
    $('#tablaListadoProductos').DataTable({
        "responsive": true,
        dom: 'lfrtip',
        "columnDefs": [{
                // El numero correspode a la ultima columna iniciando en 0
                "targets": [2, 3, 4, 5],
                "orderable": false,
                "width": "70px",
                "className": "text-center",
            },
            {
                // El numero correspode a la ultima columna iniciando en 0
                "targets": [0],
                "width": "90px",
            }
        ],
        "language": {
            "url": "vendors/datatables.net/spanish.txt"
        },
        "lengthMenu": [10, 25, 50, 75, 100, 500, 1000],
        "lengthChange": true,
        "order": [
            [0, "desc"]
        ],
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': 'ajax/articulosajax.php',
            'data': {
                'proceso': 'listado_productos'
            },
            'method': 'POST'
        },
        'columns': [{
                data: 'codigo'
            },
            {
                data: 'nombre'
            },
            {
                data: 'existencia'
            },
            {
                data: 'vlr_minimo'
            },
            {
                data: 'vlr_sugerido'
            },
            {
                data: 'comprar'
            },
        ],
        drawCallback: function() {
            $(".btn-group").addClass("btn-group-sm");
        }

    });
}

var contadorProductos = 0;

// agregar producto a los inputs
function agregar(id) {
    // Hacer la solicitud AJAX al servidor
    var urlprocess = 'ajax/articulosajax.php';
    $.ajax({
        type: 'POST',
        url: urlprocess,
        data: 'id=' + id + '&proceso=get_id',
        dataType: 'json',
        success: function(data) {

            // Función para agregar un nuevo campo de entrada para un producto
            // function agregarCampoProducto() {
            contadorProductos++; // Incrementar el contador de productos

            document.getElementById('codigo').value = data[0].codigo
            document.getElementById('descripcion').value = data[0].nombre
            document.getElementById('um').value = data[0].umedida
            document.getElementById('cant').value = 1
            document.getElementById('vlr_unitario').value = data[0].pv1
            document.getElementById('desc').value = "%"
            document.getElementById('vlr_descuento').value = 0
            document.getElementById('vlr_unit_final').value = data[0].pv1
            document.getElementById('imp').value = 19
            document.getElementById('vlr_impuesto').value = (data[0].pv1 * 0.19)
            document.getElementById('vlr_parcial').value = parseFloat(data[0].pv1)
            $('#buscarProductos').modal('hide');

            const codigoCampo = document.getElementById('codigo');

            // Obtener referencia a los demás campos de entrada de texto
            const campos = document.querySelectorAll('input[type="text"]:not(#codigo)');
            // Verificar si el campo de código está vacío
            if (codigoCampo.value.trim() === '') {
                // Si está vacío, iterar sobre los otros campos y deshabilitarlos
                campos.forEach(function(campo) {
                    campo.disabled = true;
                });
            } else {
                // Si el campo de código tiene un valor, habilitar los otros campos
                campos.forEach(function(campo) {
                    campo.disabled = false;
                });
            }


        },
        error: function() {
            // Error en la inserción, muestra mensaje de error con SweetAlert
            notificacion('Error', 'error', response.message);
        }
    });
}

// obtener consecutivo
function obtener_consecutivo(id_factura) {

    var consecutivoP = document.getElementById("consecutivo");

    // Realizar la solicitud AJAX al servidor
    $.ajax({
        url: 'ajax/articulosajax.php', // La URL del script PHP que maneja la solicitud
        method: 'POST', // El método de solicitud
        dataType: 'json', // El tipo de datos que esperamos recibir del servidor
        data: { proceso: 'get_consecutivo', id: id_factura }, // Los datos que se enviarán al servidor

        // Función que se ejecuta cuando la solicitud se completa con éxito
        success: function(response) {
            console.log(response)
            consecutivoP.value = response.datos
        }
    });
}

//onchange para buscar el codigo y si existe que pinte datos
$('#codigo').change(function() {
    // Obtener el valor del código
    var codigo = $(this).val();

    // Realizar la solicitud AJAX al servidor
    $.ajax({
        url: 'ajax/articulosajax.php', // La URL del script PHP que maneja la solicitud
        method: 'POST', // El método de solicitud
        dataType: 'json', // El tipo de datos que esperamos recibir del servidor
        data: { id: codigo, proceso: 'get_id_productos' }, // Los datos que se enviarán al servidor

        // Función que se ejecuta cuando la solicitud se completa con éxito
        success: function(response) {
            // Verificar si se encontraron datos
            if (response.status == 'success') {
                // Mostrar los datos obtenidos en los campos de entrada

                document.getElementById('codigo').value = response.datos[0].codigo
                document.getElementById('descripcion').value = response.datos[0].nombre
                document.getElementById('um').value = response.datos[0].umedida
                document.getElementById('cant').value = 1
                document.getElementById('vlr_unitario').value = response.datos[0].pv1
                document.getElementById('desc').value = "%"
                document.getElementById('vlr_descuento').value = 0
                document.getElementById('vlr_unit_final').value = response.datos[0].pv1
                document.getElementById('imp').value = 19
                document.getElementById('vlr_impuesto').value = (response.datos[0].pv1 * 0.19)
                document.getElementById('vlr_parcial').value = parseFloat(response.datos[0].pv1)
                    // Y así sucesivamente con los demás campos

                const codigoCampo = document.getElementById('codigo');

                // Obtener referencia a los demás campos de entrada de texto
                const campos = document.querySelectorAll('input[type="text"]:not(#codigo)');
                // Verificar si el campo de código está vacío
                if (codigoCampo.value.trim() === '') {
                    // Si está vacío, iterar sobre los otros campos y deshabilitarlos
                    campos.forEach(function(campo) {
                        campo.disabled = true;
                    });
                } else {
                    // Si el campo de código tiene un valor, habilitar los otros campos
                    campos.forEach(function(campo) {
                        campo.disabled = false;
                    });
                }

            } else {
                notificacion('Error', 'error', response.message)

                // Si no se encontraron datos, limpiar los campos
                document.getElementById('codigo').value = ""
                document.getElementById('descripcion').value = ""
                document.getElementById('um').value = ""
                document.getElementById('cant').value = ""
                document.getElementById('vlr_unitario').value = ""
                document.getElementById('desc').value = ""
                document.getElementById('vlr_descuento').value = ""
                document.getElementById('vlr_unit_final').value = ""
                document.getElementById('imp').value = ""
                document.getElementById('vlr_impuesto').value = ""
                document.getElementById('vlr_parcial').value = ""
            }
        },

        // Función que se ejecuta si hay un error en la solicitud
        error: function(xhr, status, error) {
            // Manejar el error según sea necesario
            console.error('Error en la solicitud AJAX:', error);
        }
    });
});

// onchange de los campos manipulables para hacer calculos si se mueve alguno
$('.datos_productos input[type="text"]').change(function() {
    // Obtener el valor de la cantidad y del valor unitario
    var cantidad = parseFloat($('#cant').val());
    var valorUnitario = parseFloat($('#vlr_unitario').val());
    var imp = parseFloat($('#imp').val());

    // Calcular el valor del descuento y el valor final
    var descuento = parseFloat($('#vlr_descuento').val());
    var valorDescuento = descuento;
    var nuevoValorUnitario = valorUnitario;
    var valorFinal = nuevoValorUnitario * cantidad - descuento;
    var valorImp = valorFinal * imp / 100;

    // Actualizar los campos de valor descuento, valor unitario final y valor parcial
    $('#vlr_descuento').val(valorDescuento);
    $('#vlr_impuesto').val(valorImp);
    $('#vlr_unit_final').val(nuevoValorUnitario);
    $('#vlr_parcial').val(valorFinal);
});

// validar que los campos sean tipo numero
// Obtener referencias a los elementos de entrada de texto
const campos_agg_producto = document.querySelectorAll('input[type="text"]');

// Iterar sobre los campos y agregar un evento de escucha para validar los números positivos
campos_agg_producto.forEach(function(campo) {
    campo.addEventListener('input', function() {
        // Obtener el valor actual del campo
        let valor = this.value.trim(); // Eliminar espacios en blanco al principio y al final

        // Verificar si el valor contiene solo dígitos positivos
        if (!/^\d*\.?\d+$/.test(valor)) {
            // Si no contiene solo dígitos positivos, establecer el valor del campo en blanco
            this.value = '';
            // Opcionalmente, puedes mostrar un mensaje de error o realizar otra acción
        }
    });
});

// validar que esten deshabilitado
// Obtener referencia al campo de código
const codigoCampo = document.getElementById('codigo');

// Obtener referencia a los demás campos de entrada de texto
const campos = document.querySelectorAll('input[type="text"]:not(#codigo)');

// Agregar un evento de escucha al campo de código para verificar su valor
codigoCampo.addEventListener('input', function() {
    // Verificar si el campo de código está vacío
    if (this.value.trim() === '') {
        // Si está vacío, iterar sobre los otros campos y deshabilitarlos
        campos.forEach(function(campo) {
            campo.disabled = true;
        });
    } else {
        // Si el campo de código tiene un valor, habilitar los otros campos
        campos.forEach(function(campo) {
            campo.disabled = false;
        });
    }
});


// Capturar el evento onchange del select
$('#lstFacturaFact').change(function() {
    // Obtener el valor seleccionado
    var facturaSeleccionada = $(this).val();

    // Realizar cualquier acción que desees con el valor seleccionado, como una solicitud AJAX para cargar datos relacionados con la factura, etc.
    obtener_consecutivo(facturaSeleccionada);

    // Por ejemplo, mostrar el valor seleccionado en la consola
    console.log('Factura seleccionada:', facturaSeleccionada);
});

// onchange de los campos manipulables para hacer calculos si se mueve alguno del modal
$('.formEditar input[type="text"]').change(function() {
    // Obtener el valor de la cantidad y del valor unitario
    var cantidad = parseFloat($('#cantidadEditar').val());
    var valorUnitario = parseFloat($('#vlrUnitarioInicialEditar').val());
    var imp = parseFloat($('#impEditar').val());

    // Calcular el valor del descuento y el valor final
    var descuento = parseFloat($('#descuentoEditar').val());
    var valorDescuento = descuento;
    var nuevoValorUnitario = valorUnitario;
    var valorFinal = nuevoValorUnitario * cantidad - descuento;
    var valorImp = valorFinal * imp / 100;

    // Actualizar los campos de valor descuento, valor unitario final y valor parcial
    $('#descuentoEditar').val(valorDescuento);
    // $('#vlr').val(valorImp);
    $('#vlrUnitarioFinalEditar').val(nuevoValorUnitario);
    $('#vlrParcialEditar').val(valorFinal);
});

var contadorTabla = 0;
var valores = {};
var totales = 0;
var subtotal = 0;
var descuentos = 0;
var totalImpuestos = 0;
var total = 0;

// agregar a la tabla 
$('#btnAgregarProducto').click(function() {

    var inputs = document.querySelectorAll('.datos_productos input[type="text"]');
    var todosInputsTienenInformacion = true;
    var subtotalP = document.getElementById("subtotal");
    var descuentosP = document.getElementById("descuentos");
    var totalP = document.getElementById("total");

    // Verificar si todos los inputs tienen información
    inputs.forEach(function(input) {
        if (input.value === '') {
            todosInputsTienenInformacion = false;
            return false; // Salir del bucle forEach
        }
    });

    // Si falta información en algún input, mostrar un mensaje de error
    if (!todosInputsTienenInformacion) {
        notificacion("Complete todos los campos", "warning", 'Por favor complete todos los campos antes de agregar el producto.')
        return; // Salir de la función sin agregar el producto
    }

    // Obtener el código del producto a agregar
    var codigoProductoNuevo = document.getElementById('codigo').value;

    // Verificar si el producto ya está en la tabla
    var productoExistente = Object.values(valores).some(function(item) {
        return item.codigo === codigoProductoNuevo;
    });

    // Si el producto ya existe en la tabla, mostrar un mensaje de error
    if (productoExistente) {
        notificacion("Producto duplicado", "warning", 'El producto ya está en la tabla, debe editarlo si desea modificarlo.');
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
    inputs.forEach(function(input) {
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
    subtotalP.innerText = subtotal.toFixed(2); // Redondear el subtotal a dos decimales
    descuentosP.innerText = descuentos.toFixed(2); // Redondear el descuentos a dos decimales
    totalP.value = total;

    // Limpiar los inputs después de agregar el producto
    limpiarInputs();
});

// Funcion para cargar las listas select con opcion de busqueda
function editar(id) {
    $('#editarModal').modal('show');
    // cargar_productos();
    // Buscar el producto en la tabla
    var producto = obtenerProductoPorId(id);

    // Llenar los campos del modal con los valores del producto
    $('#idProducto').val(id);
    $('#codigoEditar').val(producto.codigo);
    $('#descripcionEditar').val(producto.descripcion);
    $('#vlrUnitarioInicialEditar').val(producto.vlr_unitario);
    $('#cantidadEditar').val(producto.cant);
    $('#vlrUnitarioFinalEditar').val(producto.vlr_unit_final);
    $('#vlrParcialEditar').val(producto.vlr_parcial);
    $('#descuentoEditar').val(producto.vlr_descuento);
    $('#impEditar').val(producto.imp);
    // Llena más campos del modal según sea necesario
};

// Función para obtener un producto por su ID desde la tabla
function obtenerProductoPorId(id) {
    var productoEncontrado = null;

    // Iterar sobre las filas de la tabla
    $('#tablaProductos tbody tr').each(function() {
        // Obtener el ID de la fila actual
        var idFila = $(this).find('.codigo').text();

        // Verificar si el ID de la fila coincide con el ID proporcionado
        if (idFila == id) {
            // Extraer los valores de la fila y crear un objeto producto
            productoEncontrado = {
                codigo: $(this).find('.codigo').text(),
                descripcion: $(this).find('.descripcion').text(),
                um: $(this).find('.um').text(),
                cant: $(this).find('.cant').text(),
                vlr_unitario: $(this).find('.vlr_unitario').text(),
                desc: $(this).find('.desc').text(),
                vlr_descuento: $(this).find('.vlr_descuento').text(),
                vlr_unit_final: $(this).find('.vlr_unit_final').text(),
                imp: $(this).find('.imp').text(),
                vlr_impuesto: $(this).find('.vlr_impuesto').text(),
                vlr_parcial: $(this).find('.vlr_parcial').text(),
            };

            // Salir del bucle forEach
            return false;
        }
    });

    return productoEncontrado;
}

// Capturar el evento de clic en el botón "Modificar" producto
$('.btnModificar').click(function() {

    // Obtener el ID del producto a editar
    var idProducto = $('#idProducto').val();
    var imp = 19;

    // Obtener los nuevos valores de los campos de entrada
    var cantidad = $('#cantidadEditar').val();
    var vlrUnitarioFinal = $('#vlrUnitarioFinalEditar').val();
    var vlrParcial = $('#vlrParcialEditar').val();
    var descuento = $('#descuentoEditar').val();

    // Calcular el impuesto basado en el valor parcial y el porcentaje de impuesto
    var valorImp = vlrParcial * imp / 100;

    // Actualizar los valores en la tabla
    $('#tablaProductos tbody tr').each(function() {
        // Obtener el ID de la fila actual
        var idFila = $(this).find('.codigo').text();

        // Verificar si el ID de la fila coincide con el ID del producto a editar
        if (idFila == idProducto) {
            // Actualizar los valores de los campos en la fila correspondiente
            $(this).find('.cant').text(cantidad);
            $(this).find('.vlr_unit_final').text(vlrUnitarioFinal);
            $(this).find('.vlr_parcial').text(vlrParcial);
            $(this).find('.vlr_descuento').text(descuento);
            $(this).find('.vlr_impuesto').text(valorImp);

            // Salir del bucle forEach
            return false;
        }
    });

    //actualizar el subtotal,descuento, valor total
    actualizarTotales();

    // Para cerrar el modal después de modificar los datos
    $('#editarModal').modal('hide');
});

// Capturar el evento de clic en el botón "Facturar" producto
$('.btnFacturar').click(function() {

    // Obtener los valores de los campos de entrada
    var cliente = $('#lstClientesFact').val();
    var factura = $('#lstFacturaFact').val();
    var consecutivo = $('#consecutivo').val();
    var atiende = $('#lstVendedoresFact').val();
    var caja = $('#lstCajaFact').val();
    var bodega = $('#lstBodegaFact').val();
    var total = $('#total').val();
    var nota = $('#notaFact').val();
    var descuentos = $('#descuentos').text(); // Esto obtiene el texto dentro del elemento <p>
    var subtotal = $('#subtotal').text(); // Esto obtiene el texto dentro del elemento <p>

    var fac_efecti = parseFloat(document.getElementById("fac_efecti").value);
    var fac_tdebit = parseFloat(document.getElementById("fac_tdebit").value);
    var fac_tcredi = parseFloat(document.getElementById("fac_tcredi").value);
    var fac_tchequ = parseFloat(document.getElementById("fac_tchequ").value);
    var fac_tvales = parseFloat(document.getElementById("fac_tvales").value);
    var fac_tcambi = parseFloat(document.getElementById("fac_cambio").value);
    // var total = parseFloat(document.getElementById("pay_total_").textContent);

    var sumTotal = fac_efecti + fac_tdebit + fac_tcredi + fac_tchequ + fac_tvales;

    // Crear un objeto con los datos recolectados
    var datos = {
        cliente: cliente,
        factura: factura,
        consecutivo: consecutivo,
        atiende: atiende,
        bodega: bodega,
        caja: caja,
        total: total,
        nota: nota,
        subtotal: subtotal,
        descuentos: descuentos,
        fac_efecti: fac_efecti,
        fac_tdebit: fac_tdebit,
        fac_tcredi: fac_tcredi,
        fac_tchequ: fac_tchequ,
        fac_tvales: fac_tvales,
        fac_tcambi: fac_tcambi,
        detalles: [] // Aquí se agregarán los detalles de la factura
    };

    // Recorrer las filas de la tabla de detalles y agregar los datos de cada fila al objeto 'datos'
    $('#cuerpoTabla tr').each(function(index, fila) {
        var detalle = {
            codigo: $(fila).find('.codigo').text(),
            descripcion: $(fila).find('.descripcion').text(),
            um: $(fila).find('.um').text(),
            cant: $(fila).find('.cant').text(),
            vlrUnitario: $(fila).find('.vlr_unitario').text(),
            desc: $(fila).find('.desc').text(),
            vlrDesc: $(fila).find('.vlr_descuento').text(),
            vlrUnitFinal: $(fila).find('.vlr_unit_final').text(),
            imp: $(fila).find('.imp').text(),
            vlrImp: $(fila).find('.vlr_impuesto').text(),
            vlrParcial: $(fila).find('.vlr_parcial').text()
        };
        datos.detalles.push(detalle);
    });

    if (sumTotal > 0 && fac_tcambi >= 0) {
        // Realizar la solicitud AJAX al servidor
        $.ajax({
            url: 'ajax/facturacionajax.php', // La URL del script PHP que maneja la solicitud
            method: 'POST', // El método de solicitud
            dataType: 'json', // El tipo de datos que esperamos recibir del servidor
            data: { proceso: 'guardar_factura', datos: datos }, // Los datos que se enviarán al servidor

            // Función que se ejecuta cuando la solicitud se completa con éxito
            success: function(response) {
                console.log(response)
                if (response.status == 'success') {
                    $('#pagarFactura').modal('hide');

                    notificacion("Exito", response.status, response.message)
                    limpiarCamposFactura();

                    valores = {}
                    contadorTabla = 0;
                    delete valores;

                    tabla_factura(valores);
                    actualizarTotales();

                } else {
                    notificacion("Error", response.status, response.message)
                }
                // consecutivoP.value = response.datos
            }
        });
    } else {
        notificacion("Realizar pago", "warning", "Para prodeceder con el pago, el valor del cambio debe ser positivo.")
    }
});

// Capturar el evento de clic en el botón "Facturar" producto
$('.btnFacturaEspera').click(function() {

    // Obtener los valores de los campos de entrada
    var cliente = $('#lstClientesFact').val();
    var factura = $('#lstFacturaFact').val();
    var consecutivo = $('#consecutivo').val();
    var atiende = $('#lstVendedoresFact').val();
    var caja = $('#lstCajaFact').val();
    var bodega = $('#lstBodegaFact').val();
    var total = $('#total').val();
    var nota = $('#notaFact').val();
    var descuentos = $('#descuentos').text(); // Esto obtiene el texto dentro del elemento <p>
    var subtotal = $('#subtotal').text(); // Esto obtiene el texto dentro del elemento <p>

    // Crear un objeto con los datos recolectados
    var datos = {
        cliente: cliente,
        factura: factura,
        consecutivo: consecutivo,
        atiende: atiende,
        caja: caja,
        bodega: bodega,
        total: total,
        nota: nota,
        subtotal: subtotal,
        descuentos: descuentos,
        detalles: [] // Aquí se agregarán los detalles de la factura
    };

    // Recorrer las filas de la tabla de detalles y agregar los datos de cada fila al objeto 'datos'
    $('#cuerpoTabla tr').each(function(index, fila) {
        var detalle = {
            codigo: $(fila).find('.codigo').text(),
            descripcion: $(fila).find('.descripcion').text(),
            um: $(fila).find('.um').text(),
            cant: $(fila).find('.cant').text(),
            vlrUnitario: $(fila).find('.vlr_unitario').text(),
            desc: $(fila).find('.desc').text(),
            vlrDesc: $(fila).find('.vlr_descuento').text(),
            vlrUnitFinal: $(fila).find('.vlr_unit_final').text(),
            imp: $(fila).find('.imp').text(),
            vlrImp: $(fila).find('.vlr_impuesto').text(),
            vlrParcial: $(fila).find('.vlr_parcial').text()
        };
        datos.detalles.push(detalle);
    });

    // Realizar la solicitud AJAX al servidor
    $.ajax({
        url: 'ajax/facturacionajax.php', // La URL del script PHP que maneja la solicitud
        method: 'POST', // El método de solicitud
        dataType: 'json', // El tipo de datos que esperamos recibir del servidor
        data: { proceso: 'guardar_factura_espera', datos: datos }, // Los datos que se enviarán al servidor

        // Función que se ejecuta cuando la solicitud se completa con éxito
        success: function(response) {
            console.log(response)
            if (response.status == 'success') {
                notificacion("Exito", response.status, response.message)
                limpiarCamposFactura();

                valores = {}
                contadorTabla = 0;
                delete valores;

                tabla_factura(valores);
                actualizarTotales();
            } else {
                notificacion("Error", response.status, response.message)
            }
            // consecutivoP.value = response.datos
        }
    });

});

function eliminarFila(id) {
    console.log(id)
    delete valores[id];
    tabla_factura(valores);
    actualizarTotales();
    if (valores.length === 0) {
        console.log("deberia duncionar")
        mostrarNoHayRegistros();
    }
}

function mostrarNoHayRegistros() {
    const noHayRegistros = document.getElementById('no_hay_registros');
    noHayRegistros.classList.remove('oculto');
}

function ocultarNoHayRegistros() {
    const noHayRegistros = document.getElementById('no_hay_registros');
    noHayRegistros.classList.add('oculto');
}


$('.btnNuevaFactura').click(function() {

    limpiarCamposFactura();

    valores = {}
    contadorTabla = 0;
    delete valores;

    tabla_factura(valores);
    actualizarTotales();
    mostrarNoHayRegistros();
});

function tabla_factura(valores) {
    // contadorTabla = contadorTabla - 1;
    $('#tablaProductos tbody').empty();

    subtotal = 0;
    descuentos = 0;
    total = 0;

    $.each(valores, function(index, item) {
        $('#tablaProductos tbody').append(
            '<tr>' +
            '<td class="numero"><b>' + index + '</b></td>' +
            '<td class="codigo">' + item.codigo + '</td>' +
            '<td class="descripcion">' + item.descripcion + '</td>' +
            '<td class="um">' + item.um + '</td>' +
            '<td class="cant">' + item.cant + '</td>' +
            '<td class="vlr_unitario">' + item.vlr_unitario + '</td>' +
            '<td class="desc">' + item.desc + '</td>' +
            '<td class="vlr_descuento">' + item.vlr_descuento + '</td>' +
            '<td class="vlr_unit_final">' + item.vlr_unit_final + '</td>' +
            '<td class="imp">' + item.imp + '%</td>' +
            '<td class="vlr_impuesto">' + item.vlr_impuesto + '</td>' +
            '<td class="vlr_parcial">' + item.vlr_parcial + '</td>' +
            '<td class="text-center"><button class="btn btn-outline-warning me-1 mb-1" type="button" onclick=editar("' + item.codigo + '")>' +
            '<span class="fas fa-edit ms-1" data-fa-transform="shrink-3"></span></button>' +
            '<button class="btn btn-outline-danger me-1 mb-1" type="button" onclick=eliminarFila(' + index + ')>' +
            '<span class="fas fa-trash ms-1" data-fa-transform="shrink-3"></span></button></td>' +
            '</tr>'
        );

        /// Sumar al subtotal el valor parcial del producto
        subtotal += parseFloat(item.vlr_parcial) - parseFloat(item.vlr_impuesto);
        descuentos += parseFloat(item.vlr_descuento);
        total += parseFloat(item.vlr_parcial);
        // Sumar al total de impuestos el valor del impuesto del producto
        totalImpuestos += parseFloat(item.vlr_impuesto);
    });

}

// Función para limpiar los campos de la factura
function limpiarCamposFactura() {

    var lstClientesFact = $('#lstClientesFact');
    lstClientesFact.select2({});
    lstClientesFact.find('option').remove();
    cargar_clientes('', 'lstClientesFact', '');

    var lstVendedoresFact = $('#lstVendedoresFact');
    lstVendedoresFact.select2({});
    lstVendedoresFact.find('option').remove();
    cargar_vendedores('', 'lstVendedoresFact', '');

    var lstCajaFact = $('#lstCajaFact');
    lstCajaFact.select2({});
    lstCajaFact.find('option').remove();
    cargar_caja('', 'lstCajaFact', '');

    var lstBodegaFact = $('#lstBodegaFact');
    lstBodegaFact.select2({});
    lstBodegaFact.find('option').remove();
    cargar_bodega('', 'lstBodegaFact', '');

    var lstFacturaFact = $('#lstFacturaFact');
    lstFacturaFact.select2({});
    lstFacturaFact.find('option').remove();
    cargar_factura('', 'lstFacturaFact', '');

    document.getElementById('consecutivo').value = ''; // Limpiar el consecutivo  
    document.getElementById('total').value = ''; // Limpiar el total
    document.getElementById('descuentos').textContent = ''; // Limpiar los descuentos
    document.getElementById('subtotal').textContent = ''; // Limpiar el subtotal
    document.getElementById('notaFact').value = ''; // Limpiar la nota

    // Obtener referencias a los campos
    var fac_efectiInput = document.getElementById("fac_efecti");
    var fac_tdebitInput = document.getElementById("fac_tdebit");
    var fac_tcrediInput = document.getElementById("fac_tcredi");
    var fac_tchequInput = document.getElementById("fac_tchequ");
    var fac_tvalesInput = document.getElementById("fac_tvales");
    var fac_cambioInput = document.getElementById("fac_cambio");

    // Limpiar los campos estableciendo su valor a cero o una cadena vacía
    fac_efectiInput.value = 0;
    fac_tdebitInput.value = 0;
    fac_tcrediInput.value = 0;
    fac_tchequInput.value = 0;
    fac_tvalesInput.value = 0;
    fac_cambioInput.value = 0;
}

// Función para calcular y actualizar el subtotal
function actualizarTotales() {
    var subtotal = 0;
    var descuentos = 0;
    var total = 0;
    var totalP = document.getElementById("total");

    // Recorrer todas las filas de la tabla y sumar los valores parciales de cada producto
    $('#tablaProductos tbody tr').each(function() {
        var vlr_parcial = parseFloat($(this).find('.vlr_parcial').text());
        var vlr_impuesto = parseFloat($(this).find('.vlr_impuesto').text());
        var vlr_descuento = parseFloat($(this).find('.vlr_descuento').text());

        if (!isNaN(vlr_parcial) && !isNaN(vlr_impuesto) && !isNaN(vlr_descuento)) {
            subtotal += vlr_parcial - vlr_impuesto;
            descuentos += vlr_descuento;
            total += vlr_parcial;
        }
    });

    // Actualizar el valor del subtotal en la interfaz de usuario
    $('#subtotal').text(subtotal.toFixed(2));
    $('#descuentos').text(descuentos.toFixed(2));
    totalP.value = total;

    var payTotalSpan = document.getElementById("pay_total_");
    payTotalSpan.textContent = total;
}

// Función para limpiar los inputs después de agregar un producto
function limpiarInputs() {
    var inputs = document.querySelectorAll('.datos_productos input[type="text"]');
    inputs.forEach(function(input) {
        input.value = '';
    });
}

function notificacion(titulo, icon, mensaje) {
    //Mensaje de notificación, muestra un mensaje con SweetAlert
    if (titulo == "Error") {
        color = "#EF5350"
    } else {
        color = "#2196f3"
    }
    Swal.fire({
        title: titulo,
        html: mensaje,
        icon: icon,
        confirmButtonColor: color
    });
}

// Funcion para cargar las listas select con opcion de busqueda de clientes
$('#btnBusquedaClientesFact').click(function() {
    cargar_clientes('', 'lstClientesFact', '');
});

function cargar_clientes(Id, nameSelect, Modal) {
    var lstRoles = $('#' + nameSelect);

    if (Id != "") {
        lstRoles.select2({});
        // var lstRoles = $lstRoles
        lstRoles.find('option').remove();
        var searchTerm = '';
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'ajax/clientesajaxv1.php',
            data: {
                searchTerm: searchTerm,
                proceso: 'combo_clientes',
                id: Id
            },
        }).then(function(registros) {
            $(registros).each(function(i, v) {
                lstRoles.append('<option selected value="' + v.id + '">' + v.text + '</option>');
            })
            lstRoles.trigger({
                type: 'select2:select',
                params: {
                    data: registros
                }
            });
        });

    } else {
        lstRoles.select2({
            placeholder: "Seleccione un cliente",
            ajax: {
                url: "ajax/clientesajaxv1.php",
                type: "post",
                dataType: 'json',
                delay: 150,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        proceso: "combo_clientes",
                        id: Id
                    };
                },
                processResults: function(response) {
                    return {
                        results: response

                    };
                },
                cache: true
            }
        });
    }
}

function cargar_clientes_modal(Id, nameSelect, Modal) {
    var lstRoles = $('#' + nameSelect);

    if (Id != "") {
        lstRoles.select2({
            dropdownParent: $('#' + Modal)
        });
        // var lstRoles = $lstRoles
        lstRoles.find('option').remove();
        var searchTerm = '';
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'ajax/clientesajaxv1.php',
            data: {
                searchTerm: searchTerm,
                proceso: 'combo_clientes',
                id: Id
            },
        }).then(function(registros) {
            $(registros).each(function(i, v) {
                lstRoles.append('<option selected value="' + v.id + '">' + v.text + '</option>');
            })
            lstRoles.trigger({
                type: 'select2:select',
                params: {
                    data: registros
                }
            });
        });

    } else {
        lstRoles.select2({
            placeholder: "Seleccione un cliente",
            dropdownParent: $('#' + Modal),
            ajax: {
                url: "ajax/clientesajaxv1.php",
                type: "post",
                dataType: 'json',
                delay: 150,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        proceso: "combo_clientes",
                        id: Id
                    };
                },
                processResults: function(response) {
                    return {
                        results: response

                    };
                },
                cache: true
            }
        });
    }
}

// Funcion para cargar las listas select con opcion de busqueda de vendedores
$('#btnBusquedaVendedoresAgg').click(function() {
    cargar_vendedores('', 'lstVendedoresFact', '');
});

function cargar_vendedores(Id, nameSelect, Modal) {
    var lstRoles = $('#' + nameSelect);

    if (Id != "") {
        lstRoles.select2({});
        // var lstRoles = $lstRoles
        lstRoles.find('option').remove();
        var searchTerm = '';
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'ajax/clientesajaxv1.php',
            data: {
                searchTerm: searchTerm,
                proceso: 'combo_vendedores',
                id: Id
            },
        }).then(function(registros) {
            $(registros).each(function(i, v) {
                lstRoles.append('<option selected value="' + v.id + '">' + v.text + '</option>');
            })
            lstRoles.trigger({
                type: 'select2:select',
                params: {
                    data: registros
                }
            });
        });

    } else {
        lstRoles.select2({
            placeholder: "Seleccione un vendedor",
            ajax: {
                url: "ajax/clientesajaxv1.php",
                type: "post",
                dataType: 'json',
                delay: 150,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        proceso: "combo_vendedores",
                        id: Id
                    };
                },
                processResults: function(response) {
                    return {
                        results: response

                    };
                },
                cache: true
            }
        });
    }
}

// Funcion para cargar las listas select con opcion de busqueda de vendedores
$('#btnBusquedaFacturaFact').click(function() {
    cargar_factura('', 'lstFacturaFact', '');
});

function cargar_factura(Id, nameSelect, Modal) {
    var lstRoles = $('#' + nameSelect);

    if (Id != "") {
        lstRoles.select2({});
        // var lstRoles = $lstRoles
        lstRoles.find('option').remove();
        var searchTerm = '';
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'ajax/nombodsajax.php',
            data: {
                searchTerm: searchTerm,
                proceso: 'combo_factura',
                id: Id
            },
        }).then(function(registros) {
            $(registros).each(function(i, v) {
                lstRoles.append('<option selected value="' + v.id + '">' + v.text + '</option>');
            })
            lstRoles.trigger({
                type: 'select2:select',
                params: {
                    data: registros
                }
            });
        });

    } else {
        lstRoles.select2({
            placeholder: "Seleccione un factura",
            ajax: {
                url: "ajax/nombodsajax.php",
                type: "post",
                dataType: 'json',
                delay: 150,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        proceso: "combo_factura",
                        id: Id
                    };
                },
                processResults: function(response) {
                    return {
                        results: response

                    };
                },
                cache: true
            }
        });
    }
}

// Funcion para cargar las listas select con opcion de busqueda de vendedores
$('#btnBusquedaCajaFact').click(function() {
    cargar_caja('', 'lstCajaFact', '');
});

function cargar_caja(Id, nameSelect, Modal) {
    var lstRoles = $('#' + nameSelect);

    if (Id != "") {
        lstRoles.select2({});
        // var lstRoles = $lstRoles
        lstRoles.find('option').remove();
        var searchTerm = '';
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'ajax/cajasajax.php',
            data: {
                searchTerm: searchTerm,
                proceso: 'combo_caja',
                id: Id
            },
        }).then(function(registros) {
            $(registros).each(function(i, v) {
                lstRoles.append('<option selected value="' + v.id + '">' + v.text + '</option>');
            })
            lstRoles.trigger({
                type: 'select2:select',
                params: {
                    data: registros
                }
            });
        });

    } else {
        lstRoles.select2({
            placeholder: "Seleccione un caja",
            ajax: {
                url: "ajax/cajasajax.php",
                type: "post",
                dataType: 'json',
                delay: 150,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        proceso: "combo_caja",
                        id: Id
                    };
                },
                processResults: function(response) {
                    return {
                        results: response

                    };
                },
                cache: true
            }
        });
    }
}

// Funcion para cargar las listas select con opcion de busqueda de vendedores
$('#btnBusquedaBodegaFact').click(function() {
    cargar_bodega('', 'lstBodegaFact', '');
});

function cargar_bodega(Id, nameSelect, Modal) {
    var lstRoles = $('#' + nameSelect);

    if (Id != "") {
        lstRoles.select2({});
        // var lstRoles = $lstRoles
        lstRoles.find('option').remove();
        var searchTerm = '';
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'ajax/nombodsajax.php',
            data: {
                searchTerm: searchTerm,
                proceso: 'combo_caja',
                id: Id
            },
        }).then(function(registros) {
            $(registros).each(function(i, v) {
                lstRoles.append('<option selected value="' + v.id + '">' + v.text + '</option>');
            })
            lstRoles.trigger({
                type: 'select2:select',
                params: {
                    data: registros
                }
            });
        });

    } else {
        lstRoles.select2({
            placeholder: "Seleccione una bodega",
            ajax: {
                url: "ajax/nombodsajax.php",
                type: "post",
                dataType: 'json',
                delay: 150,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        proceso: "combo_caja",
                        id: Id
                    };
                },
                processResults: function(response) {
                    return {
                        results: response

                    };
                },
                cache: true
            }
        });
    }
}