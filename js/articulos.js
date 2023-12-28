$(document).ready(function() {
    cargar_tabla()
});

// consultar
function cargar_tabla() {
    // Hacer la solicitud AJAX al servidor
    var urlprocess = 'ajax/articulosajax.php';
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
                        '<td class="homol">' + item.homol + '</td>' +
                        '<td class="nombre">' + item.nombre + '</td>' +
                        '<td class="clase">' + item.clase + '</td>' +
                        '<td class="grupo">' + item.grupo + '</td>' +
                        '<td class="referencia">' + item.referencia + '</td>' +
                        '<td class="umedida">' + item.umedida + '</td>' +
                        '<td class="stmin">' + item.stmin + '</td>' +
                        '<td class="stmax">' + item.stmax + '</td>' +
                        '<td class="ctostan">' + item.ctostan + '</td>' +
                        '<td class="ctoult">' + item.ctoult + '</td>' +
                        '<td class="fecult">' + item.fecult + '</td>' +
                        '<td class="nal">' + item.nal + '</td>' +
                        '<td class="pv1">' + item.pv1 + '</td>' +
                        '<td class="pv2">' + item.pv2 + '</td>' +
                        '<td class="pv3">' + item.pv3 + '</td>' +
                        '<td class="ubicacion">' + item.ubicacion + '</td>' +
                        '<td class="uxemp">' + item.uxemp + '</td>' +
                        '<td class="peso">' + item.peso + '</td>' +
                        '<td class="iva">' + item.iva + '</td>' +
                        '<td class="impo">' + item.impo + '</td>' +
                        '<td class="flete">' + item.flete + '</td>' +
                        '<td class="estado">' + item.estado + '</td>' +
                        '<td class="canen">' + item.canen + '</td>' +
                        '<td class="valen">' + item.valen + '</td>' +
                        '<td class="pdes">' + item.pdes + '</td>' +
                        '<td class="ultpro">' + item.ultpro + '</td>' +
                        '<td class="docpro">' + item.docpro + '</td>' +
                        '<td class="text-center"><button class="btn btn-outline-primary me-1 mb-1" type="button" onclick=editar(' + item.id + ')>' +
                        '<span class="fas fa-edit me-1" data-fa-transform="shrink-3"></span></button></td>' +
                        '<td class="text-center"><button class="btn btn-outline-primary me-1 mb-1" type="button" onclick=eliminar(' + item.id + ')>' +
                        '<span class="fas fa-trash ms-1" data-fa-transform="shrink-3"></span></button></td>' +
                        '</tr>'
                    );
                });

                // Inicializar List.js después de agregar datos
                var options = {
                    valueNames: ['codigo', 'homol', 'clase', 'grupo', 'nombre', 'referencia', 'umedida', 'stmin', 'stmax', 'ctostan', 'ctoult', 'fecult', 'nal', 'pv1',
                        'pv2', 'pv3', 'ubicacion', 'uxemp', 'peso', 'iva', 'impo', 'flete', 'estado', 'canen', 'valen', 'pdes', 'ultpro', 'docpro'
                    ],
                    item: '<tr><td class="codigo"></td><td class="homol"></td><td class="nombre"></td><td class="clase"></td><td class="grupo"></td>' +
                        '<td class="referencia"></td><td class="umedida"></td><td class="stmin"></td><td class="stmax"></td><td class="ctostan"></td><td class="ctoult"></td>' +
                        '<td class="fecult"></td><td class="nal"></td><td class="pv1"></td><td class="pv2"></td><td class="pv3"></td><td class="ubicacion"></td>' +
                        '<td class="uxemp"></td><td class="peso"></td><td class="iva"></td><td class="impo"></td><td class="flete"></td>' +
                        '<td class="estado"></td><td class="canen"></td><td class="valen"></td><td class="pdes"></td><td class="ultpro"></td><td class="docpro"></td></tr>'
                };
                var userList = new List('myTable', options);

                // Actualizar la lista después de agregar los datos
                userList.update();

                // Re-inicializar la búsqueda después de la actualización de la lista
                var input = document.querySelector('.search');
                var searchList = new List('myTable', {
                    valueNames: ['codigo', 'homol', 'clase', 'grupo', 'nombre', 'referencia', 'umedida', 'stmin', 'stmax', 'ctostan', 'ctoult', 'fecult', 'nal', 'pv1',
                        'pv2', 'pv3', 'ubicacion', 'uxemp', 'peso', 'estado', 'iva', 'impo', 'flete', 'estado', 'canen', 'valen', 'pdes', 'ultpro', 'docpro'
                    ],
                    page: 5
                });
                input.addEventListener('input', function() {
                    searchList.search(input.value);
                });
            } else {
                // Mostrar un mensaje indicando que no hay articulos disponibles
                $('#myTable tbody').html('<tr><td colspan="18" class="text-center">No hay articulos disponibles</td></tr>');
            }
        },
        error: function() {
            // Error en la inserción, muestra mensaje de error con SweetAlert
            notificacion('Error', 'error', response.message);
        }
    });
}

// guardar
$(".fmr_articulos").submit(function(event) {
    event.preventDefault();

    // Supongamos que este código se ejecuta después de que se ha guardado con éxito un nuevo articulo
    var nuevoarticulo = {
        codigo: $("#codigo").val(),
        homol: $("#homol").val(),
        nombre: $("#nombre").val(),
        clase: $("#clase").val(),
        grupo: $("#grupo").val(),
        referencia: $("#referencia").val(),
        umedida: $("#umedida").val(),
        stmin: $("#stmin").val(),
        stmax: $("#stmax").val(),
        ctostan: $("#ctostan").val(),
        ctoult: $("#ctoult").val(),
        fecult: $("#fecult").val(),
        nal: $("#nal").val(),
        pv1: $("#pv1").val(),
        pv2: $("#pv2").val(),
        pv3: $("#pv3").val(),
        ubicacion: $("#ubicacion").val(),
        uxemp: $("#uxemp").val(),
        peso: $("#peso").val(),
        iva: $("#iva").val(),
        impo: $("#impo").val(),
        flete: $("#flete").val(),
        estado: $("#estado").val(),
        canen: $("#canen").val(),
        valen: $("#valen").val(),
        pdes: $("#pdes").val(),
        ultpro: $("#ultpro").val(),
        docpro: $("#docpro").val()
    };

    // Hacer la solicitud AJAX para guardar la nuevo articulo
    $.ajax({
        type: 'POST',
        url: 'ajax/articulosajax.php',
        data: {
            proceso: 'guardar',
            codigo: nuevoarticulo.codigo,
            homol: nuevoarticulo.homol,
            nombre: nuevoarticulo.nombre,
            clase: nuevoarticulo.clase,
            grupo: nuevoarticulo.grupo,
            referencia: nuevoarticulo.referencia,
            umedida: nuevoarticulo.umedida,
            stmin: nuevoarticulo.stmin,
            stmax: nuevoarticulo.stmax,
            ctostan: nuevoarticulo.ctostan,
            ctoult: nuevoarticulo.ctoult,
            fecult: nuevoarticulo.fecult,
            nal: nuevoarticulo.nal,
            pv1: nuevoarticulo.pv1,
            pv2: nuevoarticulo.pv2,
            pv3: nuevoarticulo.pv3,
            ubicacion: nuevoarticulo.ubicacion,
            uxemp: nuevoarticulo.uxemp,
            peso: nuevoarticulo.peso,
            iva: nuevoarticulo.iva,
            impo: nuevoarticulo.impo,
            flete: nuevoarticulo.flete,
            estado: nuevoarticulo.estado,
            canen: nuevoarticulo.canen,
            valen: nuevoarticulo.valen,
            pdes: nuevoarticulo.pdes,
            ultpro: nuevoarticulo.ultpro,
            docpro: nuevoarticulo.docpro
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // cerramos el modal
                $('#guardarModal').modal('hide');
                // limpiamos el formulario
                $('#fmr_articulos')[0].reset();
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

});

// editar
function editar(id) {

    // Hacer la solicitud AJAX al servidor
    var urlprocess = 'ajax/articulosajax.php';
    $.ajax({
        type: 'POST',
        url: urlprocess,
        data: 'id=' + id + '&proceso=get_id',
        dataType: 'json',
        success: function(data) {

            // Asignar un valor al input
            document.getElementById('id').value = data[0].id
            document.getElementById('codigo_mod').value = data[0].codigo
            document.getElementById('homol_mod').value = data[0].homol
            document.getElementById('nombre_mod').value = data[0].nombre
            document.getElementById('clase_mod').value = data[0].clase
            document.getElementById('grupo_mod').value = data[0].grupo
            document.getElementById('referencia_mod').value = data[0].referencia
            document.getElementById('umedida_mod').value = data[0].umedida
            document.getElementById('stmin_mod').value = data[0].stmin
            document.getElementById('stmax_mod').value = data[0].stmax
            document.getElementById('ctostan_mod').value = data[0].ctostan
            document.getElementById('ctoult_mod').value = data[0].ctoult
            document.getElementById('fecult_mod').value = data[0].fecult
            document.getElementById('nal_mod').value = data[0].nal
            document.getElementById('pv1_mod').value = data[0].pv1
            document.getElementById('pv2_mod').value = data[0].pv2
            document.getElementById('pv3_mod').value = data[0].pv3
            document.getElementById('ubicacion_mod').value = data[0].ubicacion
            document.getElementById('uxemp_mod').value = data[0].uxemp
            document.getElementById('peso_mod').value = data[0].peso
            document.getElementById('iva_mod').value = data[0].iva
            document.getElementById('impo_mod').value = data[0].impo
            document.getElementById('flete_mod').value = data[0].flete
            document.getElementById('estado_mod').value = data[0].estado
            document.getElementById('canen_mod').value = data[0].canen
            document.getElementById('valen_mod').value = data[0].valen
            document.getElementById('pdes_mod').value = data[0].pdes
            document.getElementById('ultpro_mod').value = data[0].ultpro
            document.getElementById('docpro_mod').value = data[0].docpro

            // Limpiar el cuerpo de la tabla
            $('#editarModal').modal('show'); // abrir

        },
        error: function() {
            // Error en la inserción, muestra mensaje de error con SweetAlert
            notificacion('Error', 'error', response.message);
        }
    });
}

$(".fmr_articulos_editar").submit(function(event) {
    event.preventDefault();

    // Supongamos que este código se ejecuta después de que se ha guardado con éxito una nuevo articulo
    var nuevoarticulo = {
        codigo: $("#codigo_mod").val(),
        homol: $("#homol_mod").val(),
        nombre: $("#nombre_mod").val(),
        clase: $("#clase_mod").val(),
        grupo: $("#grupo_mod").val(),
        referencia: $("#referencia_mod").val(),
        umedida: $("#umedida_mod").val(),
        stmin: $("#stmin_mod").val(),
        stmax: $("#stmax_mod").val(),
        ctostan: $("#ctostan_mod").val(),
        ctoult: $("#ctoult_mod").val(),
        fecult: $("#fecult_mod").val(),
        nal: $("#nal_mod").val(),
        pv1: $("#pv1_mod").val(),
        pv2: $("#pv2_mod").val(),
        pv3: $("#pv3_mod").val(),
        ubicacion: $("#ubicacion_mod").val(),
        uxemp: $("#uxemp_mod").val(),
        peso: $("#peso_mod").val(),
        iva: $("#iva_mod").val(),
        impo: $("#impo_mod").val(),
        flete: $("#flete_mod").val(),
        estado: $("#estado_mod").val(),
        canen: $("#canen_mod").val(),
        valen: $("#valen_mod").val(),
        pdes: $("#pdes_mod").val(),
        ultpro: $("#ultpro_mod").val(),
        docpro: $("#docpro_mod").val(),
        id: $("#id").val()
    };

    // Hacer la solicitud AJAX para guardar la nuevo articulo
    $.ajax({
        type: 'POST',
        url: 'ajax/articulosajax.php',
        data: {
            proceso: 'modificar',
            codigo: nuevoarticulo.codigo,
            homol: nuevoarticulo.homol,
            clase: nuevoarticulo.clase,
            grupo: nuevoarticulo.grupo,
            nombre: nuevoarticulo.nombre,
            referencia: nuevoarticulo.referencia,
            umedida: nuevoarticulo.umedida,
            stmin: nuevoarticulo.stmin,
            stmax: nuevoarticulo.stmax,
            ctostan: nuevoarticulo.ctostan,
            ctoult: nuevoarticulo.ctoult,
            fecult: nuevoarticulo.fecult,
            nal: nuevoarticulo.nal,
            pv1: nuevoarticulo.pv1,
            pv2: nuevoarticulo.pv2,
            pv3: nuevoarticulo.pv3,
            ubicacion: nuevoarticulo.ubicacion,
            uxemp: nuevoarticulo.uxemp,
            peso: nuevoarticulo.peso,
            iva: nuevoarticulo.iva,
            impo: nuevoarticulo.impo,
            flete: nuevoarticulo.flete,
            estado: nuevoarticulo.estado,
            canen: nuevoarticulo.canen,
            valen: nuevoarticulo.valen,
            pdes: nuevoarticulo.pdes,
            ultpro: nuevoarticulo.ultpro,
            docpro: nuevoarticulo.docpro,
            id: nuevoarticulo.id
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // cerramos el modal
                $('#editarModal').modal('hide');
                // limpiamos el formulario
                $('#fmr_articulos_editar')[0].reset();
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

});

// eliminar
function eliminar(id) {

    // Utiliza SweetAlert para confirmar la eliminación
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Seguro que deseas eliminar la articulo?',
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
                url: 'ajax/articulosajax.php',
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
        confirmButtonarticulo: color
    });
}