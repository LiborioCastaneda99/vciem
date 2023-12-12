$(document).ready(function() {
    cargar_tabla()
});

// consultar
function cargar_tabla() {
    // Hacer la solicitud AJAX al servidor
    var urlprocess = 'ajax/colorajax.php';
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
                        '<td class="descripcion">' + item.descripcion + '</td>' +
                        '<td class="text-center"><button class="btn btn-outline-primary me-1 mb-1" type="button" onclick=editar(' + item.id + ')>' +
                        '<span class="fas fa-edit me-1" data-fa-transform="shrink-3"></span></button></td>' +
                        '<td class="text-center"><button class="btn btn-outline-primary me-1 mb-1" type="button" onclick=eliminar(' + item.id + ')>' +
                        '<span class="fas fa-trash ms-1" data-fa-transform="shrink-3"></span></button></td>' +
                        '</tr>'
                    );
                });

                // Inicializar List.js después de agregar datos
                var options = {
                    valueNames: ['codigo', 'descripcion'],
                    item: '<tr><td class="codigo"></td><td class="descripcion"></td></tr>'
                };
                var userList = new List('myTable', options);

                // Actualizar la lista después de agregar los datos
                userList.update();

                // Re-inicializar la búsqueda después de la actualización de la lista
                var input = document.querySelector('.search');
                var searchList = new List('myTable', { valueNames: ['codigo', 'descripcion'], page: 5 });
                input.addEventListener('input', function() {
                    searchList.search(input.value);
                });
            } else {
                // Mostrar un mensaje indicando que no hay colores disponibles
                $('#myTable tbody').html('<tr><td colspan="4" class="text-center">No hay colores disponibles</td></tr>');
            }
        },
        error: function() {
            console.error('Error al cargar los datos.');
        }
    });
}

// guardar
$(".fmr_colores").submit(function(event) {
    event.preventDefault();

    // Supongamos que este código se ejecuta después de que se ha guardado con éxito un nuevo color
    var nuevoColor = {
        codigo: $("#codigo").val(),
        descripcion: $("#descripcion").val()
    };

    // Hacer la solicitud AJAX para guardar el nuevo color
    $.ajax({
        type: 'POST',
        url: 'ajax/colorajax.php',
        data: {
            proceso: 'guardar',
            codigo: nuevoColor.codigo,
            descripcion: nuevoColor.descripcion
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // cerramos el modal
                $('#guardarModal').modal('hide');
                // limpiamos el formulario
                $('#fmr_colores')[0].reset();
                // mostramos la alerta
                Swal.fire({
                    title: 'Éxito',
                    text: 'El color se ha guardado correctamente',
                    icon: 'success',
                    confirmButtonColor: '#2196f3'
                });

                cargar_tabla();
            } else {
                console.error('Error al guardar el color.');
            }
        },
        error: function() {
            console.error('Error al intentar guardar el color.');
        }
    });

});

// editar
function editar(id) {

    // Hacer la solicitud AJAX al servidor
    var urlprocess = 'ajax/colorajax.php';
    $.ajax({
        type: 'POST',
        url: urlprocess,
        data: 'id=' + id + '&proceso=get_id',
        dataType: 'json',
        success: function(data) {

            // Asignar un valor al input
            document.getElementById('id').value = data[0].id
            document.getElementById('codigo_mod').value = data[0].codigo
            document.getElementById('descripcion_mod').value = data[0].descripcion

            // Limpiar el cuerpo de la tabla
            $('#editarModal').modal('show'); // abrir

        },
        error: function() {
            console.error('Error al cargar los datos.');
        }
    });
}

$(".fmr_colores_editar").submit(function(event) {
    event.preventDefault();

    // Supongamos que este código se ejecuta después de que se ha guardado con éxito un nuevo color
    var nuevoColor = {
        codigo: $("#codigo_mod").val(),
        descripcion: $("#descripcion_mod").val(),
        id: $("#id").val()
    };

    // Hacer la solicitud AJAX para guardar el nuevo color
    $.ajax({
        type: 'POST',
        url: 'ajax/colorajax.php',
        data: {
            proceso: 'modificar',
            codigo: nuevoColor.codigo,
            descripcion: nuevoColor.descripcion,
            id: nuevoColor.id
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // cerramos el modal
                $('#editarModal').modal('hide');
                // limpiamos el formulario
                $('#fmr_colores_editar')[0].reset();
                // mostramos la alerta
                Swal.fire({
                    title: 'Éxito',
                    text: 'El color se ha modificado correctamente',
                    icon: 'success',
                    confirmButtonColor: '#2196f3'
                });

                cargar_tabla();
            } else {
                console.error('Error al modificar el color.');
            }
        },
        error: function() {
            console.error('Error al intentar modificar el color.');
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
                url: 'ajax/colorajax.php',
                data: {
                    proceso: 'eliminar',
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {

                        Swal.fire({
                            title: 'Éxito',
                            text: 'El color se ha eliminado correctamente',
                            icon: 'success',
                            confirmButtonColor: '#2196f3'
                        });

                        cargar_tabla();
                    } else {
                        console.error('Error al eliminar el color.');
                    }
                },
                error: function() {
                    console.error('Error al intentar eliminar el color.');
                }
            });
        }
    });
}