$(document).ready(function() {
    cargar_tabla()
});

// consultar
function cargar_tabla() {
    // Hacer la solicitud AJAX al servidor
    var urlprocess = 'ajax/ciudadesajax.php';
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
                    valueNames: ['codigo', 'nombre', 'resumen'],
                    item: '<tr><td class="codigo"></td><td class="nombre"></td><td class="resumen"></td></tr>'
                };
                var userList = new List('myTable', options);

                // Actualizar la lista después de agregar los datos
                userList.update();

                // Re-inicializar la búsqueda después de la actualización de la lista
                var input = document.querySelector('.search');
                var searchList = new List('myTable', { valueNames: ['codigo', 'nombre', 'resumen'], page: 5 });
                input.addEventListener('input', function() {
                    searchList.search(input.value);
                });
            } else {
                // Mostrar un mensaje indicando que no hay colores disponibles
                $('#myTable tbody').html('<tr><td colspan="5" class="text-center">No hay ciudades disponibles</td></tr>');
            }
        },
        error: function() {
            console.error('Error al cargar los datos.');
        }
    });
}

// guardar
$(".fmr_ciudades").submit(function(event) {
    event.preventDefault();

    // Supongamos que este código se ejecuta después de que se ha guardado con éxito un nuevo color
    var nuevo = {
        codigo: $("#codigo").val(),
        nombre: $("#nombre").val(),
        resumen: $("#resumen").val()
    };

    // Hacer la solicitud AJAX para guardar el nuevo color
    $.ajax({
        type: 'POST',
        url: 'ajax/ciudadesajax.php',
        data: {
            proceso: 'guardar',
            codigo: nuevo.codigo,
            nombre: nuevo.nombre,
            resumen: nuevo.resumen
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // cerramos el modal
                $('#guardarModal').modal('hide');
                // limpiamos el formulario
                $('#fmr_ciudades')[0].reset();
                // mostramos la alerta
                Swal.fire({
                    title: 'Éxito',
                    text: 'La ciudad se ha guardado correctamente',
                    icon: 'success',
                    confirmButtonColor: '#2196f3'
                });

                cargar_tabla();
            } else {
                console.error('Error al guardar la ciudad.');
            }
        },
        error: function() {
            console.error('Error al intentar guardar la ciudad.');
        }
    });

});

// editar
function editar(id) {

    // Hacer la solicitud AJAX al servidor
    var urlprocess = 'ajax/ciudadesajax.php';
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
            document.getElementById('resumen_mod').value = data[0].resum

            // Limpiar el cuerpo de la tabla
            $('#editarModal').modal('show'); // abrir

        },
        error: function() {
            console.error('Error al cargar los datos.');
        }
    });
}

$(".fmr_ciudades_editar").submit(function(event) {
    event.preventDefault();

    // Supongamos que este código se ejecuta después de que se ha guardado con éxito un nuevo color
    var nuevo = {
        codigo: $("#codigo_mod").val(),
        nombre: $("#nombre_mod").val(),
        resumen: $("#resumen_mod").val(),
        id: $("#id").val()
    };

    // Hacer la solicitud AJAX para guardar el nuevo color
    $.ajax({
        type: 'POST',
        url: 'ajax/ciudadesajax.php',
        data: {
            proceso: 'modificar',
            codigo: nuevo.codigo,
            nombre: nuevo.nombre,
            resumen: nuevo.resumen,
            id: nuevo.id
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // cerramos el modal
                $('#editarModal').modal('hide');
                // limpiamos el formulario
                $('#fmr_ciudades_editar')[0].reset();
                // mostramos la alerta
                Swal.fire({
                    title: 'Éxito',
                    text: 'La ciudad se ha modificado correctamente',
                    icon: 'success',
                    confirmButtonColor: '#2196f3'
                });

                cargar_tabla();
            } else {
                console.error('Error al modificar la ciudad.');
            }
        },
        error: function() {
            console.error('Error al intentar modificar la ciudad.');
        }
    });

});

// eliminar
function eliminar(id) {

    // Utiliza SweetAlert para confirmar la eliminación
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Seguro que deseas eliminar la ciudad?',
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
                url: 'ajax/ciudadesajax.php',
                data: {
                    proceso: 'eliminar',
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {

                        Swal.fire({
                            title: 'Éxito',
                            text: 'La ciudad se ha eliminado correctamente',
                            icon: 'success',
                            confirmButtonColor: '#2196f3'
                        });

                        cargar_tabla();
                    } else {
                        console.error('Error al eliminar la ciudad.');
                    }
                },
                error: function() {
                    console.error('Error al intentar eliminar la ciudad.');
                }
            });
        }
    });
}