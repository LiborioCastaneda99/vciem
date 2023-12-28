$(document).ready(function() {
    cargar_tabla()
});

// consultar
function cargar_tabla() {
    // Hacer la solicitud AJAX al servidor
    var urlprocess = 'ajax/presentacionesajax.php';
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
                // Mostrar un mensaje indicando que no hay presentaciones disponibles
                $('#myTable tbody').html('<tr><td colspan="4" class="text-center">No hay presentaciones disponibles</td></tr>');
            }
        },
        error: function() {
            notificacion('Error', 'error', response.message);
        }
    });
}

// guardar
$(".fmr_presentaciones").submit(function(event) {
    event.preventDefault();

    codigo = $("#codigo").val()
    nombre = $("#nombre").val()

    // Supongamos que este código se ejecuta después de que se ha guardado con éxito un nueva presentacion
    var nuevaPresentacion = {
        codigo: $("#codigo").val(),
        nombre: $("#nombre").val()
    };

    if (codigo == "" || nombre == "") {
        // alert("Por favor, completa todos los campos.");
        notificacion('Error', 'error', "Por favor, completa todos los campos.");
        return;
    } else {
        // Hacer la solicitud AJAX para guardar el nueva presentacion
        $.ajax({
            type: 'POST',
            url: 'ajax/presentacionesajax.php',
            data: {
                proceso: 'guardar',
                codigo: nuevaPresentacion.codigo,
                nombre: nuevaPresentacion.nombre
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // cerramos el modal
                    $('#guardarModal').modal('hide');
                    // limpiamos el formulario
                    $('#fmr_presentaciones')[0].reset();
                    // mostramos la alerta
                    notificacion('Éxito', 'success', response.message);

                    cargar_tabla();
                } else {
                    notificacion('Error', 'error', response.message);
                }
            },
            error: function() {
                notificacion('Error', 'error', response.message);
            }
        });
    }
});

// editar
function editar(id) {

    // Hacer la solicitud AJAX al servidor
    var urlprocess = 'ajax/presentacionesajax.php';
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
            notificacion('Error', 'error', response.message);
        }
    });
}

$(".fmr_presentaciones_editar").submit(function(event) {
    event.preventDefault();

    codigo = $("#codigo_mod").val()
    nombre = $("#nombre_mod").val()

    // Supongamos que este código se ejecuta después de que se ha guardado con éxito una nueva presentacion
    var nuevaPresentacion = {
        codigo: $("#codigo_mod").val(),
        nombre: $("#nombre_mod").val(),
        id: $("#id").val()
    };

    if (codigo == "" || nombre == "") {
        // alert("Por favor, completa todos los campos.");
        notificacion('Error', 'error', "Por favor, completa todos los campos.");
        return;
    } else {

        // Hacer la solicitud AJAX para guardar la nueva presentacion
        $.ajax({
            type: 'POST',
            url: 'ajax/presentacionesajax.php',
            data: {
                proceso: 'modificar',
                codigo: nuevaPresentacion.codigo,
                nombre: nuevaPresentacion.nombre,
                id: nuevaPresentacion.id
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // cerramos el modal
                    $('#editarModal').modal('hide');
                    // limpiamos el formulario
                    $('#fmr_presentaciones_editar')[0].reset();
                    // mostramos la alerta
                    notificacion('Éxito', 'success', response.message);

                    cargar_tabla();
                } else {
                    notificacion('Error', 'error', response.message);
                }
            },
            error: function() {
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
        text: '¿Seguro que deseas eliminar el presentacion?',
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
                url: 'ajax/presentacionesajax.php',
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
                        notificacion('Error', 'error', response.message)
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
    window.open('pdfs/generar_pdf_presentaciones.php', '_blank');

}