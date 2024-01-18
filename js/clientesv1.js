$(document).ready(function() {
    cargar_tabla()
});

// consultar
function cargar_tabla() {
    // Hacer la solicitud AJAX al servidor
    var urlprocess = 'ajax/clientesajax.php';
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
                        '<td class="zona">' + item.zona + '</td>' +
                        '<td class="subzona">' + item.subzona + '</td>' +
                        '<td class="nombre">' + item.nombre + '</td>' +
                        '<td class="direc">' + item.direc + '</td>' +
                        '<td class="tel1">' + item.tel1 + '</td>' +
                        '<td class="tel2">' + item.tel2 + '</td>' +
                        '<td class="ciudad">' + item.ciudad + '</td>' +
                        '<td class="text-center"><button class="btn btn-outline-primary me-1 mb-1" type="button" onclick=editar(' + item.id + ')>' +
                        '<span class="fas fa-edit me-1" data-fa-transform="shrink-3"></span></button></td>' +
                        '<td class="text-center"><button class="btn btn-outline-primary me-1 mb-1" type="button" onclick=eliminar(' + item.id + ')>' +
                        '<span class="fas fa-trash ms-1" data-fa-transform="shrink-3"></span></button></td>' +
                        '</tr>'
                    );
                });

                // Inicializar List.js después de agregar datos
                var options = {
                    valueNames: ['codigo', 'zona', 'subzona', 'nombre', 'direc', 'tel1', 'tel2', 'ciudad'],
                    item: '<tr><td class="codigo"></td><td class="zona"></td><td class="subzona"></td><td class="nombre"></td><td class="direc">' +
                        '<td class="nombre"></td><td class="direc"></td><td class="tel1"></td><td class="tel2"></td><td class="ciudad"></td>'
                };
                var userList = new List('myTable', options);

                // Actualizar la lista después de agregar los datos
                userList.update();

                // Re-inicializar la búsqueda después de la actualización de la lista
                var input = document.querySelector('.search');
                var searchList = new List('myTable', {
                    valueNames: ['codigo', 'zona', 'subzona', 'nombre', 'direc', 'tel1', 'tel2', 'ciudad'],
                    page: 5
                });
                input.addEventListener('input', function() {
                    searchList.search(input.value);
                });
            } else {
                // Mostrar un mensaje indicando que no hay clientes disponibles
                $('#myTable tbody').html('<tr><td colspan="8" class="text-center">No hay clientes disponibles</td></tr>');
            }
        },
        error: function() {
            // Error en la inserción, muestra mensaje de error con SweetAlert
            notificacion('Error', 'error', response.message);
        }
    });
}

//consultar documento
function obtenerDocumento(codigo) {
    var urlprocess = "ajax/clientesajaxv1.php";
    var btnSiguiente = document.getElementById("btnSiguiente");

    $.ajax({
        type: 'POST',
        url: urlprocess,
        data: { proceso: 'get_cod', codigo: codigo },
        dataType: 'json',
        success: function(data) {
            if (data.status == "Error") {
                notificacion('Error', 'error', data.mensaje);
                btnSiguiente.disabled = true;
            } else {
                btnSiguiente.disabled = false;
            }
        },
        error: function(error) {
            notificacion('Error', 'error', error);
        }
    });
}

// Función para obtener los datos de un formulario
function obtenerDatosFormulario(formulario) {
    var elementos = formulario.elements;
    var datos = {};

    for (var i = 0; i < elementos.length; i++) {
        var elemento = elementos[i];
        if (elemento.tagName === 'INPUT' || elemento.tagName === 'SELECT' || elemento.tagName === 'TEXTAREA') {
            datos[elemento.name] = elemento.value;
        }
    }

    return datos;
}

// Función para obtener los datos de todos los formularios
function obtenerDatosFormularios() {
    var datos = {};

    // Obtener datos del formulario 1
    var formulario1 = document.getElementById('fmr_clientes1');
    datos['fmr_clientes1'] = obtenerDatosFormulario(formulario1);

    // Obtener datos del formulario 2
    var formulario2 = document.getElementById('fmr_clientes2');
    datos['fmr_clientes2'] = obtenerDatosFormulario(formulario2);

    // Obtener datos del formulario 3
    var formulario3 = document.getElementById('fmr_clientes3');
    datos['fmr_clientes3'] = obtenerDatosFormulario(formulario3);

    return datos;
}

// Función para validar que todos los formularios tengan valores
function validarFormularios(datos) {
    var datos_formateados = {};

    for (var formulario in datos) {
        if (datos.hasOwnProperty(formulario)) {
            var datosFormulario = datos[formulario];
            for (var campo in datosFormulario) {
                if (datosFormulario.hasOwnProperty(campo)) {
                    // Excluir campo tel2 del formulario 1 de la validación
                    if (formulario === 'fmr_clientes1' && campo === 'tel2') {
                        if (!datosFormulario[campo]) {
                            datos_formateados[campo] = ''
                        } else {
                            datos_formateados[campo] = datosFormulario[campo]
                        }
                        continue;
                    }
                    if (formulario === 'fmr_clientes2' && campo === 'tel2') {
                        if (!datosFormulario[campo]) {
                            datos_formateados[campo] = ''
                        } else {
                            datos_formateados[campo] = datosFormulario[campo]
                        }
                        continue;
                    }
                    if (formulario === 'fmr_clientes3' && campo === 'tel2') {
                        if (!datosFormulario[campo]) {
                            datos_formateados[campo] = ''
                        } else {
                            datos_formateados[campo] = datosFormulario[campo]
                        }
                        continue;
                    }

                    if (!datosFormulario[campo]) {
                        console.log('El formulario ' + formulario + ' tiene un campo vacío: ' + campo);
                        return false;
                    }
                    datos_formateados[campo] = datosFormulario[campo]
                }
            }
        }
    }
    return { 'valido': true, 'datos': datos_formateados };
}

// Agregar evento al botón "Siguiente"
var btnSiguiente = document.getElementById('btnSiguiente');
btnSiguiente.addEventListener('click', function() {
    var datosFormularios = obtenerDatosFormularios();
    var resultadoValidacion = validarFormularios(datosFormularios);

    if (resultadoValidacion.valido) {
        console.log('Todos los formularios tienen valores válidos.');
        console.table(resultadoValidacion.datos)
        var datos_formulario_json = resultadoValidacion.datos
        datos_formulario_json["proceso"] = "guardar";

        // Hacer la solicitud AJAX para guardar la nuevo cliente
        $.ajax({
            type: 'POST',
            url: 'ajax/clientesajaxv1.php',
            data: datos_formulario_json,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // limpiamos el formulario
                    $('.fmr_clientes')[0].reset();

                    // Selecciona el elemento por su ID
                    var resp_titulo = document.getElementById('resp_titulo');
                    var resp_mensaje = document.getElementById('resp_mensaje');

                    // Actualiza el contenido del elemento con el valor
                    resp_titulo.innerHTML = 'Éxito';
                    resp_mensaje.innerHTML = response.message;

                    // mostramos la alerta
                    // notificacion('Éxito', 'success', response.message);

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


        // Aquí puedes enviar los datos a través de Ajax o realizar otras acciones.
    } else {
        console.log('Al menos un formulario tiene campos vacíos.');
    }
});

// funcion para crear la notificacion
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
        confirmButtoncliente: color
    });
}

// funcion para generar el pdf
function generar() {
    // Abre la URL del archivo PDF en una nueva pestaña
    window.open('pdfs/generar_pdf_clientes.php', '_blank');

}
// Función para cerrar el modal
function cerrar_modal() {
    $('#guardarModal').modal('hide');
}

function abrir_modal() {
    $('#fmr_clientes1')[0].reset();
    $('#fmr_clientes2')[0].reset();
    $('#fmr_clientes3')[0].reset();

    $('#guardarModal').modal('show');
    document.getElementById('abrir').click();
    cargar_departamentos("", 'lstSucursal', 'guardarModal')
    cargar_departamentos("", 'lstZonas', 'guardarModal')
    cargar_ciudades("", 'lstSubzonas', 'guardarModal')

}

function cargar_selct(id) {
    cargar_ciudades(id, 'lstSubzonas', 'guardarModal')
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
                proceso: "combo_departamentos",
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

function cargar_ciudades(Id, nameSelect, Modal) {
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
                proceso: "combo_ciudades",
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