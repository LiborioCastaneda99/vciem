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
                            columns: [0, 1, 2, 3, 4]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        className: 'btn btn-falcon-default btn-sm mx-2',
                        text: '<span class="fas fa-file-csv" data-fa-transform="shrink-3"></span> ' +
                            'Exportar a Excel ',
                        titleAttr: 'Csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<span class="fas fa-file-pdf" data-fa-transform="shrink-3"></span> ' +
                            'Exportar a PDF ',
                        className: 'btn btn-falcon-default btn-sm mx-2',
                        titleAttr: 'Csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
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
                    columns: [0, 1, 2, 3, 4]
                }
            }
        ],
        "columnDefs": [{
                // El numero correspode a la ultima columna iniciando en 0
                "targets": [5, 6],
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
            'url': 'ajax/gruposajax.php',
            'data': {
                'proceso': 'get'
            },
            'method': 'POST'
        },
        'columns': [{
                data: 'codigo'
            },
            {
                data: 'clase'
            },
            {
                data: 'nombre'
            },
            {
                data: 'resum'
            },
            {
                data: 'dias'
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

// abrir modal
function abrirModal() {

    $('#fmr_grupos')[0].reset();
    $('#guardarModal').modal('show');

}

// guardar
$(".fmr_grupos").submit(function(event) {
    event.preventDefault();

    codigo = $("#codigo").val()
    clase = $("#lstClaseAgg").val()
    nombre = $("#nombre").val()
    resumen = $("#resumen").val()
    dias = $("#dias").val()

    // Supongamos que este código se ejecuta después de que se ha guardado con éxito un nuevo grupo
    var nuevogrupo = {
        codigo: codigo,
        clase: clase,
        nombre: nombre,
        resumen: resumen,
        dias: dias
    };

    if (codigo == "" || clase == "" || nombre == "" || resumen == "" || dias == "") {
        // alert("Por favor, completa todos los campos.");
        notificacion('Error', 'error', "Por favor, completa todos los campos.");
        return;
    } else {
        // Hacer la solicitud AJAX para guardar el nuevo grupo
        $.ajax({
            type: 'POST',
            url: 'ajax/gruposajax.php',
            data: {
                proceso: 'guardar',
                codigo: nuevogrupo.codigo,
                clase: nuevogrupo.clase,
                nombre: nuevogrupo.nombre,
                resumen: nuevogrupo.resumen,
                dias: nuevogrupo.dias
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // cerramos el modal
                    $('#guardarModal').modal('hide');
                    // limpiamos el formulario
                    $('#fmr_grupos')[0].reset();
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
    var urlprocess = 'ajax/gruposajax.php';
    $.ajax({
        type: 'POST',
        url: urlprocess,
        data: 'id=' + id + '&proceso=get_id',
        dataType: 'json',
        success: function(data) {

            // Asignar un valor al input
            document.getElementById('id').value = data[0].id
            document.getElementById('codigo_mod').value = data[0].codigo
                // document.getElementById('clase_mod').value = data[0].clase
            document.getElementById('nombre_mod').value = data[0].nombre
            document.getElementById('resumen_mod').value = data[0].resum
            document.getElementById('dias_mod').value = data[0].dias
            cargar_clases(data[0].clase, 'lstClaseMod', 'editarModal');

            // Limpiar el cuerpo de la tabla
            $('#editarModal').modal('show'); // abrir

        },
        error: function() {
            // Error en la inserción, muestra mensaje de error con SweetAlert
            notificacion('Error', 'error', response.message);
        }
    });
}

$(".fmr_grupos_editar").submit(function(event) {
    event.preventDefault();

    codigo = $("#codigo_mod").val()
    clase = $("#lstClaseMod").val()
    nombre = $("#nombre_mod").val()
    resumen = $("#resumen_mod").val()
    dias = $("#dias_mod").val()

    // Supongamos que este código se ejecuta después de que se ha guardado con éxito una nuevo grupo
    var nuevogrupo = {
        codigo: codigo,
        clase: clase,
        nombre: nombre,
        resumen: resumen,
        dias: dias,
        id: $("#id").val()
    };

    if (codigo == "" || clase == "" || nombre == "" || resumen == "" || dias == "") {
        // alert("Por favor, completa todos los campos.");
        notificacion('Error', 'error', "Por favor, completa todos los campos.");
        return;
    } else {
        // Hacer la solicitud AJAX para guardar el nuevo grupo
        $.ajax({
            type: 'POST',
            url: 'ajax/gruposajax.php',
            data: {
                proceso: 'modificar',
                codigo: nuevogrupo.codigo,
                clase: nuevogrupo.clase,
                nombre: nuevogrupo.nombre,
                resumen: nuevogrupo.resumen,
                dias: nuevogrupo.dias,
                id: nuevogrupo.id
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // cerramos el modal
                    $('#editarModal').modal('hide');
                    // limpiamos el formulario
                    $('#fmr_grupos_editar')[0].reset();
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
        text: '¿Seguro que deseas eliminar el grupo?',
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
                url: 'ajax/gruposajax.php',
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

function generar() {
    // Abre la URL del archivo PDF en una nueva pestaña
    window.open('pdfs/generar_pdf_grupos.php', '_blank');

}

// Funcion para cargar las listas select con opcion de busqueda
$('#btnBusquedaClaseAgg').click(function() {
    cargar_clases('', 'lstClaseAgg', 'editarModal');
});

// Funcion para cargar las listas select con opcion de busqueda
$('#btnBusquedaClaseMod').click(function() {
    cargar_clases('', 'lstClaseMod', 'editarModal');
});

// funcion para cargar las clases
function cargar_clases(Id, nameSelect, Modal) {
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
                proceso: 'combo_clases',
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
                url: "ajax/gruposajax.php",
                type: "post",
                dataType: 'json',
                delay: 150,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        proceso: "combo_clases",
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

// abrir modal
function abrirModal() {
    $('#fmr_grupos')[0].reset();
    cargar_clases('', 'lstClaseAgg', 'guardarModal')
}