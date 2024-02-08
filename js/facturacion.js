$(document).ready(function() {
    cargar_clientes('', 'lstClientesFact', '');
    cargar_vendedores('', 'lstVendedoresFact', '');
});

// Funcion para cargar las listas select con opcion de busqueda
$('#btnBuscarProducto').click(function() {
    $('#buscarProductos').modal('show');
    cargar_productos();
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
            document.getElementById('um').value = "N/A"
            document.getElementById('cant').value = 1
            document.getElementById('vlr_unitario').value = data[0].stmin
            document.getElementById('desc').value = "%"
            document.getElementById('vlr_descuento').value = 0
            document.getElementById('vlr_unit_final').value = data[0].stmin
            document.getElementById('imp').value = 19
            document.getElementById('vlr_impuesto').value = (data[0].stmin * 0.19)
            document.getElementById('vlr_parcial').value = parseFloat(data[0].stmin)
            $('#buscarProductos').modal('hide');

        },
        error: function() {
            // Error en la inserción, muestra mensaje de error con SweetAlert
            notificacion('Error', 'error', response.message);
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
                document.getElementById('um').value = "N/A"
                document.getElementById('cant').value = 1
                document.getElementById('vlr_unitario').value = response.datos[0].stmin
                document.getElementById('desc').value = "%"
                document.getElementById('vlr_descuento').value = 0
                document.getElementById('vlr_unit_final').value = response.datos[0].stmin
                document.getElementById('imp').value = 19
                document.getElementById('vlr_impuesto').value = (response.datos[0].stmin * 0.19)
                document.getElementById('vlr_parcial').value = parseFloat(response.datos[0].stmin)
                    // Y así sucesivamente con los demás campos
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
    var valorFinal = valorUnitario * cantidad - valorDescuento;
    var valorImp = valorFinal * imp / 100;

    // Actualizar los campos de valor descuento, valor unitario final y valor parcial
    $('#vlr_descuento').val(valorDescuento);
    $('#vlr_impuesto').val(valorImp);
    $('#vlr_unit_final').val(valorUnitario - descuento);
    $('#vlr_parcial').val(valorFinal);
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
    contadorTabla++;

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

    console.log(valores);

    $('#tablaProductos tbody').empty();

    subtotal = 0;
    descuentos = 0;
    total = 0;

    $.each(valores, function(index, item) {
        $('#tablaProductos tbody').append(
            '<tr>' +
            '<td class="codigo">' + index + '</td>' +
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
            '<td class="text-center"><button class="btn btn-outline-primary me-1 mb-1" type="button" onclick=eliminar(1)>' +
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

    // Calcular el subtotal restando los impuestos
    // subtotal -= totalImpuestos;

    // Obtener el elemento <p> por su ID
    // Asignar un valor utilizando textContent
    subtotalP.innerText = subtotal.toFixed(2); // Redondear el subtotal a dos decimales
    descuentosP.innerText = descuentos.toFixed(2); // Redondear el subtotal a dos decimales
    totalP.value = total; // Redondear el subtotal a dos decimales


    // Limpiar los inputs después de agregar el producto
    limpiarInputs();
});

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
        text: mensaje,
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

// Funcion para cargar las listas select con opcion de busqueda de vendedores
$('#btnBusquedaVendedoresFact').click(function() {
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