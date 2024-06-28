$(document).ready(function() {
    cargar_tabla()
});

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
                            columns: [0, 1, 2, 3]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        className: 'btn btn-falcon-default btn-sm mx-2',
                        text: '<span class="fas fa-file-csv" data-fa-transform="shrink-3"></span> ' +
                            'Exportar a Excel ',
                        titleAttr: 'Csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<span class="fas fa-file-pdf" data-fa-transform="shrink-3"></span> ' +
                            'Exportar a PDF ',
                        className: 'btn btn-falcon-default btn-sm mx-2',
                        titleAttr: 'Csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
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
                    columns: [0, 1, 2, 3]
                }
            }
        ],
        "columnDefs": [{
                // El numero correspode a la ultima columna iniciando en 0
                "targets": [4, 5],
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
            'url': 'ajax/subzonasajax.php',
            'data': {
                'proceso': 'get'
            },
            'method': 'POST'
        },
        'columns': [{
                data: 'zona'
            },
            {
                data: 'codigo'
            },
            {
                data: 'nombre'
            },
            {
                data: 'resum'
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

// guardar
$(".fmr_subzonas").submit(function(event) {
    event.preventDefault();

    zona = $("#lstZonaAgregar").val()
    codigo = $("#codigo").val()
    nombre = $("#nombre").val()
    resumen = $("#resumen").val()

    // Supongamos que este código se ejecuta después de que se ha guardado con éxito un nueva subzona
    var nuevaSubzona = {
        zona: zona,
        codigo: codigo,
        nombre: nombre,
        resumen: resumen
    };

    if (codigo == "" || zona == "" || nombre == "" || resumen == "") {
        // alert("Por favor, completa todos los campos.");
        notificacion('Error', 'error', "Por favor, completa todos los campos.");
        return;
    } else {
        // Hacer la solicitud AJAX para guardar la nueva subzona
        $.ajax({
            type: 'POST',
            url: 'ajax/subzonasajax.php',
            data: {
                proceso: 'guardar',
                zona: nuevaSubzona.zona,
                codigo: nuevaSubzona.codigo,
                nombre: nuevaSubzona.nombre,
                resumen: nuevaSubzona.resumen

            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // cerramos el modal
                    $('#guardarModal').modal('hide');
                    // limpiamos el formulario
                    $('#fmr_subzonas')[0].reset();
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
    var urlprocess = 'ajax/subzonasajax.php';
    $.ajax({
        type: 'POST',
        url: urlprocess,
        data: 'id=' + id + '&proceso=get_id',
        dataType: 'json',
        success: function(data) {

            // Asignar un valor al input
            document.getElementById('id').value = data[0].id
            document.getElementById('codigo_mod').value = data[0].codigo
            document.getElementById('resumen_mod').value = data[0].resum
            cargar_departamentos(data[0].codigo_zona, 'lstZonaMod', 'editarModal')
            cargar_ciudades(data[0].id, 'lstSubzonaMod', 'editarModal', 'combo_ciudades')
            $('#editarModal').modal('show'); // abrir
        },
        error: function() {
            // Error en la inserción, muestra mensaje de error con SweetAlert
            notificacion('Error', 'error', response.message);
        }
    });
}


// abrir modal
function abrirModal() {

    $('#fmr_subzonas')[0].reset();
    cargar_departamentos('', 'lstZonaAgregar', 'guardarModal')
    $('#guardarModal').modal('show');

}

$(".fmr_subzonas_editar").submit(function(event) {
    event.preventDefault();

    codigo = $("#codigo_mod").val()
    zona = $("#lstZonaMod").val()
    subzona = $("#lstSubzonaMod").val()
    nombre = $("#nombre_mod").val()
    resumen = $("#resumen_mod").val()

    // Obtener el elemento select
    var miSelect = document.getElementById("lstSubzonaMod");
    // Obtener el índice de la opción seleccionada
    var indiceSeleccionado = miSelect.selectedIndex;
    // Obtener el texto de la opción seleccionada
    var textoSeleccionado = miSelect.options[indiceSeleccionado].text;
    // Mostrar el texto en la consola (puedes hacer lo que quieras con el texto)
    console.log("Texto seleccionado: " + textoSeleccionado);

    // Supongamos que este código se ejecuta después de que se ha guardado con éxito una nueva subzona
    var nuevaSubzona = {
        codigo: codigo,
        zona: zona,
        subzona: subzona,
        subzonaName: textoSeleccionado,
        nombre: nombre,
        resumen: resumen,
        id: $("#id").val()
    };

    if (codigo == "" || zona == "" || subzona == "" || nombre == "" || resumen == "") {
        // alert("Por favor, completa todos los campos.");
        notificacion('Error', 'error', "Por favor, completa todos los campos.");
        return;
    } else {
        // Hacer la solicitud AJAX para guardar la nueva subzona
        $.ajax({
            type: 'POST',
            url: 'ajax/subzonasajax.php',
            data: {
                proceso: 'modificar',
                codigo: nuevaSubzona.codigo,
                zona: nuevaSubzona.zona,
                subzona: nuevaSubzona.subzona,
                subzonaName: nuevaSubzona.subzonaName,
                nombre: nuevaSubzona.nombre,
                resumen: nuevaSubzona.resumen,
                id: nuevaSubzona.id
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // cerramos el modal
                    $('#editarModal').modal('hide');
                    // limpiamos el formulario
                    $('#fmr_subzonas_editar')[0].reset();
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
        text: '¿Seguro que deseas eliminar el subzona?',
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
                url: 'ajax/subzonasajax.php',
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
        confirmButtonColor: color
    });
}

// Funcion para cargar las listas select con opcion de busqueda
$('#btnBusquedaZonaAgregar').click(function() {
    cargar_departamentos('', 'lstZonaAgregar', 'guardarModal');
});

// Funcion para cargar las listas select con opcion de busqueda
$('#btnBusquedaZonaMod').click(function() {
    cargar_departamentos('', 'lstZonaMod', 'editarModal');
});

// Funcion para cargar las listas select con opcion de busqueda
$('#btnBusquedaSubzonaMod').click(function() {
    cargar_ciudades('', 'lstSubzonaMod', 'editarModal', 'combo_ciudades');
});

function cargar_select(id) {
    cargar_ciudades(id, 'lstSubzonaMod', 'editarModal', 'combo_ciudades_all')
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