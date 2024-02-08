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
                        // '<td class="ciudad">' + item.ciudad + '</td>' +
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

function cargar_select(id) {
    cargar_ciudades(id, 'lstSubzonas', 'guardarModal', 'combo_ciudades_all')
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


// editar
function editar(id) {

    // Hacer la solicitud AJAX al servidor
    var urlprocess = 'ajax/clientesajaxv1.php';
    $.ajax({
        type: 'POST',
        url: urlprocess,
        data: 'id=' + id + '&proceso=get_id',
        dataType: 'json',
        success: function(data) {

            // primera parte form
            document.getElementsByName('id')[0].value = data[0].id;
            document.getElementsByName('codigo_mod')[0].value = data[0].codigo;
            // document.getElementsByName('lstSucursal_mod')[0].value = data[0].sucursal
            // document.getElementsByName('lstZonas_mod')[0].value = data[0].zona
            // document.getElementsByName('lstSubzonas_mod')[0].value = data[0].subzona
            document.getElementsByName('nombre_mod')[0].value = data[0].nombre
            document.getElementsByName('direc_mod')[0].value = data[0].direc
            document.getElementsByName('correo_mod')[0].value = data[0].correo
            document.getElementsByName('tel1_mod')[0].value = data[0].tel1
            document.getElementsByName('tel2_mod')[0].value = data[0].tel2
            cargar_departamentos(data[0].zona, 'lstZonas_mod', 'editarModal')
            cargar_departamentos(data[0].sucursal, 'lstSucursal_mod', 'editarModal')
            cargar_ciudades(data[0].subzona, 'lstSubzonas_mod', 'editarModal', 'combo_ciudades_cod')


            // document.getElementsByName('ciudad_mod')[0].value = data[0].ciudad
            // document.getElementsByName('vendedordor_mod')[0].value = data[0].vendedordor
            // document.getElementsByName('cupo_mod')[0].value = data[0].cupo
            // document.getElementsByName('legal_mod')[0].value = data[0].legal
            // document.getElementsByName('fecha_ini_mod')[0].value = data[0].fecha_ini
            // document.getElementsByName('forma_pago_mod')[0].value = data[0].forma_pago
            // document.getElementsByName('cod_viejo_mod')[0].value = data[0].cod_viejo
            // document.getElementsByName('caract_dev_mod')[0].value = data[0].caract_dev
            // document.getElementsByName('digito_mod')[0].value = data[0].digito
            // document.getElementsByName('riva_mod')[0].value = data[0].riva
            // document.getElementsByName('rfte_mod')[0].value = data[0].rfte
            // document.getElementsByName('rica_mod')[0].value = data[0].rica
            // document.getElementsByName('alma_mod')[0].value = data[0].alma
            // document.getElementsByName('cali_mod')[0].value = data[0].cali
            // document.getElementsByName('tipo_mod')[0].value = data[0].tipo
            // document.getElementsByName('distri_mod')[0].value = data[0].distri
            // document.getElementsByName('genom_mod')[0].value = data[0].genom
            // document.getElementsByName('geema_mod')[0].value = data[0].geema
            // document.getElementsByName('getel1_mod')[0].value = data[0].getel1
            // document.getElementsByName('getel2_mod')[0].value = data[0].getel2
            // document.getElementsByName('conom_mod')[0].value = data[0].conom
            // document.getElementsByName('coema_mod')[0].value = data[0].coema
            // document.getElementsByName('cotel1_mod')[0].value = data[0].cotel1
            // document.getElementsByName('cotel2_mod')[0].value = data[0].cotel2
            // document.getElementsByName('panom_mod')[0].value = data[0].panom
            // document.getElementsByName('paema_mod')[0].value = data[0].paema
            // document.getElementsByName('patel1_mod')[0].value = data[0].patel1
            // document.getElementsByName('patel2_mod')[0].value = data[0].patel2
            // document.getElementsByName('otnom_mod')[0].value = data[0].otnom
            // document.getElementsByName('otema_mod')[0].value = data[0].otema
            // document.getElementsByName('ottel1_mod')[0].value = data[0].ottel1
            // document.getElementsByName('ottel2_mod')[0].value = data[0].ottel2
            // document.getElementsByName('remis_mod')[0].value = data[0].remis
            // document.getElementsByName('fbloq_mod')[0].value = data[0].fbloq
            // document.getElementsByName('diaser_mod')[0].value = data[0].diaser
            // document.getElementsByName('diater_mod')[0].value = data[0].diater
            // document.getElementsByName('vlrarr_mod')[0].value = data[0].vlrarr
            // document.getElementsByName('acta_mod')[0].value = data[0].acta
            // document.getElementsByName('pacta_mod')[0].value = data[0].pacta
            // document.getElementsByName('exclui_mod')[0].value = data[0].exclui
            // document.getElementsByName('person_mod')[0].value = data[0].person
            // document.getElementsByName('regime_mod')[0].value = data[0].regime
            // document.getElementsByName('tipoid_mod')[0].value = data[0].tipoid
            // document.getElementsByName('nomreg_mod')[0].value = data[0].nomreg
            // document.getElementsByName('pais_mod')[0].value = data[0].pais
            // document.getElementsByName('nom1_mod')[0].value = data[0].nom1
            // document.getElementsByName('nom2_mod')[0].value = data[0].nom2
            // document.getElementsByName('ape1_mod')[0].value = data[0].ape1
            // document.getElementsByName('ape2_mod')[0].value = data[0].ape2
            // document.getElementsByName('ofi_mod')[0].value = data[0].ofi
            // document.getElementsByName('difici_mod')[0].value = data[0].difici
            // document.getElementsByName('remval_mod')[0].value = data[0].remval
            // document.getElementsByName('estado_mod')[0].value = data[0].estado
            // document.getElementsByName('cono_mod')[0].value = data[0].cono
            // document.getElementsByName('emailq_mod')[0].value = data[0].emailq

            // Limpiar el cuerpo de la tabla
            $('#editarModal').modal('show'); // abrir

        },
        error: function() {
            // Error en la inserción, muestra mensaje de error con SweetAlert
            notificacion('Error', 'error', response.message);
        }
    });
}

$(".fmr_clientes_editar").submit(function(event) {
    event.preventDefault();
    codigo = $("#codigo_mod").val()
        // sucursal = $("#sucursal_mod").val()
        // zona = $("#zona_mod").val()
        // subzona = $("#subzona_mod").val()
        // nombre = $("#nombre_mod").val()
        // direc = $("#direc_mod").val()
        // tel1 = $("#tel1_mod").val()
        // tel2 = $("#tel2_mod").val()
        // ciudad = $("#ciudad_mod").val()
        // Supongamos que este código se ejecuta después de que se ha guardado con éxito una nuevo cliente
    var nuevoCliente = {
        codigo: $("#codigo_mod").val(),
        // sucursal: $("#sucursal_mod").val(),
        // zona: $("#zona_mod").val(),
        // subzona: $("#subzona_mod").val(),
        // nombre: $("#nombre_mod").val(),
        // direc: $("#direc_mod").val(),
        // tel1: $("#tel1_mod").val(),
        // tel2: $("#tel2_mod").val(),
        // ciudad: $("#ciudad_mod").val(),
        // vendedordor: $("#vendedordor_mod").val(),
        // cupo: $("#cupo_mod").val(),
        // legal: $("#legal_mod").val(),
        // fecha_ini: $("#fecha_ini_mod").val(),
        // forma_pago: $("#forma_pago_mod").val(),
        // correo: $("#correo_mod").val(),
        // cod_viejo: $("#cod_viejo_mod").val(),
        // caract_dev: $("#caract_dev_mod").val(),
        // digito: $("#digito_mod").val(),
        // riva: $("#riva_mod").val(),
        // rfte: $("#rfte_mod").val(),
        // rica: $("#rica_mod").val(),
        // alma: $("#alma_mod").val(),
        // cali: $("#cali_mod").val(),
        // tipo: $("#tipo_mod").val(),
        // distri: $("#distri_mod").val(),
        // genom: $("#genom_mod").val(),
        // geema: $("#geema_mod").val(),
        // getel1: $("#getel1_mod").val(),
        // getel2: $("#getel2_mod").val(),
        // conom: $("#conom_mod").val(),
        // coema: $("#coema_mod").val(),
        // cotel1: $("#cotel1_mod").val(),
        // cotel2: $("#cotel2_mod").val(),
        // panom: $("#panom_mod").val(),
        // paema: $("#paema_mod").val(),
        // patel1: $("#patel1_mod").val(),
        // patel2: $("#patel2_mod").val(),
        // otnom: $("#otnom_mod").val(),
        // otema: $("#otema_mod").val(),
        // ottel1: $("#ottel1_mod").val(),
        // ottel2: $("#ottel2_mod").val(),
        // remis: $("#remis_mod").val(),
        // fbloq: $("#fbloq_mod").val(),
        // diaser: $("#diaser_mod").val(),
        // diater: $("#diater_mod").val(),
        // vlrarr: $("#vlrarr_mod").val(),
        // acta: $("#acta_mod").val(),
        // pacta: $("#pacta_mod").val(),
        // exclui: $("#exclui_mod").val(),
        // person: $("#person_mod").val(),
        // regime: $("#regime_mod").val(),
        // tipoid: $("#tipoid_mod").val(),
        // nomreg: $("#nomreg_mod").val(),
        // pais: $("#pais_mod").val(),
        // nom1: $("#nom1_mod").val(),
        // nom2: $("#nom2_mod").val(),
        // ape1: $("#ape1_mod").val(),
        // ape2: $("#ape2_mod").val(),
        // ofi: $("#ofi_mod").val(),
        // difici: $("#difici_mod").val(),
        // remval: $("#remval_mod").val(),
        // estado: $("#estado_mod").val(),
        // cono: $("#cono_mod").val(),
        // emailq: $("#emailq_mod").val(),
        id: $("#id").val()
    };
    if (codigo == "" || sucursal == "" || zona == "" || subzona == "" || nombre == "" ||
        direc == "" || tel1 == "" || tel2 == "" || ciudad == "") {
        // alert("Por favor, completa todos los campos.");
        notificacion('Error', 'error', "Por favor, completa todos los campos.");
        return;
    } else {
        // Hacer la solicitud AJAX para guardar la nuevo cliente
        $.ajax({
            type: 'POST',
            url: 'ajax/clientesajax.php',
            data: {
                proceso: 'modificar',
                codigo: nuevoCliente.codigo,
                sucursal: nuevoCliente.sucursal,
                zona: nuevoCliente.zona,
                subzona: nuevoCliente.subzona,
                nombre: nuevoCliente.nombre,
                direc: nuevoCliente.direc,
                tel1: nuevoCliente.tel1,
                tel2: nuevoCliente.tel2,
                ciudad: nuevoCliente.ciudad,
                // vendedordor: nuevoCliente.vendedordor,
                // cupo: nuevoCliente.cupo,
                // legal: nuevoCliente.legal,
                // fecha_ini: nuevoCliente.fecha_ini,
                // forma_pago: nuevoCliente.forma_pago,
                // correo: nuevoCliente.correo,
                // cod_viejo: nuevoCliente.cod_viejo,
                // caract_dev: nuevoCliente.caract_dev,
                // digito: nuevoCliente.digito,
                // rfte: nuevoCliente.rfte,
                // riva: nuevoCliente.riva,
                // rica: nuevoCliente.rica,
                // alma: nuevoCliente.alma,
                // cali: nuevoCliente.cali,
                // tipo: nuevoCliente.tipo,
                // distri: nuevoCliente.distri,
                // genom: nuevoCliente.genom,
                // geema: nuevoCliente.geema,
                // getel1: nuevoCliente.getel1,
                // getel2: nuevoCliente.getel2,
                // conom: nuevoCliente.conom,
                // coema: nuevoCliente.coema,
                // cotel1: nuevoCliente.cotel1,
                // cotel2: nuevoCliente.cotel2,
                // panom: nuevoCliente.panom,
                // paema: nuevoCliente.paema,
                // patel1: nuevoCliente.patel1,
                // patel2: nuevoCliente.patel2,
                // otnom: nuevoCliente.otnom,
                // otema: nuevoCliente.otema,
                // ottel1: nuevoCliente.ottel1,
                // ottel2: nuevoCliente.ottel2,
                // remis: nuevoCliente.remis,
                // fbloq: nuevoCliente.fbloq,
                // diaser: nuevoCliente.diaser,
                // diater: nuevoCliente.diater,
                // vlrarr: nuevoCliente.vlrarr,
                // acta: nuevoCliente.acta,
                // pacta: nuevoCliente.pacta,
                // exclui: nuevoCliente.exclui,
                // person: nuevoCliente.person,
                // regime: nuevoCliente.regime,
                // tipoid: nuevoCliente.tipoid,
                // nomreg: nuevoCliente.nomreg,
                // pais: nuevoCliente.pais,
                // nom1: nuevoCliente.nom1,
                // nom2: nuevoCliente.nom2,
                // ape1: nuevoCliente.ape1,
                // ape2: nuevoCliente.ape2,
                // ofi: nuevoCliente.ofi,
                // difici: nuevoCliente.difici,
                // remval: nuevoCliente.remval,
                // estado: nuevoCliente.estado,
                // cono: nuevoCliente.cono,
                // emailq: nuevoCliente.emailq,
                id: nuevoCliente.id
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // cerramos el modal
                    $('#editarModal').modal('hide');
                    // limpiamos el formulario
                    $('#fmr_clientes_editar')[0].reset();
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
        text: '¿Seguro que deseas eliminar la cliente?',
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
                url: 'ajax/clientesajax.php',
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