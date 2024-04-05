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
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        className: 'btn btn-falcon-default btn-sm mx-2',
                        text: '<span class="fas fa-file-csv" data-fa-transform="shrink-3"></span> ' +
                            'Exportar a Excel ',
                        titleAttr: 'Csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<span class="fas fa-file-pdf" data-fa-transform="shrink-3"></span> ' +
                            'Exportar a PDF ',
                        className: 'btn btn-falcon-default btn-sm mx-2',
                        titleAttr: 'Csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27]
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
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27]
                }
            }
        ],
        "columnDefs": [{
                // El numero correspode a la ultima columna iniciando en 0
                "targets": [28, 29],
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
            'url': 'ajax/articulosajax.php',
            'data': {
                'proceso': 'get'
            },
            'method': 'POST'
        },
        'columns': [{
                data: 'codigo'
            },
            {
                data: 'homol'
            },
            {
                data: 'nombre'
            },
            {
                data: 'clase'
            },
            {
                data: 'grupo'
            },
            {
                data: 'referencia'
            },
            {
                data: 'umedida'
            },
            {
                data: 'stmin'
            },
            {
                data: 'stmax'
            },
            {
                data: 'ctostan'
            },
            {
                data: 'ctoult'
            },
            {
                data: 'fecult'
            },
            {
                data: 'nal'
            },
            {
                data: 'pv1'
            },
            {
                data: 'pv2'
            },
            {
                data: 'pv3'
            },
            {
                data: 'ubicacion'
            },
            {
                data: 'uxemp'
            },
            {
                data: 'peso'
            },
            {
                data: 'iva'
            },
            {
                data: 'impo'
            },
            {
                data: 'flete'
            },
            {
                data: 'estado'
            },
            {
                data: 'canen'
            },
            {
                data: 'valen'
            },
            {
                data: 'pdes'
            },
            {
                data: 'ultpro'
            },
            {
                data: 'docpro'
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

function abrirModal() {

    // Cerrar el modal si está abierto
    $('#guardarModal').modal('hide');

    $('#guardarModal').modal('show');
    cargar_clase('', 'clase', 'guardarModal');
    cargar_grupo('', 'grupo', 'guardarModal', 0)
    cargar_umedida('', 'umedida', 'guardarModal');
}

// Funcion para cargar las listas select con opcion de busqueda de Clase
$('#btnBusquedaClaseAgg').click(function() {
    cargar_clase('', 'clase', 'guardarModal');
});

// Funcion para cargar las listas select con opcion de busqueda de Clase
$('#btnBusquedaClaseMod').click(function() {
    cargar_clase('', 'clase_mod', 'editarModal');
});

function cargar_clase(Id, nameSelect, Modal) {
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
            url: 'ajax/clasesajax.php',
            data: {
                searchTerm: searchTerm,
                proceso: 'combo_clase',
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
            placeholder: "Seleccione una clase",
            dropdownParent: $('#' + Modal),
            ajax: {
                url: "ajax/clasesajax.php",
                type: "post",
                dataType: 'json',
                delay: 150,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        proceso: "combo_clase",
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

// Funcion para cargar las listas select con opcion de busqueda de umedida
$('#btnBusquedaUmedidaAgg').click(function() {
    cargar_umedida('', 'umedida', 'guardarModal');
});

// Funcion para cargar las listas select con opcion de busqueda de umedida
$('#btnBusquedaUmedidaMod').click(function() {
    cargar_umedida('', 'umedida_mod', 'editarModal');
});

function cargar_umedida(Id, nameSelect, Modal) {
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
            url: 'ajax/umedidasajax.php',
            data: {
                searchTerm: searchTerm,
                proceso: 'combo_umedida',
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
            placeholder: "Seleccione una umedida",
            dropdownParent: $('#' + Modal),
            ajax: {
                url: "ajax/umedidasajax.php",
                type: "post",
                dataType: 'json',
                delay: 150,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        proceso: "combo_umedida",
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

function cargar_select(id) {
    cargar_grupo(id, 'grupo', 'guardarModal', 0)
}

function cargar_select_mod(id) {
    cargar_grupo(id, 'grupo_mod', 'editarModal', 0)
}


function cargar_grupo(Id, nameSelect, Modal, Otro) {
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
            url: 'ajax/gruposajax.php',
            data: {
                searchTerm: searchTerm,
                proceso: 'combo_grupos',
                id: Id,
                otro: Otro
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
            placeholder: "Seleccione un grupo",
            dropdownParent: $('#' + Modal),
            ajax: {
                url: "ajax/gruposajax.php",
                type: "post",
                dataType: 'json',
                delay: 150,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        proceso: "combo_grupos",
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
$(".fmr_articulos").submit(function(event) {
    event.preventDefault();

    // Supongamos que este código se ejecuta después de que se ha guardado con éxito un nuevo articulo
    var nuevoarticulo = {
        codigo: $("#codigo").val(),
        homol: $("#homol").val(),
        nombre: $("#nombre").val(),
        clase: $("#clase").val(),
        grupo: $("#grupo").val(),
        referencia: $("#referencia").val(),
        umedida: $("#umedida").val(),
        stmin: $("#stmin").val(),
        stmax: $("#stmax").val(),
        ctostan: $("#ctostan").val(),
        ctoult: $("#ctoult").val(),
        fecult: $("#fecult").val(),
        nal: $("#nal").val(),
        pv1: $("#pv1").val(),
        pv2: $("#pv2").val(),
        pv3: $("#pv3").val(),
        ubicacion: $("#ubicacion").val(),
        uxemp: $("#uxemp").val(),
        peso: $("#peso").val(),
        iva: $("#iva").val(),
        impo: $("#impo").val(),
        flete: $("#flete").val(),
        estado: $("#estado").val(),
        canen: $("#canen").val(),
        valen: $("#valen").val(),
        pdes: $("#pdes").val(),
        ultpro: $("#ultpro").val(),
        docpro: $("#docpro").val()
    };

    // Hacer la solicitud AJAX para guardar la nuevo articulo
    $.ajax({
        type: 'POST',
        url: 'ajax/articulosajax.php',
        data: {
            proceso: 'guardar',
            codigo: nuevoarticulo.codigo,
            homol: nuevoarticulo.homol,
            nombre: nuevoarticulo.nombre,
            clase: nuevoarticulo.clase,
            grupo: nuevoarticulo.grupo,
            referencia: nuevoarticulo.referencia,
            umedida: nuevoarticulo.umedida,
            stmin: nuevoarticulo.stmin,
            stmax: nuevoarticulo.stmax,
            ctostan: nuevoarticulo.ctostan,
            ctoult: nuevoarticulo.ctoult,
            fecult: nuevoarticulo.fecult,
            nal: nuevoarticulo.nal,
            pv1: nuevoarticulo.pv1,
            pv2: nuevoarticulo.pv2,
            pv3: nuevoarticulo.pv3,
            ubicacion: nuevoarticulo.ubicacion,
            uxemp: nuevoarticulo.uxemp,
            peso: nuevoarticulo.peso,
            iva: nuevoarticulo.iva,
            impo: nuevoarticulo.impo,
            flete: nuevoarticulo.flete,
            estado: nuevoarticulo.estado,
            canen: nuevoarticulo.canen,
            valen: nuevoarticulo.valen,
            pdes: nuevoarticulo.pdes,
            ultpro: nuevoarticulo.ultpro,
            docpro: nuevoarticulo.docpro
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // cerramos el modal
                $('#guardarModal').modal('hide');
                // limpiamos el formulario
                $('#fmr_articulos')[0].reset();
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

});

// editar
function editar(id) {

    // Hacer la solicitud AJAX al servidor
    var urlprocess = 'ajax/articulosajax.php';
    $.ajax({
        type: 'POST',
        url: urlprocess,
        data: 'id=' + id + '&proceso=get_id',
        dataType: 'json',
        success: function(data) {

            // Asignar un valor al input
            document.getElementById('id').value = data[0].id
            document.getElementById('codigo_mod').value = data[0].codigo
            document.getElementById('homol_mod').value = data[0].homol
            document.getElementById('nombre_mod').value = data[0].nombre
            document.getElementById('clase_mod').value = data[0].clase
            cargar_clase(data[0].clase, 'clase_mod', 'editarModal');
            cargar_grupo(data[0].grupo, 'grupo_mod', 'editarModal', 1);

            document.getElementById('referencia_mod').value = data[0].referencia
            document.getElementById('umedida_mod').value = data[0].umedida
            cargar_umedida(data[0].umedida, 'umedida_mod', 'editarModal');

            document.getElementById('stmin_mod').value = data[0].stmin
            document.getElementById('stmax_mod').value = data[0].stmax
            document.getElementById('ctostan_mod').value = data[0].ctostan
            document.getElementById('ctoult_mod').value = data[0].ctoult
            document.getElementById('fecult_mod').value = data[0].fecult
            document.getElementById('nal_mod').value = data[0].nal
            document.getElementById('pv1_mod').value = data[0].pv1
            document.getElementById('pv2_mod').value = data[0].pv2
            document.getElementById('pv3_mod').value = data[0].pv3
            document.getElementById('ubicacion_mod').value = data[0].ubicacion
            document.getElementById('uxemp_mod').value = data[0].uxemp
            document.getElementById('peso_mod').value = data[0].peso
            document.getElementById('iva_mod').value = data[0].iva
            document.getElementById('impo_mod').value = data[0].impo
            document.getElementById('flete_mod').value = data[0].flete
            document.getElementById('estado_mod').value = data[0].estado
            document.getElementById('canen_mod').value = data[0].canen
            document.getElementById('valen_mod').value = data[0].valen
            document.getElementById('pdes_mod').value = data[0].pdes
            document.getElementById('ultpro_mod').value = data[0].ultpro
            document.getElementById('docpro_mod').value = data[0].docpro

            // Limpiar el cuerpo de la tabla
            $('#editarModal').modal('show'); // abrir

        },
        error: function() {
            // Error en la inserción, muestra mensaje de error con SweetAlert
            notificacion('Error', 'error', response.message);
        }
    });
}

$(".fmr_articulos_editar").submit(function(event) {
    event.preventDefault();

    // Supongamos que este código se ejecuta después de que se ha guardado con éxito una nuevo articulo
    var nuevoarticulo = {
        codigo: $("#codigo_mod").val(),
        homol: $("#homol_mod").val(),
        nombre: $("#nombre_mod").val(),
        clase: $("#clase_mod").val(),
        grupo: $("#grupo_mod").val(),
        referencia: $("#referencia_mod").val(),
        umedida: $("#umedida_mod").val(),
        stmin: $("#stmin_mod").val(),
        stmax: $("#stmax_mod").val(),
        ctostan: $("#ctostan_mod").val(),
        ctoult: $("#ctoult_mod").val(),
        fecult: $("#fecult_mod").val(),
        nal: $("#nal_mod").val(),
        pv1: $("#pv1_mod").val(),
        pv2: $("#pv2_mod").val(),
        pv3: $("#pv3_mod").val(),
        ubicacion: $("#ubicacion_mod").val(),
        uxemp: $("#uxemp_mod").val(),
        peso: $("#peso_mod").val(),
        iva: $("#iva_mod").val(),
        impo: $("#impo_mod").val(),
        flete: $("#flete_mod").val(),
        estado: $("#estado_mod").val(),
        canen: $("#canen_mod").val(),
        valen: $("#valen_mod").val(),
        pdes: $("#pdes_mod").val(),
        ultpro: $("#ultpro_mod").val(),
        docpro: $("#docpro_mod").val(),
        id: $("#id").val()
    };

    // Hacer la solicitud AJAX para guardar la nuevo articulo
    $.ajax({
        type: 'POST',
        url: 'ajax/articulosajax.php',
        data: {
            proceso: 'modificar',
            codigo: nuevoarticulo.codigo,
            homol: nuevoarticulo.homol,
            clase: nuevoarticulo.clase,
            grupo: nuevoarticulo.grupo,
            nombre: nuevoarticulo.nombre,
            referencia: nuevoarticulo.referencia,
            umedida: nuevoarticulo.umedida,
            stmin: nuevoarticulo.stmin,
            stmax: nuevoarticulo.stmax,
            ctostan: nuevoarticulo.ctostan,
            ctoult: nuevoarticulo.ctoult,
            fecult: nuevoarticulo.fecult,
            nal: nuevoarticulo.nal,
            pv1: nuevoarticulo.pv1,
            pv2: nuevoarticulo.pv2,
            pv3: nuevoarticulo.pv3,
            ubicacion: nuevoarticulo.ubicacion,
            uxemp: nuevoarticulo.uxemp,
            peso: nuevoarticulo.peso,
            iva: nuevoarticulo.iva,
            impo: nuevoarticulo.impo,
            flete: nuevoarticulo.flete,
            estado: nuevoarticulo.estado,
            canen: nuevoarticulo.canen,
            valen: nuevoarticulo.valen,
            pdes: nuevoarticulo.pdes,
            ultpro: nuevoarticulo.ultpro,
            docpro: nuevoarticulo.docpro,
            id: nuevoarticulo.id
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // cerramos el modal
                $('#editarModal').modal('hide');
                // limpiamos el formulario
                $('#fmr_articulos_editar')[0].reset();
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

});

// eliminar
function eliminar(id) {

    // Utiliza SweetAlert para confirmar la eliminación
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Seguro que deseas eliminar la articulo?',
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
                url: 'ajax/articulosajax.php',
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
        confirmButtonarticulo: color
    });
}

function generar() {
    // Abre la URL del archivo PDF en una nueva pestaña
    window.open('pdfs/generar_pdf_articulos.php', '_blank');

}