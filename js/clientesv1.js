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

    $.ajax({
        type: 'POST',
        url: urlprocess,
        data: { proceso: 'get_cod', codigo: codigo },
        dataType: 'json',
        success: function(data) {
            if (data != "No hay clientes") {
                document.getElementById('id').value = data[0].id
                document.getElementById('codigo').value = data[0].codigo
                document.getElementById('sucursal').value = data[0].sucursal
                document.getElementById('nombre').value = data[0].nombre
                document.getElementById('zona').value = data[0].zona
                document.getElementById('subzona').value = data[0].subzona
                document.getElementById('direc').value = data[0].direc
                document.getElementById('correo').value = data[0].correo
                document.getElementById('tel1').value = data[0].tel1
                document.getElementById('tel2').value = data[0].tel2
            } else {
                document.getElementById('id').value = codigo
                document.getElementById('codigo').value = codigo
                document.getElementById('sucursal').value = ''
                document.getElementById('nombre').value = ''
                document.getElementById('zona').value = ''
                document.getElementById('subzona').value = ''
                document.getElementById('direc').value = ''
                document.getElementById('correo').value = ''
                document.getElementById('tel1').value = ''
                document.getElementById('tel2').value = ''
            }

        },
        error: function(error) {
            console.log('Error al obtener datos: ', error);
        }
    });
}

// guardar
$(".fmr_clientes").submit(function(event) {
    event.preventDefault();
    codigo = $("#codigo").val()
    sucursal = $("#sucursal").val()
    zona = $("#zona").val()
    subzona = $("#subzona").val()
    nombre = $("#nombre").val()
    direc = $("#direc").val()
    tel1 = $("#tel1").val()
    tel2 = $("#tel2").val()
    ciudad = $("#ciudad").val()
        // Supongamos que este código se ejecuta después de que se ha guardado con éxito un nuevo cliente
    var nuevoCliente = {
        codigo: $("#codigo").val(),
        sucursal: $("#sucursal").val(),
        zona: $("#zona").val(),
        subzona: $("#subzona").val(),
        nombre: $("#nombre").val(),
        direc: $("#direc").val(),
        tel1: $("#tel1").val(),
        tel2: $("#tel2").val(),
        ciudad: $("#ciudad").val()
            // vendedordor: $("#vendedordor").val(),
            // cupo: $("#cupo").val(),
            // legal: $("#legal").val(),
            // fecha_ini: $("#fecha_ini").val(),
            // forma_pago: $("#forma_pago").val(),
            // correo: $("#correo").val(),
            // cod_viejo: $("#cod_viejo").val(),
            // caract_dev: $("#caract_dev").val(),
            // digito: $("#digito").val(),
            // riva: $("#riva").val(),
            // rfte: $("#rfte").val(),
            // rica: $("#rica").val(),
            // alma: $("#alma").val(),
            // cali: $("#cali").val(),
            // tipo: $("#tipo").val(),
            // distri: $("#distri").val(),
            // genom: $("#genom").val(),
            // geema: $("#geema").val(),
            // getel1: $("#getel1").val(),
            // getel2: $("#getel2").val(),
            // conom: $("#conom").val(),
            // coema: $("#coema").val(),
            // cotel1: $("#cotel1").val(),
            // cotel2: $("#cotel2").val(),
            // panom: $("#panom").val(),
            // paema: $("#paema").val(),
            // patel1: $("#patel1").val(),
            // patel2: $("#panom").val(),
            // otnom: $("#otnom").val(),
            // otema: $("#otema").val(),
            // ottel1: $("#ottel1").val(),
            // ottel2: $("#ottel2").val(),
            // remis: $("#remis").val(),
            // fbloq: $("#fbloq").val(),
            // diaser: $("#diaser").val(),
            // diater: $("#diater").val(),
            // vlrarr: $("#vlrarr").val(),
            // acta: $("#acta").val(),
            // pacta: $("#pacta").val(),
            // exclui: $("#exclui").val(),
            // person: $("#person").val(),
            // regime: $("#regime").val(),
            // tipoid: $("#tipoid").val(),
            // nomreg: $("#nomreg").val(),
            // pais: $("#pais").val(),
            // nom1: $("#nom1").val(),
            // nom2: $("#nom2").val(),
            // ape1: $("#ape1").val(),
            // ape2: $("#ape2").val(),
            // ofi: $("#ofi").val(),
            // difici: $("#difici").val(),
            // remval: $("#remval").val(),
            // estado: $("#estado").val(),
            // cono: $("#cono").val(),
            // emailq: $("#emailq").val()
    };
    if (codigo == "" || sucursal == "" || zona == "" || subzona == "" || nombre == "" ||
        direc == "" || tel1 == "" || ciudad == "") {
        // alert("Por favor, completa todos los campos.");
        notificacion('Error', 'error', "Por favor, completa todos los campos.");
        return;
    } else {
        // Hacer la solicitud AJAX para guardar la nuevo cliente
        $.ajax({
            type: 'POST',
            url: 'ajax/clientesajax.php',
            data: {
                proceso: 'guardar',
                codigo: nuevoCliente.codigo,
                sucursal: nuevoCliente.sucursal,
                zona: nuevoCliente.zona,
                subzona: nuevoCliente.subzona,
                nombre: nuevoCliente.nombre,
                direc: nuevoCliente.direc,
                tel1: nuevoCliente.tel1,
                tel2: nuevoCliente.tel2,
                ciudad: nuevoCliente.ciudad,
                // vendedor: nuevoCliente.vendedor,
                // cupo: nuevoCliente.cupo,
                // legal: nuevoCliente.legal,
                // fecha_ini: nuevoCliente.fecha_ini,
                // forma_pago: nuevoCliente.forma_pago,
                // correo: nuevoCliente.correo,
                // cod_viejo: nuevoCliente.cod_viejo,
                // caract_dev: nuevoCliente.caract_dev,
                // digito: nuevoCliente.digito,
                // riva: nuevoCliente.riva,
                // rfte: nuevoCliente.rfte,
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
                // emailq: nuevoCliente.emailq
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // cerramos el modal
                    $('#guardarModal').modal('hide');
                    // limpiamos el formulario
                    $('#fmr_clientes')[0].reset();
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
    var urlprocess = 'ajax/clientesajax.php';
    $.ajax({
        type: 'POST',
        url: urlprocess,
        data: 'id=' + id + '&proceso=get_id',
        dataType: 'json',
        success: function(data) {

            // Asignar un valor al input
            document.getElementById('id').value = data[0].id
            document.getElementById('codigo_mod').value = data[0].codigo
            document.getElementById('sucursal_mod').value = data[0].sucursal
            document.getElementById('zona_mod').value = data[0].zona
            document.getElementById('subzona_mod').value = data[0].subzona
            document.getElementById('nombre_mod').value = data[0].nombre
            document.getElementById('direc_mod').value = data[0].direc
            document.getElementById('tel1_mod').value = data[0].tel1
            document.getElementById('tel2_mod').value = data[0].tel2
            document.getElementById('ciudad_mod').value = data[0].ciudad
                // document.getElementById('vendedordor_mod').value = data[0].vendedordor
                // document.getElementById('cupo_mod').value = data[0].cupo
                // document.getElementById('legal_mod').value = data[0].legal
                // document.getElementById('fecha_ini_mod').value = data[0].fecha_ini
                // document.getElementById('forma_pago_mod').value = data[0].forma_pago
                // document.getElementById('correo_mod').value = data[0].correo
                // document.getElementById('cod_viejo_mod').value = data[0].cod_viejo
                // document.getElementById('caract_dev_mod').value = data[0].caract_dev
                // document.getElementById('digito_mod').value = data[0].digito
                // document.getElementById('riva_mod').value = data[0].riva
                // document.getElementById('rfte_mod').value = data[0].rfte
                // document.getElementById('rica_mod').value = data[0].rica
                // document.getElementById('alma_mod').value = data[0].alma
                // document.getElementById('cali_mod').value = data[0].cali
                // document.getElementById('tipo_mod').value = data[0].tipo
                // document.getElementById('distri_mod').value = data[0].distri
                // document.getElementById('genom_mod').value = data[0].genom
                // document.getElementById('geema_mod').value = data[0].geema
                // document.getElementById('getel1_mod').value = data[0].getel1
                // document.getElementById('getel2_mod').value = data[0].getel2
                // document.getElementById('conom_mod').value = data[0].conom
                // document.getElementById('coema_mod').value = data[0].coema
                // document.getElementById('cotel1_mod').value = data[0].cotel1
                // document.getElementById('cotel2_mod').value = data[0].cotel2
                // document.getElementById('panom_mod').value = data[0].panom
                // document.getElementById('paema_mod').value = data[0].paema
                // document.getElementById('patel1_mod').value = data[0].patel1
                // document.getElementById('patel2_mod').value = data[0].patel2
                // document.getElementById('otnom_mod').value = data[0].otnom
                // document.getElementById('otema_mod').value = data[0].otema
                // document.getElementById('ottel1_mod').value = data[0].ottel1
                // document.getElementById('ottel2_mod').value = data[0].ottel2
                // document.getElementById('remis_mod').value = data[0].remis
                // document.getElementById('fbloq_mod').value = data[0].fbloq
                // document.getElementById('diaser_mod').value = data[0].diaser
                // document.getElementById('diater_mod').value = data[0].diater
                // document.getElementById('vlrarr_mod').value = data[0].vlrarr
                // document.getElementById('acta_mod').value = data[0].acta
                // document.getElementById('pacta_mod').value = data[0].pacta
                // document.getElementById('exclui_mod').value = data[0].exclui
                // document.getElementById('person_mod').value = data[0].person
                // document.getElementById('regime_mod').value = data[0].regime
                // document.getElementById('tipoid_mod').value = data[0].tipoid
                // document.getElementById('nomreg_mod').value = data[0].nomreg
                // document.getElementById('pais_mod').value = data[0].pais
                // document.getElementById('nom1_mod').value = data[0].nom1
                // document.getElementById('nom2_mod').value = data[0].nom2
                // document.getElementById('ape1_mod').value = data[0].ape1
                // document.getElementById('ape2_mod').value = data[0].ape2
                // document.getElementById('ofi_mod').value = data[0].ofi
                // document.getElementById('difici_mod').value = data[0].difici
                // document.getElementById('remval_mod').value = data[0].remval
                // document.getElementById('estado_mod').value = data[0].estado
                // document.getElementById('cono_mod').value = data[0].cono
                // document.getElementById('emailq_mod').value = data[0].emailq

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
    sucursal = $("#sucursal_mod").val()
    zona = $("#zona_mod").val()
    subzona = $("#subzona_mod").val()
    nombre = $("#nombre_mod").val()
    direc = $("#direc_mod").val()
    tel1 = $("#tel1_mod").val()
    tel2 = $("#tel2_mod").val()
    ciudad = $("#ciudad_mod").val()
        // Supongamos que este código se ejecuta después de que se ha guardado con éxito una nuevo cliente
    var nuevoCliente = {
        codigo: $("#codigo_mod").val(),
        sucursal: $("#sucursal_mod").val(),
        zona: $("#zona_mod").val(),
        subzona: $("#subzona_mod").val(),
        nombre: $("#nombre_mod").val(),
        direc: $("#direc_mod").val(),
        tel1: $("#tel1_mod").val(),
        tel2: $("#tel2_mod").val(),
        ciudad: $("#ciudad_mod").val(),
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

function generar() {
    // Abre la URL del archivo PDF en una nueva pestaña
    window.open('pdfs/generar_pdf_clientes.php', '_blank');

}