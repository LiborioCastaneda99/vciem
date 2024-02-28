$(document).ready(function() {
    cargar_tabla()
});

//consultar
function cargar_tabla() {
    $('#tabla').dataTable().fnDestroy();
    $('#tabla').DataTable({
        "responsive": true,
        dom: 'lBfrtip',
        buttons: [{
                className: 'btn btn-falcon-default btn-sm mx-2',
                text: '<span class="fas fa-plus" data-fa-transform="shrink-3"></span> ' +
                    'Agregar ',
                action: function() {
                    abrirModal();
                }
            },
            {
                extend: 'collection',
                init: (api, node, config) => $(node).removeClass('btn-secondary'),
                className: 'btn btn-falcon-default btn-sm mx-2',
                text: '<span class="fas fa-file-export" data-fa-transform="shrink-3"></span> ' +
                    'Exportar',
                buttons: [{
                        extend: 'csvHtml5',
                        titleAttr: 'Csv',
                        className: 'btn btn-falcon-default btn-sm mx-2',
                        text: '<span class="fas fa-file-csv" data-fa-transform="shrink-3"></span> ' +
                            'Exportar a CSV ',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        className: 'btn btn-falcon-default btn-sm mx-2',
                        text: '<span class="fas fa-file-csv" data-fa-transform="shrink-3"></span> ' +
                            'Exportar a Excel ',
                        titleAttr: 'Csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<span class="fas fa-file-pdf" data-fa-transform="shrink-3"></span> ' +
                            'Exportar a PDF ',
                        className: 'btn btn-falcon-default btn-sm mx-2',
                        titleAttr: 'Csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    },
                ],
            },
            {
                extend: 'print',
                init: (api, node, config) => $(node).removeClass('btn-secondary'),
                className: 'btn btn-falcon-default btn-sm mx-2',
                text: '<span class="fas fa-print" data-fa-transform="shrink-3"></span> ' +
                    'Imprimir ',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6]
                }
            }
        ],
        "columnDefs": [{
                // El numero correspode a la ultima columna iniciando en 0
                "targets": [7, 8],
                "orderable": false,
                "width": "70px",
                "className": "text-center",
            },
            {
                // El numero correspode a la ultima columna iniciando en 0
                "targets": [0],
                "width": "120px",
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
            'url': 'ajax/clientesajaxv1.php',
            'data': {
                'proceso': 'get'
            },
            'method': 'POST'
        },
        'columns': [{
                data: 'codigo'
            },
            {
                data: 'zona'
            },
            {
                data: 'subzona'
            },
            {
                data: 'nombre'
            },
            {
                data: 'direc'
            },
            {
                data: 'tel1'
            },
            {
                data: 'tel2'
            },
            {
                data: 'editar'
            },
            {
                data: 'eliminar'
            },
        ],
        drawCallback: function() {
            $(".btn-group").addClass("btn-group-sm");
        }
    });
}

//consultar documento
function obtenerDocumento(codigo) {
    var urlprocess = "ajax/clientesajaxv1.php";
    var btnSiguiente = document.getElementById("btnSiguiente");

    $.ajax({
        type: 'POST',
        url: urlprocess,
        data: { proceso: 'get_cod', codigo: codigo },
        dataType: 'json',
        success: function(data) {
            if (data.status == "Error") {
                notificacion('Error', 'error', data.mensaje);
                btnSiguiente.disabled = true;
            } else {
                btnSiguiente.disabled = false;
            }
        },
        error: function(error) {
            notificacion('Error', 'error', error);
        }
    });
}

// Función para obtener los datos de un formulario
function obtenerDatosFormulario(formulario) {
    var elementos = formulario.elements;
    var datos = {};

    for (var i = 0; i < elementos.length; i++) {
        var elemento = elementos[i];
        if (elemento.tagName === 'INPUT' || elemento.tagName === 'SELECT' || elemento.tagName === 'TEXTAREA') {
            datos[elemento.name] = elemento.value;
        }
    }

    return datos;
}

// Función para obtener los datos de todos los formularios
function obtenerDatosFormularios(frm1, frm2, frm3) {
    var datos = {};

    // Obtener datos del formulario 1
    var formulario1 = document.getElementById(frm1);
    datos[frm1] = obtenerDatosFormulario(formulario1);

    // Obtener datos del formulario 2
    var formulario2 = document.getElementById(frm2);
    datos[frm2] = obtenerDatosFormulario(formulario2);

    // Obtener datos del formulario 3
    var formulario3 = document.getElementById(frm3);
    datos[frm3] = obtenerDatosFormulario(formulario3);

    return datos;
}

// Función para validar que todos los formularios tengan valores
function validarFormularios(datos) {
    var datos_formateados = {};

    for (var formulario in datos) {
        if (datos.hasOwnProperty(formulario)) {
            var datosFormulario = datos[formulario];
            for (var campo in datosFormulario) {
                if (datosFormulario.hasOwnProperty(campo)) {
                    // Excluir campo tel2 del formulario 1 de la validación
                    if (formulario === 'fmr_clientes1' && campo === 'tel2') {
                        if (!datosFormulario[campo]) {
                            datos_formateados[campo] = ''
                        } else {
                            datos_formateados[campo] = datosFormulario[campo]
                        }
                        continue;
                    }
                    if (formulario === 'fmr_clientes2' && campo === 'tel2') {
                        if (!datosFormulario[campo]) {
                            datos_formateados[campo] = ''
                        } else {
                            datos_formateados[campo] = datosFormulario[campo]
                        }
                        continue;
                    }
                    if (formulario === 'fmr_clientes3' && campo === 'tel2') {
                        if (!datosFormulario[campo]) {
                            datos_formateados[campo] = ''
                        } else {
                            datos_formateados[campo] = datosFormulario[campo]
                        }
                        continue;
                    }

                    if (!datosFormulario[campo]) {
                        console.log('El formulario ' + formulario + ' tiene un campo vacío: ' + campo);
                        return false;
                    }
                    datos_formateados[campo] = datosFormulario[campo]
                }
            }
        }
    }
    return { 'valido': true, 'datos': datos_formateados };
}

// Agregar evento al botón "Siguiente"
var btnSiguiente = document.getElementById('btnSiguiente');
btnSiguiente.addEventListener('click', function() {
    var datosFormularios = obtenerDatosFormularios('fmr_clientes1', 'fmr_clientes2', 'fmr_clientes3');
    var resultadoValidacion = validarFormularios(datosFormularios);

    if (resultadoValidacion.valido) {
        console.log('Todos los formularios tienen valores válidos.');
        console.table(resultadoValidacion.datos)
        var datos_formulario_json = resultadoValidacion.datos
        datos_formulario_json["proceso"] = "guardar";

        // Hacer la solicitud AJAX para guardar la nuevo cliente
        $.ajax({
            type: 'POST',
            url: 'ajax/clientesajaxv1.php',
            data: datos_formulario_json,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // limpiamos el formulario
                    $('.fmr_clientes')[0].reset();

                    // Selecciona el elemento por su ID
                    var resp_titulo = document.getElementById('resp_titulo');
                    var resp_mensaje = document.getElementById('resp_mensaje');

                    // Actualiza el contenido del elemento con el valor
                    resp_titulo.innerHTML = 'Éxito';
                    resp_mensaje.innerHTML = response.message;

                    cargar_tabla();
                } else {
                    // Error en la inserción, muestra mensaje de error con SweetAlert
                    notificacion('Error', 'error', response.message);
                }
            },
            error: function() {
                // Error en la inserción, muestra mensaje de error con SweetAlert
                notificacion('Error', 'error', response.message);
            }
        });


        // Aquí puedes enviar los datos a través de Ajax o realizar otras acciones.
    } else {
        console.log('Al menos un formulario tiene campos vacíos.');
    }
});


// Agregar evento al botón "Modificar"
var btnSiguiente = document.getElementById('btnSiguienteMod');
btnSiguiente.addEventListener('click', function() {
    var datosFormularios = obtenerDatosFormularios('fmr_clientes1_mod', 'fmr_clientes2_mod', 'fmr_clientes3_mod');
    var resultadoValidacion = validarFormularios(datosFormularios);

    if (resultadoValidacion.valido) {
        console.log('Todos los formularios tienen valores válidos.');
        console.table(resultadoValidacion.datos)
        var datos_formulario_json = resultadoValidacion.datos
        datos_formulario_json["proceso"] = "modificar";

        // Hacer la solicitud AJAX para modificar la nuevo cliente
        $.ajax({
            type: 'POST',
            url: 'ajax/clientesajaxv1.php',
            data: datos_formulario_json,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // limpiamos el formulario
                    $('.fmr_clientes_mod')[0].reset();

                    // Selecciona el elemento por su ID
                    var resp_titulo = document.getElementById('resp_titulo_mod');
                    var resp_mensaje = document.getElementById('resp_mensaje_mod');

                    // Actualiza el contenido del elemento con el valor
                    resp_titulo.innerHTML = 'Éxito';
                    resp_mensaje.innerHTML = response.message;

                    cargar_tabla();
                } else {
                    // Error en la inserción, muestra mensaje de error con SweetAlert
                    notificacion('Error', 'error', response.message);
                }
            },
            error: function() {
                // Error en la inserción, muestra mensaje de error con SweetAlert
                notificacion('Error', 'error', response.message);
            }
        });


        // Aquí puedes enviar los datos a través de Ajax o realizar otras acciones.
    } else {
        console.log('Al menos un formulario tiene campos vacíos.');
    }
});

// funcion para crear la notificacion
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
        confirmButtoncliente: color
    });
}

// funcion para generar el pdf
function generar() {
    // Abre la URL del archivo PDF en una nueva pestaña
    window.open('pdfs/generar_pdf_clientes.php', '_blank');

}
// Función para cerrar el modal
function cerrar_modal() {
    $('#guardarModal').modal('hide');
}

function abrirModal() {
    // $('#fmr_clientes1')[0].reset();
    // $('#fmr_clientes2')[0].reset();
    // $('#fmr_clientes3')[0].reset();
    // Limpiar los campos del modal
    document.getElementById('fmr_clientes1').reset();
    document.getElementById('fmr_clientes2').reset();
    document.getElementById('fmr_clientes3').reset();

    // Restablecer el estado de cualquier otro elemento si es necesario
    document.getElementById('abrir').click(); // Hacer clic en la primera pestaña para restablecerla como activa

    // Cerrar el modal si está abierto
    $('#guardarModal').modal('hide');

    $('#guardarModal').modal('show');
    // document.getElementById('abrir').click();
    cargar_departamentos("", 'lstSucursal', 'guardarModal')
    cargar_departamentos("", 'lstZonas', 'guardarModal')
    cargar_ciudades("", 'lstSubzonas', 'guardarModal')
    cargar_ciudades("", 'lstSubzonas', 'guardarModal')
    cargar_vendedores('', 'vende', 'guardarModal');

}

function cargar_select(id) {
    cargar_ciudades(id, 'lstSubzonas', 'guardarModal', 'combo_ciudades_all')
}

function cargar_departamentos(Id, nameSelect, Modal) {
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
                proceso: 'combo_departamentos',
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
            placeholder: "Seleccione un departamento",
            dropdownParent: $('#' + Modal),
            ajax: {
                url: "ajax/clientesajaxv1.php",
                type: "post",
                dataType: 'json',
                delay: 150,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        proceso: "combo_departamentos",
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

function cargar_ciudades(Id, nameSelect, Modal, Proceso) {
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
                proceso: Proceso,
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
            placeholder: "Seleccione una ciudad",
            dropdownParent: $('#' + Modal),
            ajax: {
                url: "ajax/clientesajaxv1.php",
                type: "post",
                dataType: 'json',
                delay: 150,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        proceso: "combo_ciudades",
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
    cargar_vendedores('', 'vende', 'guardarModal');
});

function cargar_vendedores(Id, nameSelect, Modal) {
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
            dropdownParent: $('#' + Modal),
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

// editar
function editar(id) {

    // Hacer la solicitud AJAX al servidor
    var urlprocess = 'ajax/clientesajaxv1.php';
    $.ajax({
        type: 'POST',
        url: urlprocess,
        data: 'id=' + id + '&proceso=get_id',
        dataType: 'json',
        success: function(data) {

            // primera parte form
            document.getElementsByName('id')[0].value = data[0].id;
            document.getElementsByName('codigo_mod')[0].value = data[0].codigo;
            // document.getElementsByName('lstSucursal_mod')[0].value = data[0].sucursal
            // document.getElementsByName('lstZonas_mod')[0].value = data[0].zona
            // document.getElementsByName('lstSubzonas_mod')[0].value = data[0].subzona
            document.getElementsByName('nombre_mod')[0].value = data[0].nombre
            document.getElementsByName('direc_mod')[0].value = data[0].direc
            document.getElementsByName('correo_mod')[0].value = data[0].correo
            document.getElementsByName('tel1_mod')[0].value = data[0].tel1
            document.getElementsByName('tel2_mod')[0].value = data[0].tel2
            cargar_departamentos(data[0].zona, 'lstZonas_mod', 'editarModal')
            cargar_departamentos(data[0].sucursal, 'lstSucursal_mod', 'editarModal')
            cargar_ciudades(data[0].subzona, 'lstSubzonas_mod', 'editarModal', 'combo_ciudades_cod')


            document.getElementsByName('vende_mod')[0].value = data[0].vendedor
            document.getElementsByName('legal_mod')[0].value = data[0].legal
            document.getElementsByName('cupo_mod')[0].value = data[0].cupo
            document.getElementsByName('fing_mod')[0].value = data[0].fecha_ini
            document.getElementsByName('fpago_mod')[0].value = data[0].forma_pago
            document.getElementsByName('digito_mod')[0].value = data[0].digito
            document.getElementsByName('chdev_mod')[0].value = data[0].caract_dev
            document.getElementsByName('riva_mod')[0].value = data[0].riva
            document.getElementsByName('rfte_mod')[0].value = data[0].rfte
            document.getElementsByName('rica_mod')[0].value = data[0].rica
            document.getElementsByName('tipo_mod')[0].value = data[0].tipo
            document.getElementsByName('distri_mod')[0].value = data[0].distri
            document.getElementsByName('clase_mod')[0].value = data[0].cali
            document.getElementsByName('person_mod')[0].value = data[0].person
            document.getElementsByName('regime_mod')[0].value = data[0].regime
            document.getElementsByName('pais_mod')[0].value = data[0].pais
            document.getElementsByName('tipoid_mod')[0].value = data[0].tipoid
            document.getElementsByName('nom1_mod')[0].value = data[0].nom1
            document.getElementsByName('nom2_mod')[0].value = data[0].nom2
            document.getElementsByName('ape1_mod')[0].value = data[0].ape1
            document.getElementsByName('ape2_mod')[0].value = data[0].ape2


            // Limpiar el cuerpo de la tabla
            $('#editarModal').modal('show'); // abrir

        },
        error: function() {
            // Error en la inserción, muestra mensaje de error con SweetAlert
            notificacion('Error', 'error', response.message);
        }
    });
}

$(".fmr_clientes_editar").submit(function(event) {
    event.preventDefault();
    codigo = $("#codigo_mod").val()
        // sucursal = $("#sucursal_mod").val()
        // zona = $("#zona_mod").val()
        // subzona = $("#subzona_mod").val()
        // nombre = $("#nombre_mod").val()
        // direc = $("#direc_mod").val()
        // tel1 = $("#tel1_mod").val()
        // tel2 = $("#tel2_mod").val()
        // ciudad = $("#ciudad_mod").val()
        // Supongamos que este código se ejecuta después de que se ha guardado con éxito una nuevo cliente
    var nuevoCliente = {
        codigo: $("#codigo_mod").val(),
        // sucursal: $("#sucursal_mod").val(),
        // zona: $("#zona_mod").val(),
        // subzona: $("#subzona_mod").val(),
        // nombre: $("#nombre_mod").val(),
        // direc: $("#direc_mod").val(),
        // tel1: $("#tel1_mod").val(),
        // tel2: $("#tel2_mod").val(),
        // ciudad: $("#ciudad_mod").val(),
        // vendedordor: $("#vendedordor_mod").val(),
        // cupo: $("#cupo_mod").val(),
        // legal: $("#legal_mod").val(),
        // fecha_ini: $("#fecha_ini_mod").val(),
        // forma_pago: $("#forma_pago_mod").val(),
        // correo: $("#correo_mod").val(),
        // cod_viejo: $("#cod_viejo_mod").val(),
        // caract_dev: $("#caract_dev_mod").val(),
        // digito: $("#digito_mod").val(),
        // riva: $("#riva_mod").val(),
        // rfte: $("#rfte_mod").val(),
        // rica: $("#rica_mod").val(),
        // alma: $("#alma_mod").val(),
        // cali: $("#cali_mod").val(),
        // tipo: $("#tipo_mod").val(),
        // distri: $("#distri_mod").val(),
        // genom: $("#genom_mod").val(),
        // geema: $("#geema_mod").val(),
        // getel1: $("#getel1_mod").val(),
        // getel2: $("#getel2_mod").val(),
        // conom: $("#conom_mod").val(),
        // coema: $("#coema_mod").val(),
        // cotel1: $("#cotel1_mod").val(),
        // cotel2: $("#cotel2_mod").val(),
        // panom: $("#panom_mod").val(),
        // paema: $("#paema_mod").val(),
        // patel1: $("#patel1_mod").val(),
        // patel2: $("#patel2_mod").val(),
        // otnom: $("#otnom_mod").val(),
        // otema: $("#otema_mod").val(),
        // ottel1: $("#ottel1_mod").val(),
        // ottel2: $("#ottel2_mod").val(),
        // remis: $("#remis_mod").val(),
        // fbloq: $("#fbloq_mod").val(),
        // diaser: $("#diaser_mod").val(),
        // diater: $("#diater_mod").val(),
        // vlrarr: $("#vlrarr_mod").val(),
        // acta: $("#acta_mod").val(),
        // pacta: $("#pacta_mod").val(),
        // exclui: $("#exclui_mod").val(),
        // person: $("#person_mod").val(),
        // regime: $("#regime_mod").val(),
        // tipoid: $("#tipoid_mod").val(),
        // nomreg: $("#nomreg_mod").val(),
        // pais: $("#pais_mod").val(),
        // nom1: $("#nom1_mod").val(),
        // nom2: $("#nom2_mod").val(),
        // ape1: $("#ape1_mod").val(),
        // ape2: $("#ape2_mod").val(),
        // ofi: $("#ofi_mod").val(),
        // difici: $("#difici_mod").val(),
        // remval: $("#remval_mod").val(),
        // estado: $("#estado_mod").val(),
        // cono: $("#cono_mod").val(),
        // emailq: $("#emailq_mod").val(),
        id: $("#id").val()
    };
    if (codigo == "" || sucursal == "" || zona == "" || subzona == "" || nombre == "" ||
        direc == "" || tel1 == "" || tel2 == "" || ciudad == "") {
        // alert("Por favor, completa todos los campos.");
        notificacion('Error', 'error', "Por favor, completa todos los campos.");
        return;
    } else {
        // Hacer la solicitud AJAX para guardar la nuevo cliente
        $.ajax({
            type: 'POST',
            url: 'ajax/clientesajax.php',
            data: {
                proceso: 'modificar',
                codigo: nuevoCliente.codigo,
                sucursal: nuevoCliente.sucursal,
                zona: nuevoCliente.zona,
                subzona: nuevoCliente.subzona,
                nombre: nuevoCliente.nombre,
                direc: nuevoCliente.direc,
                tel1: nuevoCliente.tel1,
                tel2: nuevoCliente.tel2,
                ciudad: nuevoCliente.ciudad,
                // vendedordor: nuevoCliente.vendedordor,
                // cupo: nuevoCliente.cupo,
                // legal: nuevoCliente.legal,
                // fecha_ini: nuevoCliente.fecha_ini,
                // forma_pago: nuevoCliente.forma_pago,
                // correo: nuevoCliente.correo,
                // cod_viejo: nuevoCliente.cod_viejo,
                // caract_dev: nuevoCliente.caract_dev,
                // digito: nuevoCliente.digito,
                // rfte: nuevoCliente.rfte,
                // riva: nuevoCliente.riva,
                // rica: nuevoCliente.rica,
                // alma: nuevoCliente.alma,
                // cali: nuevoCliente.cali,
                // tipo: nuevoCliente.tipo,
                // distri: nuevoCliente.distri,
                // genom: nuevoCliente.genom,
                // geema: nuevoCliente.geema,
                // getel1: nuevoCliente.getel1,
                // getel2: nuevoCliente.getel2,
                // conom: nuevoCliente.conom,
                // coema: nuevoCliente.coema,
                // cotel1: nuevoCliente.cotel1,
                // cotel2: nuevoCliente.cotel2,
                // panom: nuevoCliente.panom,
                // paema: nuevoCliente.paema,
                // patel1: nuevoCliente.patel1,
                // patel2: nuevoCliente.patel2,
                // otnom: nuevoCliente.otnom,
                // otema: nuevoCliente.otema,
                // ottel1: nuevoCliente.ottel1,
                // ottel2: nuevoCliente.ottel2,
                // remis: nuevoCliente.remis,
                // fbloq: nuevoCliente.fbloq,
                // diaser: nuevoCliente.diaser,
                // diater: nuevoCliente.diater,
                // vlrarr: nuevoCliente.vlrarr,
                // acta: nuevoCliente.acta,
                // pacta: nuevoCliente.pacta,
                // exclui: nuevoCliente.exclui,
                // person: nuevoCliente.person,
                // regime: nuevoCliente.regime,
                // tipoid: nuevoCliente.tipoid,
                // nomreg: nuevoCliente.nomreg,
                // pais: nuevoCliente.pais,
                // nom1: nuevoCliente.nom1,
                // nom2: nuevoCliente.nom2,
                // ape1: nuevoCliente.ape1,
                // ape2: nuevoCliente.ape2,
                // ofi: nuevoCliente.ofi,
                // difici: nuevoCliente.difici,
                // remval: nuevoCliente.remval,
                // estado: nuevoCliente.estado,
                // cono: nuevoCliente.cono,
                // emailq: nuevoCliente.emailq,
                id: nuevoCliente.id
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // cerramos el modal
                    $('#editarModal').modal('hide');
                    // limpiamos el formulario
                    $('#fmr_clientes_editar')[0].reset();
                    // mostramos la alerta
                    notificacion('Éxito', 'success', response.message);

                    cargar_tabla();
                } else {
                    // Error en la inserción, muestra mensaje de error con SweetAlert
                    notificacion('Error', 'error', response.message);
                }
            },
            error: function() {
                // Error en la inserción, muestra mensaje de error con SweetAlert
                notificacion('Error', 'error', response.message);
            }
        });
    }
});

// eliminar
function eliminar(id) {

    // Utiliza SweetAlert para confirmar la eliminación
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Seguro que deseas eliminar la cliente?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminarlo',
        cancelButtonText: 'No, cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Realiza la solicitud de eliminación al servidor (aquí deberías hacer tu llamada AJAX)
            $.ajax({
                type: 'POST',
                url: 'ajax/clientesajax.php',
                data: {
                    proceso: 'eliminar',
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        notificacion('Éxito', 'success', response.message);

                        cargar_tabla();
                    } else {
                        // Error en la inserción, muestra mensaje de error con SweetAlert
                        notificacion('Error', 'error', response.message);
                    }
                },
                error: function() {
                    notificacion('Error', 'error', response.message)
                }
            });
        }
    });
}