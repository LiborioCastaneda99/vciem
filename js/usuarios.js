$(document).ready(function() {
    cargar_tabla()
});

// consultar
function cargar_tabla() {
    // Hacer la solicitud AJAX al servidor
    var urlprocess = 'ajax/usuariosajax.php';
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
                        '<td class="codigo">' + item.id + '</td>' +
                        '<td class="nombre">' + item.nombre + '</td>' +
                        '<td class="correo_electronico">' + item.correo_electronico + '</td>' +
                        '<td class="rol">' + item.rol + '</td>' +
                        '<td class="text-center"><button class="btn btn-outline-primary me-1 mb-1" type="button" onclick=editar(' + item.id + ')>' +
                        '<span class="fas fa-edit me-1" data-fa-transform="shrink-3"></span></button></td>' +
                        '<td class="text-center"><button class="btn btn-outline-primary me-1 mb-1" type="button" onclick=eliminar(' + item.id + ')>' +
                        '<span class="fas fa-trash ms-1" data-fa-transform="shrink-3"></span></button></td>' +
                        '</tr>'
                    );
                });

                // Inicializar List.js después de agregar datos
                var options = {
                    valueNames: ['codigo', 'nombre', 'correo_electronico', 'rol'],
                    item: '<tr><td class="codigo"></td><td class="nombre"></td><td class="correo_electronico"></td><td class="rol"></td></tr>'
                };
                var userList = new List('myTable', options);

                // Actualizar la lista después de agregar los datos
                userList.update();

                // Re-inicializar la búsqueda después de la actualización de la lista
                var input = document.querySelector('.search');
                var searchList = new List('myTable', { valueNames: ['codigo', 'nombre', 'correo_electronico', 'rol'], page: 5 });
                input.addEventListener('input', function() {
                    searchList.search(input.value);
                });
            } else {
                // Mostrar un mensaje indicando que no hay usuarios disponibles
                $('#myTable tbody').html('<tr><td colspan="5" class="text-center">No hay usuarios disponibles</td></tr>');
            }
        },
        error: function() {
            // Error en la inserción, muestra mensaje de error con SweetAlert
            notificacion('Error', 'error', response.message);
        }
    });
}

// guardar btn
$(".fmr_usuarios").submit(function(event) {
    event.preventDefault();

    nombre = $("#nombre").val()
    correo_electronico = $("#correo_electronico").val()
    lstRoles = $("#lstRolesAgregar").val()

    // Supongamos que este código se ejecuta después de que se ha guardado con éxito una nueva marca
    var nuevamarca = {
        nombre: nombre,
        correo_electronico: correo_electronico,
        lstRoles: lstRoles
    };

    if (nombre == "" || correo_electronico == "" || lstRoles == "") {
        // alert("Por favor, completa todos los campos.");
        notificacion('Error', 'error', "Por favor, completa todos los campos.");
        return;
    } else {
        // Hacer la solicitud AJAX para guardar la nueva marca
        $.ajax({
            type: 'POST',
            url: 'ajax/usuariosajax.php',
            data: {
                proceso: 'guardar',
                nombre: nuevamarca.nombre,
                correo_electronico: nuevamarca.correo_electronico,
                lstRoles: nuevamarca.lstRoles
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // cerramos el modal
                    $('#guardarModal').modal('hide');
                    // limpiamos el formulario
                    $('#fmr_usuarios')[0].reset();
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

// editar funcion
function editar(id) {

    // Hacer la solicitud AJAX al servidor
    var urlprocess = 'ajax/usuariosajax.php';
    $.ajax({
        type: 'POST',
        url: urlprocess,
        data: 'id=' + id + '&proceso=get_id',
        dataType: 'json',
        success: function(data) {

            // Asignar un valor al input
            document.getElementById('id').value = data[0].id
            document.getElementById('codigo_mod').value = data[0].id
            document.getElementById('nombre_mod').value = data[0].nombre
            document.getElementById('correo_electronico_mod').value = data[0].correo_electronico
            cargar_roles(data[0].id_rol, 'lstRolesMod');

            // Limpiar el cuerpo de la tabla
            $('#editarModal').modal('show'); // abrir

        },
        error: function() {
            // Error en la inserción, muestra mensaje de error con SweetAlert
            notificacion('Error', 'error', response.message);
        }
    });
}

//editar btn
$(".fmr_usuarios_editar").submit(function(event) {
    event.preventDefault();

    // Supongamos que este código se ejecuta después de que se ha guardado con éxito una nueva marca
    codigo = $("#codigo_mod").val()
    nombre = $("#nombre_mod").val()
    correo_electronico = $("#correo_electronico_mod").val()
    lstRoles = $("#lstRolesMod").val()

    var nuevamarca = {
        codigo: codigo,
        nombre: nombre,
        correo_electronico: correo_electronico,
        lstRoles: lstRoles,
        id: $("#id").val()
    };

    if (codigo == "" || nombre == "" || correo_electronico == "" || lstRoles == "") {
        // alert("Por favor, completa todos los campos.");
        notificacion('Error', 'error', "Por favor, completa todos los campos.");
        return;
    } else {
        // Hacer la solicitud AJAX para guardar la nueva marca
        $.ajax({
            type: 'POST',
            url: 'ajax/usuariosajax.php',
            data: {
                proceso: 'modificar',
                codigo: nuevamarca.codigo,
                nombre: nuevamarca.nombre,
                correo_electronico: nuevamarca.correo_electronico,
                lstRoles: nuevamarca.lstRoles,
                id: nuevamarca.id
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // cerramos el modal
                    $('#editarModal').modal('hide');
                    // limpiamos el formulario
                    $('#fmr_usuarios_editar')[0].reset();
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
        text: '¿Seguro que deseas eliminar el usuario?',
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
                url: 'ajax/usuariosajax.php',
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
                    notificacion('Error', 'error', response.message);
                }
            });
        }
    });
}

// notificacion
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
        confirmButtonmarca: color
    });
}

function generar() {
    // Abre la URL del archivo PDF en una nueva pestaña
    window.open('pdfs/generar_pdf_usuarios.php', '_blank');

}

// // cuadramos lo que queremos imprimir
document.getElementById('btnAgregar').addEventListener('click', function() {
    cargar_roles('', 'lstRolesAgregar');
});

// Funcion para cargar las listas select con opcion de busqueda
$('#btnBusquedaAgregar').click(function() {
    cargar_roles('', 'lstRolesAgregar');
});

// Funcion para cargar las listas select con opcion de busqueda
$('#btnBusquedaMod').click(function() {
    cargar_roles('', 'lstRolesMod');
});

function cargar_roles(Id, nameSelect) {
    var lstRoles = $('#' + nameSelect);

    // Limpiar el contenido actual del select

    select = nameSelect

    lstRoles.empty();

    if (Id !== "") {
        var searchTerm = '';

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'ajax/usuariosajax.php',
            data: {
                searchTerm: searchTerm,
                proceso: "combo_roles",
                id: Id
            },
        }).then(function(registros) {
            // Agregar nuevas opciones al select
            console.table(registros)
            $(registros).each(function(i, v) {
                lstRoles.append('<option value="' + v.id + '">' + v.text + '</option>');
            });
        });
    } else {
        // Agregar una opción por defecto al select
        lstRoles.append('<option value="" selected>Seleccione un rol</option>');
        var searchTerm = '';

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'ajax/usuariosajax.php',
            data: {
                searchTerm: searchTerm,
                proceso: "combo_roles",
                id: Id
            },
        }).then(function(registros) {
            // Agregar nuevas opciones al select
            console.table(registros)
            $(registros).each(function(i, v) {
                lstRoles.append('<option value="' + v.id + '">' + v.text + '</option>');
            });
        });

    }
}