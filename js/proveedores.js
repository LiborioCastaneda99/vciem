$(document).ready(function() {
    cargar_tabla();
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
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        className: 'btn btn-falcon-default btn-sm mx-2',
                        text: '<span class="fas fa-file-csv" data-fa-transform="shrink-3"></span> ' +
                            'Exportar a Excel ',
                        titleAttr: 'Csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<span class="fas fa-file-pdf" data-fa-transform="shrink-3"></span> ' +
                            'Exportar a PDF ',
                        className: 'btn btn-falcon-default btn-sm mx-2',
                        titleAttr: 'Csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19]
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
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19]
                }
            }
        ],
        "columnDefs": [{
                // El numero correspode a la ultima columna iniciando en 0
                "targets": [20, 21],
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
            'url': 'ajax/proveedoresajax.php',
            'data': {
                'proceso': 'get'
            },
            'method': 'POST'
        },
        'columns': [{ data: 'codigo' },
            { data: 'suc' },
            { data: 'zona' },
            { data: 'subzona' },
            { data: 'nombre' },
            { data: 'dir' },
            { data: 'tel1' },
            { data: 'tel2' },
            { data: 'ciudad' },
            { data: 'cupo' },
            { data: 'legal' },
            { data: 'fecha_ini' },
            { data: 'forma_pago' },
            { data: 'correo' },
            { data: 'caract_dev' },
            { data: 'digito' },
            { data: 'riva' },
            { data: 'rfte' },
            { data: 'rica' },
            { data: 'estado' },
            { data: 'editar' },
            { data: 'eliminar' },
        ],
        drawCallback: function() {
            $(".btn-group").addClass("btn-group-sm");
        }
    });
}

function abrirModal() {

    // Cerrar el modal si está abierto
    $('#guardarModal').modal('hide');

    $('#guardarModal').modal('show');
    // document.getElementById('abrir').click();
    cargar_departamentos("", 'suc', 'guardarModal')
    cargar_departamentos("", 'zona', 'guardarModal')
    cargar_ciudades("", 'subzona', 'guardarModal')
    cargar_ciudades_sola("", 'ciudad', 'guardarModal')
}

// Funcion para cargar las listas select con opcion de busqueda de vendedores
$('#btnBusquedaSucursalMod').click(function() {
    cargar_departamentos('', 'suc_mod', 'editarModal');
});

// Funcion para cargar las listas select con opcion de busqueda de vendedores
$('#btnBusquedaZonaMod').click(function() {
    cargar_departamentos('', 'zona_mod', 'editarModal')
});

// Funcion para cargar las listas select con opcion de busqueda de vendedores
$('#btnBusquedaSubzonaMod').click(function() {
    cargar_departamentos('', 'subzona_mod', 'editarModal', 'combo_ciudades_all')
});

// Funcion para cargar las listas select con opcion de busqueda de vendedores
$('#btnBusquedaCiudadAgg').click(function() {
    cargar_ciudades_sola('', 'ciudad', 'guardarModal')
});

// Funcion para cargar las listas select con opcion de busqueda de vendedores
$('#btnBusquedaCiudadMod').click(function() {
    cargar_ciudades_sola('', 'ciudad_mod', 'editarModal')
});

function cargar_select(id) {
    cargar_ciudades(id, 'subzona_mod', 'editarModal', 'combo_ciudades_all')
}

function cargar_select_agg(id) {
    cargar_ciudades(id, 'subzona', 'guardarModal', 'combo_ciudades_all')
}

function cargar_ciudades_sola(Id, nameSelect, Modal) {
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
            url: 'ajax/ciudadesajax.php',
            data: {
                searchTerm: searchTerm,
                proceso: 'combo_ciudades',
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
                url: "ajax/ciudadesajax.php",
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

// guardar
$(".fmr_proveedores").submit(function(event) {
    event.preventDefault();

    codigo = $("#codigo").val()
    suc = $("#suc").val()
    zona = $("#zona").val()
    subzona = $("#subzona").val()
    nombre = $("#nombre").val()
    dir = $("#dir").val()
    tel1 = $("#tel1").val()
    tel2 = $("#tel2").val()
    ciudad = $("#ciudad").val()
    cupo = $("#cupo").val()
    legal = $("#legal").val()
    fecha_ini = $("#fecha_ini").val()
    fpago = $("#fpago").val()
    correo = $("#correo").val()
    caract_dev = $("#caract_dev").val()
    digito = $("#digito").val()
    riva = $("#riva").val()
    rfte = $("#rfte").val()
    rica = $("#rica").val()
    estado = $("#estado").val()

    // Supongamos que este código se ejecuta después de que se ha guardado con éxito un nuevo proveedor
    var nuevoproveedor = {
        codigo: $("#codigo").val(),
        suc: $("#suc").val(),
        zona: $("#zona").val(),
        subzona: $("#subzona").val(),
        nombre: $("#nombre").val(),
        dir: $("#dir").val(),
        tel1: $("#tel1").val(),
        tel2: $("#tel2").val(),
        ciudad: $("#ciudad").val(),
        cupo: $("#cupo").val(),
        legal: $("#legal").val(),
        fecha_ini: $("#fecha_ini").val(),
        fpago: $("#fpago").val(),
        correo: $("#correo").val(),
        caract_dev: $("#caract_dev").val(),
        digito: $("#digito").val(),
        riva: $("#riva").val(),
        rfte: $("#rfte").val(),
        rica: $("#rica").val(),
        estado: $("#estado").val()
    };

    if (codigo == "" || suc == "" || zona == "" || subzona == "" || nombre == "" || dir == "" ||
        tel1 == "" || tel2 == "" || ciudad == "" || cupo == "" || legal == "" || fecha_ini == "" ||
        fpago == "" || correo == "" || caract_dev == "" || digito == "" || riva == "" || rfte == "" ||
        rica == "" || estado == "") {
        // alert("Por favor, completa todos los campos.");
        notificacion('Error', 'error', "Por favor, completa todos los campos.");
        return;
    } else {

        // Hacer la solicitud AJAX para guardar la nuevo proveedor
        $.ajax({
            type: 'POST',
            url: 'ajax/proveedoresajax.php',
            data: {
                proceso: 'guardar',
                codigo: nuevoproveedor.codigo,
                suc: nuevoproveedor.suc,
                zona: nuevoproveedor.zona,
                subzona: nuevoproveedor.subzona,
                nombre: nuevoproveedor.nombre,
                dir: nuevoproveedor.dir,
                tel1: nuevoproveedor.tel1,
                tel2: nuevoproveedor.tel2,
                ciudad: nuevoproveedor.ciudad,
                cupo: nuevoproveedor.cupo,
                legal: nuevoproveedor.legal,
                fecha_ini: nuevoproveedor.fecha_ini,
                fpago: nuevoproveedor.fpago,
                correo: nuevoproveedor.correo,
                caract_dev: nuevoproveedor.caract_dev,
                digito: nuevoproveedor.digito,
                riva: nuevoproveedor.riva,
                rfte: nuevoproveedor.rfte,
                rica: nuevoproveedor.rica,
                estado: nuevoproveedor.estado
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // cerramos el modal
                    $('#guardarModal').modal('hide');
                    // limpiamos el formulario
                    $('#fmr_proveedores')[0].reset();
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

// editar
function editar(id) {

    // Hacer la solicitud AJAX al servidor
    var urlprocess = 'ajax/proveedoresajax.php';
    $.ajax({
        type: 'POST',
        url: urlprocess,
        data: 'id=' + id + '&proceso=get_id',
        dataType: 'json',
        success: function(data) {

            // Asignar un valor al input
            document.getElementById('id').value = data[0].id
            document.getElementById('codigo_mod').value = data[0].codigo
            cargar_departamentos(data[0].suc, 'suc_mod', 'editarModal')
            cargar_departamentos(data[0].zona, 'zona_mod', 'editarModal')
            cargar_ciudades(data[0].subzona, 'subzona_mod', 'editarModal', 'combo_ciudades_cod')
            document.getElementById('nombre_mod').value = data[0].nombre
            document.getElementById('dir_mod').value = data[0].dir
            document.getElementById('tel1_mod').value = data[0].tel1
            document.getElementById('tel2_mod').value = data[0].tel2
            document.getElementById('ciudad_mod').value = data[0].ciudad
            cargar_ciudades_sola(data[0].ciudad, 'ciudad_mod', 'editarModal')
            document.getElementById('cupo_mod').value = data[0].cupo
            document.getElementById('legal_mod').value = data[0].legal
            document.getElementById('fecha_ini_mod').value = data[0].fecha_ini
            document.getElementById('fpago_mod').value = data[0].forma_pago
            document.getElementById('correo_mod').value = data[0].correo
            document.getElementById('caract_dev_mod').value = data[0].caract_dev
            document.getElementById('digito_mod').value = data[0].digito
            document.getElementById('riva_mod').value = data[0].riva
            document.getElementById('rfte_mod').value = data[0].rfte
            document.getElementById('rica_mod').value = data[0].rica
            document.getElementById('estado_mod').value = data[0].estado

            // Limpiar el cuerpo de la tabla
            $('#editarModal').modal('show'); // abrir

        },
        error: function() {
            // Error en la inserción, muestra mensaje de error con SweetAlert
            notificacion('Error', 'error', response.message);
        }
    });
}

$(".fmr_proveedores_editar").submit(function(event) {
    event.preventDefault();

    codigo = $("#codigo_mod").val()
    suc = $("#suc_mod").val()
    zona = $("#zona_mod").val()
    subzona = $("#subzona_mod").val()
    nombre = $("#nombre_mod").val()
    dir = $("#dir_mod").val()
    tel1 = $("#tel1_mod").val()
    tel2 = $("#tel2_mod").val()
    ciudad = $("#ciudad_mod").val()
    cupo = $("#cupo_mod").val()
    legal = $("#legal_mod").val()
    fecha_ini = $("#fecha_ini_mod").val()
    fpago = $("#fpago_mod").val()
    correo = $("#correo_mod").val()
    caract_dev = $("#caract_dev_mod").val()
    digito = $("#digito_mod").val()
    riva = $("#riva_mod").val()
    rfte = $("#rfte_mod").val()
    rica = $("#rica_mod").val()
    estado = $("#estado_mod").val()

    // Supongamos que este código se ejecuta después de que se ha guardado con éxito una nuevo proveedor
    var nuevoproveedor = {
        codigo: $("#codigo_mod").val(),
        suc: $("#suc_mod").val(),
        zona: $("#zona_mod").val(),
        subzona: $("#subzona_mod").val(),
        nombre: $("#nombre_mod").val(),
        dir: $("#dir_mod").val(),
        tel1: $("#tel1_mod").val(),
        tel2: $("#tel2_mod").val(),
        ciudad: $("#ciudad_mod").val(),
        cupo: $("#cupo_mod").val(),
        legal: $("#legal_mod").val(),
        fecha_ini: $("#fecha_ini_mod").val(),
        fpago: $("#fpago_mod").val(),
        correo: $("#correo_mod").val(),
        caract_dev: $("#caract_dev_mod").val(),
        digito: $("#digito_mod").val(),
        riva: $("#riva_mod").val(),
        rfte: $("#rfte_mod").val(),
        rica: $("#rica_mod").val(),
        estado: $("#estado_mod").val(),
        id: $("#id").val()
    };

    if (codigo == "" || suc == "" || zona == "" || subzona == "" || nombre == "" || dir == "" ||
        tel1 == "" || tel2 == "" || ciudad == "" || cupo == "" || legal == "" || fecha_ini == "" ||
        fpago == "" || correo == "" || caract_dev == "" || digito == "" || riva == "" || rfte == "" ||
        rica == "" || estado == "") {
        // alert("Por favor, completa todos los campos.");
        notificacion('Error', 'error', "Por favor, completa todos los campos.");
        return;
    } else {

        // Hacer la solicitud AJAX para guardar la nuevo proveedor
        $.ajax({
            type: 'POST',
            url: 'ajax/proveedoresajax.php',
            data: {
                proceso: 'modificar',
                codigo: nuevoproveedor.codigo,
                suc: nuevoproveedor.suc,
                zona: nuevoproveedor.zona,
                subzona: nuevoproveedor.subzona,
                nombre: nuevoproveedor.nombre,
                dir: nuevoproveedor.dir,
                tel1: nuevoproveedor.tel1,
                tel2: nuevoproveedor.tel2,
                ciudad: nuevoproveedor.ciudad,
                cupo: nuevoproveedor.cupo,
                legal: nuevoproveedor.legal,
                fecha_ini: nuevoproveedor.fecha_ini,
                fpago: nuevoproveedor.fpago,
                correo: nuevoproveedor.correo,
                caract_dev: nuevoproveedor.caract_dev,
                digito: nuevoproveedor.digito,
                riva: nuevoproveedor.riva,
                rfte: nuevoproveedor.rfte,
                rica: nuevoproveedor.rica,
                estado: nuevoproveedor.estado,
                id: nuevoproveedor.id
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // cerramos el modal
                    $('#editarModal').modal('hide');
                    // limpiamos el formulario
                    $('#fmr_proveedores_editar')[0].reset();
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
        text: '¿Seguro que deseas eliminar la proveedor?',
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
                url: 'ajax/proveedoresajax.php',
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
        confirmButtonproveedor: color
    });
}

function generar() {
    // Abre la URL del archivo PDF en una nueva pestaña
    window.open('pdfs/generar_pdf_proveedores.php', '_blank');

}