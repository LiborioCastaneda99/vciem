$(document).ready(function() {
    cargar_tabla()
});

// consultar
function cargar_tabla() {
    // Hacer la solicitud AJAX al servidor
    var urlprocess = 'ajax/proveedoresajax.php';
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
                        '<td class="suc">' + item.suc + '</td>' +
                        '<td class="zona">' + item.zona + '</td>' +
                        '<td class="subzona">' + item.subzona + '</td>' +
                        '<td class="nombre">' + item.nombre + '</td>' +
                        '<td class="dir">' + item.dir + '</td>' +
                        '<td class="tel1">' + item.tel1 + '</td>' +
                        '<td class="tel2">' + item.tel2 + '</td>' +
                        '<td class="ciudad">' + item.ciudad + '</td>' +
                        '<td class="cupo">' + item.cupo + '</td>' +
                        '<td class="legal">' + item.legal + '</td>' +
                        '<td class="fecha_ini">' + item.fecha_ini + '</td>' +
                        '<td class="fpago">' + item.forma_pago + '</td>' +
                        '<td class="correo">' + item.correo + '</td>' +
                        '<td class="caract_dev">' + item.caract_dev + '</td>' +
                        '<td class="digito">' + item.digito + '</td>' +
                        '<td class="riva">' + item.riva + '</td>' +
                        '<td class="rfte">' + item.rfte + '</td>' +
                        '<td class="rica">' + item.rica + '</td>' +
                        '<td class="estado">' + item.estado + '</td>' +
                        '<td class="text-center"><button class="btn btn-outline-primary me-1 mb-1" type="button" onclick=editar(' + item.id + ')>' +
                        '<span class="fas fa-edit me-1" data-fa-transform="shrink-3"></span></button></td>' +
                        '<td class="text-center"><button class="btn btn-outline-primary me-1 mb-1" type="button" onclick=eliminar(' + item.id + ')>' +
                        '<span class="fas fa-trash ms-1" data-fa-transform="shrink-3"></span></button></td>' +
                        '</tr>'
                    );
                });

                // Inicializar List.js después de agregar datos
                var options = {
                    valueNames: ['codigo', 'suc', 'zona', 'subzona', 'nombre', 'dir', 'tel1', 'tel2', 'ciudad', 'cupo', 'legal', 'fecha_ini', 'fpago', 'correo',
                        'caract_dev', 'digito', 'riva', 'rfte', 'rica', 'estado'
                    ],
                    item: '<tr><td class="codigo"></td><td class="suc"></td><td class="zona"></td><td class="subzona"></td><td class="nombre"></td>' +
                        '<td class="dir"></td><td class="tel1"></td><td class="tel2"></td><td class="ciudad"></td><td class="cupo"></td><td class="legal"></td>' +
                        '<td class="fecha_ini"></td><td class="fpago"></td><td class="correo"></td><td class="caract_dev"></td><td class="digito"></td>' +
                        '<td class="riva"></td><td class="rfte"></td><td class="rica"></td><td class="estado"></td></tr>'
                };
                var userList = new List('myTable', options);

                // Actualizar la lista después de agregar los datos
                userList.update();

                // Re-inicializar la búsqueda después de la actualización de la lista
                var input = document.querySelector('.search');
                var searchList = new List('myTable', {
                    valueNames: ['codigo', 'suc', 'zona', 'subzona', 'nombre', 'dir', 'tel1', 'tel2', 'ciudad', 'cupo', 'legal', 'fecha_ini', 'fpago', 'correo',
                        'caract_dev', 'digito', 'riva', 'rfte', 'rica', 'estado'
                    ],
                    page: 5
                });
                input.addEventListener('input', function() {
                    searchList.search(input.value);
                });
            } else {
                // Mostrar un mensaje indicando que no hay proveedores disponibles
                $('#myTable tbody').html('<tr><td colspan="18" class="text-center">No hay proveedores disponibles</td></tr>');
            }
        },
        error: function() {
            // Error en la inserción, muestra mensaje de error con SweetAlert
            notificacion('Error', 'error', response.message);
        }
    });
}

// guardar
$(".fmr_proveedores").submit(function(event) {
    event.preventDefault();

    codigo = $("#codigo").val()
    suc = $("#suc").val()
    zona = $("#zona").val()
    subzona = $("#subzona").val()
    nombre = $("#nombre").val()
    dir = $("#dir").val()
    tel1 = $("#tel1").val()
    tel2 = $("#tel2").val()
    ciudad = $("#ciudad").val()
    cupo = $("#cupo").val()
    legal = $("#legal").val()
    fecha_ini = $("#fecha_ini").val()
    fpago = $("#fpago").val()
    correo = $("#correo").val()
    caract_dev = $("#caract_dev").val()
    digito = $("#digito").val()
    riva = $("#riva").val()
    rfte = $("#rfte").val()
    rica = $("#rica").val()
    estado = $("#estado").val()

    // Supongamos que este código se ejecuta después de que se ha guardado con éxito un nuevo proveedor
    var nuevoproveedor = {
        codigo: $("#codigo").val(),
        suc: $("#suc").val(),
        zona: $("#zona").val(),
        subzona: $("#subzona").val(),
        nombre: $("#nombre").val(),
        dir: $("#dir").val(),
        tel1: $("#tel1").val(),
        tel2: $("#tel2").val(),
        ciudad: $("#ciudad").val(),
        cupo: $("#cupo").val(),
        legal: $("#legal").val(),
        fecha_ini: $("#fecha_ini").val(),
        fpago: $("#fpago").val(),
        correo: $("#correo").val(),
        caract_dev: $("#caract_dev").val(),
        digito: $("#digito").val(),
        riva: $("#riva").val(),
        rfte: $("#rfte").val(),
        rica: $("#rica").val(),
        estado: $("#estado").val()
    };

    if (codigo == "" || suc == "" || zona == "" || subzona == "" || nombre == "" || dir == "" ||
        tel1 == "" || tel2 == "" || ciudad == "" || cupo == "" || legal == "" || fecha_ini == "" ||
        fpago == "" || correo == "" || caract_dev == "" || digito == "" || riva == "" || rfte == "" ||
        rica == "" || estado == "") {
        // alert("Por favor, completa todos los campos.");
        notificacion('Error', 'error', "Por favor, completa todos los campos.");
        return;
    } else {

        // Hacer la solicitud AJAX para guardar la nuevo proveedor
        $.ajax({
            type: 'POST',
            url: 'ajax/proveedoresajax.php',
            data: {
                proceso: 'guardar',
                codigo: nuevoproveedor.codigo,
                suc: nuevoproveedor.suc,
                zona: nuevoproveedor.zona,
                subzona: nuevoproveedor.subzona,
                nombre: nuevoproveedor.nombre,
                dir: nuevoproveedor.dir,
                tel1: nuevoproveedor.tel1,
                tel2: nuevoproveedor.tel2,
                ciudad: nuevoproveedor.ciudad,
                cupo: nuevoproveedor.cupo,
                legal: nuevoproveedor.legal,
                fecha_ini: nuevoproveedor.fecha_ini,
                fpago: nuevoproveedor.fpago,
                correo: nuevoproveedor.correo,
                caract_dev: nuevoproveedor.caract_dev,
                digito: nuevoproveedor.digito,
                riva: nuevoproveedor.riva,
                rfte: nuevoproveedor.rfte,
                rica: nuevoproveedor.rica,
                estado: nuevoproveedor.estado
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // cerramos el modal
                    $('#guardarModal').modal('hide');
                    // limpiamos el formulario
                    $('#fmr_proveedores')[0].reset();
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
    var urlprocess = 'ajax/proveedoresajax.php';
    $.ajax({
        type: 'POST',
        url: urlprocess,
        data: 'id=' + id + '&proceso=get_id',
        dataType: 'json',
        success: function(data) {

            // Asignar un valor al input
            document.getElementById('id').value = data[0].id
            document.getElementById('codigo_mod').value = data[0].codigo
            document.getElementById('suc_mod').value = data[0].suc
            document.getElementById('zona_mod').value = data[0].zona
            document.getElementById('subzona_mod').value = data[0].subzona
            document.getElementById('nombre_mod').value = data[0].nombre
            document.getElementById('dir_mod').value = data[0].dir
            document.getElementById('tel1_mod').value = data[0].tel1
            document.getElementById('tel2_mod').value = data[0].tel2
            document.getElementById('ciudad_mod').value = data[0].ciudad
            document.getElementById('cupo_mod').value = data[0].cupo
            document.getElementById('legal_mod').value = data[0].legal
            document.getElementById('fecha_ini_mod').value = data[0].fecha_ini
            document.getElementById('fpago_mod').value = data[0].forma_pago
            document.getElementById('correo_mod').value = data[0].correo
            document.getElementById('caract_dev_mod').value = data[0].caract_dev
            document.getElementById('digito_mod').value = data[0].digito
            document.getElementById('riva_mod').value = data[0].riva
            document.getElementById('rfte_mod').value = data[0].rfte
            document.getElementById('rica_mod').value = data[0].rica
            document.getElementById('estado_mod').value = data[0].estado

            // Limpiar el cuerpo de la tabla
            $('#editarModal').modal('show'); // abrir

        },
        error: function() {
            // Error en la inserción, muestra mensaje de error con SweetAlert
            notificacion('Error', 'error', response.message);
        }
    });
}

$(".fmr_proveedores_editar").submit(function(event) {
    event.preventDefault();

    codigo = $("#codigo_mod").val()
    suc = $("#suc_mod").val()
    zona = $("#zona_mod").val()
    subzona = $("#subzona_mod").val()
    nombre = $("#nombre_mod").val()
    dir = $("#dir_mod").val()
    tel1 = $("#tel1_mod").val()
    tel2 = $("#tel2_mod").val()
    ciudad = $("#ciudad_mod").val()
    cupo = $("#cupo_mod").val()
    legal = $("#legal_mod").val()
    fecha_ini = $("#fecha_ini_mod").val()
    fpago = $("#fpago_mod").val()
    correo = $("#correo_mod").val()
    caract_dev = $("#caract_dev_mod").val()
    digito = $("#digito_mod").val()
    riva = $("#riva_mod").val()
    rfte = $("#rfte_mod").val()
    rica = $("#rica_mod").val()
    estado = $("#estado_mod").val()

    // Supongamos que este código se ejecuta después de que se ha guardado con éxito una nuevo proveedor
    var nuevoproveedor = {
        codigo: $("#codigo_mod").val(),
        suc: $("#suc_mod").val(),
        zona: $("#zona_mod").val(),
        subzona: $("#subzona_mod").val(),
        nombre: $("#nombre_mod").val(),
        dir: $("#dir_mod").val(),
        tel1: $("#tel1_mod").val(),
        tel2: $("#tel2_mod").val(),
        ciudad: $("#ciudad_mod").val(),
        cupo: $("#cupo_mod").val(),
        legal: $("#legal_mod").val(),
        fecha_ini: $("#fecha_ini_mod").val(),
        fpago: $("#fpago_mod").val(),
        correo: $("#correo_mod").val(),
        caract_dev: $("#caract_dev_mod").val(),
        digito: $("#digito_mod").val(),
        riva: $("#riva_mod").val(),
        rfte: $("#rfte_mod").val(),
        rica: $("#rica_mod").val(),
        estado: $("#estado_mod").val(),
        id: $("#id").val()
    };

    if (codigo == "" || suc == "" || zona == "" || subzona == "" || nombre == "" || dir == "" ||
        tel1 == "" || tel2 == "" || ciudad == "" || cupo == "" || legal == "" || fecha_ini == "" ||
        fpago == "" || correo == "" || caract_dev == "" || digito == "" || riva == "" || rfte == "" ||
        rica == "" || estado == "") {
        // alert("Por favor, completa todos los campos.");
        notificacion('Error', 'error', "Por favor, completa todos los campos.");
        return;
    } else {

        // Hacer la solicitud AJAX para guardar la nuevo proveedor
        $.ajax({
            type: 'POST',
            url: 'ajax/proveedoresajax.php',
            data: {
                proceso: 'modificar',
                codigo: nuevoproveedor.codigo,
                suc: nuevoproveedor.suc,
                zona: nuevoproveedor.zona,
                subzona: nuevoproveedor.subzona,
                nombre: nuevoproveedor.nombre,
                dir: nuevoproveedor.dir,
                tel1: nuevoproveedor.tel1,
                tel2: nuevoproveedor.tel2,
                ciudad: nuevoproveedor.ciudad,
                cupo: nuevoproveedor.cupo,
                legal: nuevoproveedor.legal,
                fecha_ini: nuevoproveedor.fecha_ini,
                fpago: nuevoproveedor.fpago,
                correo: nuevoproveedor.correo,
                caract_dev: nuevoproveedor.caract_dev,
                digito: nuevoproveedor.digito,
                riva: nuevoproveedor.riva,
                rfte: nuevoproveedor.rfte,
                rica: nuevoproveedor.rica,
                estado: nuevoproveedor.estado,
                id: nuevoproveedor.id
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // cerramos el modal
                    $('#editarModal').modal('hide');
                    // limpiamos el formulario
                    $('#fmr_proveedores_editar')[0].reset();
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
        text: '¿Seguro que deseas eliminar la proveedor?',
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
                url: 'ajax/proveedoresajax.php',
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
        confirmButtonproveedor: color
    });
}

function generar() {
    // Abre la URL del archivo PDF en una nueva pestaña
    window.open('pdfs/generar_pdf_proveedores.php', '_blank');

}