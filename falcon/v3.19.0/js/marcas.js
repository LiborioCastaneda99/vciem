$(document).ready(function() {
    cargar_tabla()
});

// consultar
function cargar_tabla() {
    // Hacer la solicitud AJAX al servidor
    var urlprocess = 'ajax/marcasajax.php';
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
                        '<td class="nombre">' + item.nombre + '</td>' +
                        '<td class="text-center"><button class="btn btn-outline-primary me-1 mb-1" type="button" onclick=editar(' + item.id + ')>' +
                        '<span class="fas fa-edit me-1" data-fa-transform="shrink-3"></span></button></td>' +
                        '<td class="text-center"><button class="btn btn-outline-primary me-1 mb-1" type="button" onclick=eliminar(' + item.id + ')>' +
                        '<span class="fas fa-trash ms-1" data-fa-transform="shrink-3"></span></button></td>' +
                        '</tr>'
                    );
                });

                // Inicializar List.js después de agregar datos
                var options = {
                    valueNames: ['codigo', 'nombre'],
                    item: '<tr><td class="codigo"></td><td class="nombre"></td></tr>'
                };
                var userList = new List('myTable', options);

                // Actualizar la lista después de agregar los datos
                userList.update();

                // Re-inicializar la búsqueda después de la actualización de la lista
                var input = document.querySelector('.search');
                var searchList = new List('myTable', { valueNames: ['codigo', 'nombre'], page: 5 });
                input.addEventListener('input', function() {
                    searchList.search(input.value);
                });
            } else {
                // Mostrar un mensaje indicando que no hay marcas disponibles
                $('#myTable tbody').html('<tr><td colspan="4" class="text-center">No hay marcas disponibles</td></tr>');
            }
        },
        error: function() {
            console.error('Error al cargar los datos.');
        }
    });
}

// guardar
$(".fmr_marcas").submit(function(event) {
    event.preventDefault();

    // Supongamos que este código se ejecuta después de que se ha guardado con éxito un nuevo color
    var nuevoColor = {
        codigo: $("#codigo").val(),
        nombre: $("#nombre").val()
    };

    // Hacer la solicitud AJAX para guardar el nuevo color
    $.ajax({
        type: 'POST',
        url: 'ajax/marcasajax.php',
        data: {
            proceso: 'guardar',
            codigo: nuevoColor.codigo,
            nombre: nuevoColor.nombre
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // cerramos el modal
                $('#guardarModal').modal('hide');
                // limpiamos el formulario
                $('#fmr_marcas')[0].reset();
                // mostramos la alerta
                Swal.fire({
                    title: 'Éxito',
                    text: response.message,
                    icon: 'success',
                    confirmButtonColor: '#2196f3'
                });

                cargar_tabla();
            } else {
                // Error en la inserción, muestra mensaje de error con SweetAlert
                Swal.fire({
                    title: 'Error',
                    text: response.message,
                    icon: 'error',
                    confirmButtonColor: "#EF5350"
                });
            }
        },
        error: function() {
            // Error en la inserción, muestra mensaje de error con SweetAlert
            Swal.fire({
                title: 'Error',
                text: response.message,
                icon: 'error',
                confirmButtonColor: "#EF5350"
            });
        }
    });

});

// editar
function editar(id) {

    // Hacer la solicitud AJAX al servidor
    var urlprocess = 'ajax/marcasajax.php';
    $.ajax({
        type: 'POST',
        url: urlprocess,
        data: 'id=' + id + '&proceso=get_id',
        dataType: 'json',
        success: function(data) {

            // Asignar un valor al input
            document.getElementById('id').value = data[0].id
            document.getElementById('codigo_mod').value = data[0].codigo
            document.getElementById('nombre_mod').value = data[0].nombre

            // Limpiar el cuerpo de la tabla
            $('#editarModal').modal('show'); // abrir

        },
        error: function() {
            console.error('Error al cargar los datos.');
        }
    });
}

$(".fmr_marcas_editar").submit(function(event) {
    event.preventDefault();

    // Supongamos que este código se ejecuta después de que se ha guardado con éxito un nuevo color
    var nuevoColor = {
        codigo: $("#codigo_mod").val(),
        nombre: $("#nombre_mod").val(),
        id: $("#id").val()
    };

    // Hacer la solicitud AJAX para guardar el nuevo color
    $.ajax({
        type: 'POST',
        url: 'ajax/marcasajax.php',
        data: {
            proceso: 'modificar',
            codigo: nuevoColor.codigo,
            nombre: nuevoColor.nombre,
            id: nuevoColor.id
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // cerramos el modal
                $('#editarModal').modal('hide');
                // limpiamos el formulario
                $('#fmr_marcas_editar')[0].reset();
                // mostramos la alerta
                Swal.fire({
                    title: 'Éxito',
                    text: response.message,
                    icon: 'success',
                    confirmButtonColor: '#2196f3'
                });

                cargar_tabla();
            } else {
                // Error en la inserción, muestra mensaje de error con SweetAlert
                Swal.fire({
                    title: 'Error',
                    text: response.message,
                    icon: 'error',
                    confirmButtonColor: "#EF5350"
                });
            }
        },
        error: function() {
            // Error en la inserción, muestra mensaje de error con SweetAlert
            Swal.fire({
                title: 'Error',
                text: response.message,
                icon: 'error',
                confirmButtonColor: "#EF5350"
            });
        }
    });

});

// eliminar
function eliminar(id) {

    // Utiliza SweetAlert para confirmar la eliminación
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Seguro que deseas eliminar el color?',
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
                url: 'ajax/marcasajax.php',
                data: {
                    proceso: 'eliminar',
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {

                        Swal.fire({
                            title: 'Éxito',
                            text: response.message,
                            icon: 'success',
                            confirmButtonColor: '#2196f3'
                        });

                        cargar_tabla();
                    } else {
                        // Error en la inserción, muestra mensaje de error con SweetAlert
                        Swal.fire({
                            title: 'Error',
                            text: response.message,
                            icon: 'error',
                            confirmButtonColor: "#EF5350"
                        });
                    }
                },
                error: function() {
                    // Error en la inserción, muestra mensaje de error con SweetAlert
                    Swal.fire({
                        title: 'Error',
                        text: response.message,
                        icon: 'error',
                        confirmButtonColor: "#EF5350"
                    });
                }
            });
        }
    });
}