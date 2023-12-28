$(document).ready(function() {
    cargar_tabla()
});

// consultar
function cargar_tabla() {
    // Hacer la solicitud AJAX al servidor
    var urlprocess = 'ajax/subzonasajax.php';
    $.ajax({
        type: 'POST',
        url: urlprocess,
        data: 'proceso=get',
        dataType: 'json',
        success: function(data) {
            // Limpiar el cuerpo de la tabla
            $('#myTable tbody').empty();

            if (data.length > 0) {

                // Agregar filas con los datos obtenidos
                $.each(data, function(index, item) {
                    $('#myTable tbody').append(
                        '<tr>' +
                        '<td class="codigo">' + item.codigo + '</td>' +
                        '<td class="subzona">' + item.zona + '</td>' +
                        '<td class="nombre">' + item.nombre + '</td>' +
                        '<td class="resumen">' + item.resum + '</td>' +
                        '<td class="text-center"><button class="btn btn-outline-primary me-1 mb-1" type="button" onclick=editar(' + item.id + ')>' +
                        '<span class="fas fa-edit me-1" data-fa-transform="shrink-3"></span></button></td>' +
                        '<td class="text-center"><button class="btn btn-outline-primary me-1 mb-1" type="button" onclick=eliminar(' + item.id + ')>' +
                        '<span class="fas fa-trash ms-1" data-fa-transform="shrink-3"></span></button></td>' +
                        '</tr>'
                    );
                });

                // Inicializar List.js después de agregar datos
                var options = {
                    valueNames: ['codigo', 'zona', 'nombre', 'resum'],
                    item: '<tr><td class="codigo"></td><td class="subzona"></td><td class="nombre"></td><td class="resumen"></td></tr>'
                };
                var userList = new List('myTable', options);

                // Actualizar la lista después de agregar los datos
                userList.update();

                // Re-inicializar la búsqueda después de la actualización de la lista
                var input = document.querySelector('.search');
                var searchList = new List('myTable', { valueNames: ['codigo', 'zona', 'nombre', 'resum'], page: 5 });
                input.addEventListener('input', function() {
                    searchList.search(input.value);
                });
            } else {
                // Mostrar un mensaje indicando que no hay subzonas disponibles
                $('#myTable tbody').html('<tr><td colspan="4" class="text-center">No hay subzonas disponibles</td></tr>');
            }
        },
        error: function() {
            // Error en la inserción, muestra mensaje de error con SweetAlert
            notificacion('Error', 'error', response.message);
        }
    });
}

// guardar
$(".fmr_subzonas").submit(function(event) {
    event.preventDefault();

    codigo = $("#codigo").val()
    subzona = $("#lstSubzonaAgregar").val()
    nombre = $("#nombre").val()
    resumen = $("#resumen").val()

    // Supongamos que este código se ejecuta después de que se ha guardado con éxito un nueva subzona
    var nuevaSubzona = {
        codigo: $("#codigo").val(),
        subzona: $("#lstSubzonaAgregar").val(),
        nombre: $("#nombre").val(),
        resumen: $("#resumen").val()
    };

    if (codigo == "" || subzona == "" || nombre == "" || resumen == "") {
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
                codigo: nuevaSubzona.codigo,
                subzona: nuevaSubzona.subzona,
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
                // document.getElementById('subzona_mod').value = data[0].zona
            document.getElementById('nombre_mod').value = data[0].nombre
            document.getElementById('resumen_mod').value = data[0].resum
            cargar_zona(data[0].zona, 'lstSubzonaMod');

            // Limpiar el cuerpo de la tabla
            $('#editarModal').modal('show'); // abrir

        },
        error: function() {
            // Error en la inserción, muestra mensaje de error con SweetAlert
            notificacion('Error', 'error', response.message);
        }
    });
}

$(".fmr_subzonas_editar").submit(function(event) {
    event.preventDefault();

    codigo = $("#codigo_mod").val()
    subzona = $("#lstSubzonaMod").val()
    nombre = $("#nombre_mod").val()
    resumen = $("#resumen_mod").val()

    // Supongamos que este código se ejecuta después de que se ha guardado con éxito una nueva subzona
    var nuevaSubzona = {
        codigo: $("#codigo_mod").val(),
        subzona: $("#lstSubzonaMod").val(),
        nombre: $("#nombre_mod").val(),
        resumen: $("#resumen_mod").val(),
        id: $("#id").val()
    };

    if (codigo == "" || subzona == "" || nombre == "" || resumen == "") {
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
                subzona: nuevaSubzona.subzona,
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

// // cuadramos lo que queremos imprimir
document.getElementById('btnAgregar').addEventListener('click', function() {
    cargar_zona('', 'lstSubzonaAgregar');
});

// Funcion para cargar las listas select con opcion de busqueda
$('#btnBusquedaAgregar').click(function() {
    cargar_zona('', 'lstSubzonaAgregar');
});

// Funcion para cargar las listas select con opcion de busqueda
$('#btnBusquedaMod').click(function() {
    cargar_zona('', 'lstSubzonaMod');
});

function cargar_zona(Id, nameSelect) {
    var lstSubzona = $('#' + nameSelect);

    // Limpiar el contenido actual del select

    select = nameSelect

    lstSubzona.empty();

    if (Id !== "") {
        var searchTerm = '';

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'ajax/zonasajax.php',
            data: {
                searchTerm: searchTerm,
                proceso: "combo_zonas",
                id: Id
            },
        }).then(function(registros) {
            // Agregar nuevas opciones al select
            console.table(registros)
            $(registros).each(function(i, v) {
                lstSubzona.append('<option value="' + v.id + '">' + v.text + '</option>');
            });
        });
    } else {
        // Agregar una opción por defecto al select
        lstSubzona.append('<option value="" selected>Seleccione una zona</option>');
        var searchTerm = '';

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'ajax/zonasajax.php',
            data: {
                searchTerm: searchTerm,
                proceso: "combo_zonas",
                id: Id
            },
        }).then(function(registros) {
            // Agregar nuevas opciones al select
            console.table(registros)
            $(registros).each(function(i, v) {
                lstSubzona.append('<option value="' + v.id + '">' + v.text + '</option>');
            });
        });

    }
}

function generar() {
    // Abre la URL del archivo PDF en una nueva pestaña
    window.open('pdfs/generar_pdf_subzonas.php', '_blank');

}