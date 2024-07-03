$(document).ready(function () {
    cargar_tabla();
    longitudCampo("#bootstrap-wizard-validation-wizard-forma_pago", 3);
    longitudCampo("#bootstrap-wizard-validation-wizard-tel1", 10);
    longitudCampo("#bootstrap-wizard-validation-wizard-tel2", 10);
});


function longitudCampo(campo, max) {
    var input = $(campo)

    var maxLength = max;

    input.on('input', function () {
        if ($(this).val().length > maxLength) {
            $(this).val($(this).val().slice(0, maxLength));
        }
    });
}

//consultar
function cargar_tabla() {
    $("#tabla").dataTable().fnDestroy();
    $("#tabla").DataTable({
        responsive: true,
        dom: "lBfrtip",
        buttons: [
            {
                className: "btn btn-falcon-default btn-sm mx-2",
                text:
                    '<span class="fas fa-plus" data-fa-transform="shrink-3"></span> ' +
                    "Agregar ",
                action: function () {
                    abrirModal();
                },
            },
            {
                extend: "collection",
                init: (api, node, config) => $(node).removeClass("btn-secondary"),
                className: "btn btn-falcon-default btn-sm mx-2",
                text:
                    '<span class="fas fa-file-export" data-fa-transform="shrink-3"></span> ' +
                    "Exportar",
                buttons: [
                    {
                        extend: "csvHtml5",
                        titleAttr: "Csv",
                        className: "btn btn-falcon-default btn-sm mx-2",
                        text:
                            '<span class="fas fa-file-csv" data-fa-transform="shrink-3"></span> ' +
                            "Exportar a CSV ",
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7],
                        },
                    },
                    {
                        extend: "excelHtml5",
                        className: "btn btn-falcon-default btn-sm mx-2",
                        text:
                            '<span class="fas fa-file-csv" data-fa-transform="shrink-3"></span> ' +
                            "Exportar a Excel ",
                        titleAttr: "Csv",
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7],
                        },
                    },
                    {
                        extend: "pdfHtml5",
                        text:
                            '<span class="fas fa-file-pdf" data-fa-transform="shrink-3"></span> ' +
                            "Exportar a PDF ",
                        className: "btn btn-falcon-default btn-sm mx-2",
                        titleAttr: "Csv",
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7],
                        },
                    },
                ],
            },
            {
                extend: "print",
                init: (api, node, config) => $(node).removeClass("btn-secondary"),
                className: "btn btn-falcon-default btn-sm mx-2",
                text:
                    '<span class="fas fa-print" data-fa-transform="shrink-3"></span> ' +
                    "Imprimir ",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                },
            },
        ],
        columnDefs: [
            {
                // El numero correspode a la ultima columna iniciando en 0
                targets: [8, 9],
                orderable: false,
                width: "70px",
                className: "text-center",
            },
            {
                // El numero correspode a la ultima columna iniciando en 0
                targets: [0],
                width: "120px",
            },
        ],
        language: {
            url: "vendors/datatables.net/spanish.txt",
        },
        lengthMenu: [10, 25, 50, 75, 100, 500, 1000],
        lengthChange: true,
        order: [[0, "desc"]],
        processing: true,
        serverSide: true,
        serverMethod: "post",
        ajax: {
            url: "ajax/proveedoresajaxv1.php",
            data: {
                proceso: "get",
            },
            method: "POST",
        },
        columns: [
            {
                data: "codigo",
            },
            {
                data: "sucursal",
            },
            {
                data: "nombre",
            },
            {
                data: "zona",
            },
            {
                data: "subzona",
            },
            {
                data: "direccion",
            },
            {
                data: "tel1",
            },
            {
                data: "tel2",
            },
            {
                data: "editar",
            },
            {
                data: "eliminar",
            },
        ],
        drawCallback: function () {
            $(".btn-group").addClass("btn-group-sm");
        },
    });
}

//consultar documento
function obtenerDocumento(codigo) {
    var urlprocess = "ajax/proveedoresajaxv1.php";
    var btnSiguiente = document.getElementById("btnSiguiente");

    $.ajax({
        type: "POST",
        url: urlprocess,
        data: { proceso: "get_cod", codigo: codigo },
        dataType: "json",
        success: function (data) {
            if (data.status == "Error") {
                notificacion("Error", "error", data.mensaje);
                btnSiguiente.disabled = true;
            } else {
                btnSiguiente.disabled = false;
            }
        },
        error: function (error) {
            notificacion("Error", "error", error);
        },
    });
}

// Función para obtener los datos de un formulario
function obtenerDatosFormulario(formulario) {
    var elementos = formulario.elements;
    var datos = {};

    for (var i = 0; i < elementos.length; i++) {
        var elemento = elementos[i];
        if (
            elemento.tagName === "INPUT" ||
            elemento.tagName === "SELECT" ||
            elemento.tagName === "TEXTAREA"
        ) {
            datos[elemento.name] = elemento.value;
        }
    }

    return datos;
}

// Función para obtener los datos de todos los formularios
function obtenerDatosFormularios(frm1, frm2) {
    var datos = {};

    // Obtener datos del formulario 1
    var formulario1 = document.getElementById(frm1);
    datos[frm1] = obtenerDatosFormulario(formulario1);

    // Obtener datos del formulario 2
    var formulario2 = document.getElementById(frm2);
    datos[frm2] = obtenerDatosFormulario(formulario2);


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
                    if (formulario === "fmr_proveedores1" && (campo === "tel2" || campo === "tel2_mod")) {
                        if (!datosFormulario[campo]) {
                            datos_formateados[campo] = "";
                        } else {
                            datos_formateados[campo] = datosFormulario[campo];
                        }
                        continue;
                    }

                    // Excluir campo tel2 del formulario 1 de la validación
                    if (formulario === "fmr_proveedores2" && (campo === "estado" || campo === "estado_mod")) {
                        if (!datosFormulario[campo]) {
                            datos_formateados[campo] = "";
                        } else {
                            datos_formateados[campo] = datosFormulario[campo];
                        }
                        continue;
                    }

                    if (!datosFormulario[campo]) {
                        console.log(
                            "El formulario " + formulario + " tiene un campo vacío: " + campo
                        );
                        return false;
                    }
                    datos_formateados[campo] = datosFormulario[campo];
                }
            }
        }
    }
    return { valido: true, datos: datos_formateados };
}

// Agregar evento al botón "Guardar"
var btnSiguiente = document.getElementById("btnSiguiente");
btnSiguiente.addEventListener("click", function () {
    var datosFormularios = obtenerDatosFormularios(
        "fmr_proveedores1",
        "fmr_proveedores2"
    );
    var resultadoValidacion = validarFormularios(datosFormularios);

    if (resultadoValidacion.valido) {
        var datos_formulario_json = resultadoValidacion.datos;
        datos_formulario_json["proceso"] = "guardar";

        // Hacer la solicitud AJAX para guardar la nuevo proveedor
        $.ajax({
            type: "POST",
            url: "ajax/proveedoresajaxv1.php",
            data: datos_formulario_json,
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    // limpiamos el formulario
                    $(".fmr_proveedores")[0].reset();

                    // Selecciona el elemento por su ID
                    var resp_titulo = document.getElementById("resp_titulo");
                    var resp_mensaje = document.getElementById("resp_mensaje");

                    // Actualiza el contenido del elemento con el valor
                    resp_titulo.innerHTML = "Éxito";
                    resp_mensaje.innerHTML = response.message;

                    cargar_tabla();
                } else {
                    // Error en la inserción, muestra mensaje de error con SweetAlert
                    notificacion("Error", "error", response.message);
                }
            },
            error: function () {
                // Error en la inserción, muestra mensaje de error con SweetAlert
                notificacion("Error", "error", response.message);
            },
        });

        // Aquí puedes enviar los datos a través de Ajax o realizar otras acciones.
    } else {
        console.log("Al menos un formulario tiene campos vacíos.");
    }
});

// Agregar evento al botón "Modificar"
var btnSiguienteMod = document.getElementById("btnSiguienteMod");
btnSiguienteMod.addEventListener("click", function () {
    var datosFormularios = obtenerDatosFormularios(
        "fmr_proveedores1_mod",
        "fmr_proveedores2_mod"
    );
    var resultadoValidacion = validarFormularios(datosFormularios);

    if (resultadoValidacion.valido) {
        console.log("Todos los formularios tienen valores válidos.");
        console.table(resultadoValidacion.datos);
        var datos_formulario_json = resultadoValidacion.datos;
        datos_formulario_json["proceso"] = "modificar";

        // Hacer la solicitud AJAX para modificar la nuevo proveedor
        $.ajax({
            type: "POST",
            url: "ajax/proveedoresajaxv1.php",
            data: datos_formulario_json,
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    // limpiamos el formulario
                    $(".fmr_proveedores_mod")[0].reset();

                    // Selecciona el elemento por su ID
                    var resp_titulo = document.getElementById("resp_titulo_mod");
                    var resp_mensaje = document.getElementById("resp_mensaje_mod");

                    // Actualiza el contenido del elemento con el valor
                    resp_titulo.innerHTML = "Éxito";
                    resp_mensaje.innerHTML = response.message;

                    cargar_tabla();
                } else {
                    // Error en la inserción, muestra mensaje de error con SweetAlert
                    notificacion("Error", "error", response.message);
                }
            },
            error: function () {
                // Error en la inserción, muestra mensaje de error con SweetAlert
                notificacion("Error", "error", response.message);
            },
        });

        // Aquí puedes enviar los datos a través de Ajax o realizar otras acciones.
    } else {
        console.log("Al menos un formulario tiene campos vacíos.");
    }
});

// funcion para crear la notificacion
function notificacion(titulo, icon, mensaje) {
    //Mensaje de notificación, muestra un mensaje con SweetAlert
    if (titulo == "Error") {
        color = "#EF5350";
    } else {
        color = "#2196f3";
    }
    Swal.fire({
        title: titulo,
        text: mensaje,
        icon: icon,
        confirmButtonproveedor: color,
    });
}

// funcion para generar el pdf
function generar() {
    // Abre la URL del archivo PDF en una nueva pestaña
    window.open("pdfs/generar_pdf_proveedores.php", "_blank");
}
// Función para cerrar el modal
function cerrar_modal(modal) {
    $("#" + modal).modal("hide");
    window.location.href = 'proveedoresv1.php';
}

$("#btnBusquedaSucursalMod").click(function () {
    cargar_oficinas("", "lstSucursal_mod", "editarModal");
});

$("#btnBusquedaZonaMod").click(function () {
    cargar_departamentos("", "lstZonas_mod", "editarModal");
});

function cargar_select_mod(id) {
    cargar_ciudades(id, "lstSubzonas_mod", "editarModal", "combo_ciudades_all");
  }

function abrirModal() {

    // Limpiar los campos del modal
    document.getElementById("fmr_proveedores1").reset();
    document.getElementById("fmr_proveedores2").reset();

    // Restablecer el estado de cualquier otro elemento si es necesario
    document.getElementById("abrir").click(); // Hacer clic en la primera pestaña para restablecerla como activa

    // Cerrar el modal si está abierto
    $("#guardarModal").modal("hide");

    $("#guardarModal").modal("show");
    // document.getElementById('abrir').click();
    cargar_oficinas("", "lstSucursal", "guardarModal");
    cargar_departamentos("", "lstZonas", "guardarModal");
    cargar_ciudades("", "lstSubzonas", "guardarModal")

    let fechaActual = new Date();
    var dia = fechaActual.getDate();
    var mes = fechaActual.getMonth() + 1;
    var anio = fechaActual.getFullYear();

    let fechaFormateada =
        anio +
        "-" +
        (mes < 10 ? "0" : "") +
        mes +
        "-" +
        (dia < 10 ? "0" : "") +
        dia;

    $("#fecha_ini").val(fechaFormateada);
}

function cargar_select(id) {
    cargar_ciudades(id, "lstSubzonas", "guardarModal", "combo_ciudades_all");
}

function cargar_departamentos(Id, nameSelect, Modal) {
    var lstRoles = $("#" + nameSelect);

    if (Id != "") {
        lstRoles.select2({
            dropdownParent: $("#" + Modal),
        });
        // var lstRoles = $lstRoles
        lstRoles.find("option").remove();
        var searchTerm = "";
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "ajax/proveedoresajaxv1.php",
            data: {
                searchTerm: searchTerm,
                proceso: "combo_departamentos",
                id: Id,
            },
        }).then(function (registros) {
            $(registros).each(function (i, v) {
                lstRoles.append(
                    '<option selected value="' + v.id + '">' + v.text + "</option>"
                );
            });
            lstRoles.trigger({
                type: "select2:select",
                params: {
                    data: registros,
                },
            });
        });
    } else {
        lstRoles.select2({
            placeholder: "Seleccione un departamento",
            dropdownParent: $("#" + Modal),
            ajax: {
                url: "ajax/proveedoresajaxv1.php",
                type: "post",
                dataType: "json",
                delay: 150,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                        proceso: "combo_departamentos",
                        id: Id,
                    };
                },
                processResults: function (response) {
                    return {
                        results: response,
                    };
                },
                cache: true,
            },
        });
    }
}

function cargar_oficinas(Id, nameSelect, Modal) {
    var lstRoles = $("#" + nameSelect);

    if (Id != "") {
        lstRoles.select2({
            dropdownParent: $("#" + Modal),
        });
        // var lstRoles = $lstRoles
        lstRoles.find("option").remove();
        var searchTerm = "";
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "ajax/ciudadesajax.php",
            data: {
                searchTerm: searchTerm,
                proceso: "combo_ciudades",
                id: Id,
            },
        }).then(function (registros) {
            $(registros).each(function (i, v) {
                lstRoles.append(
                    '<option selected value="' + v.id + '">' + v.text + "</option>"
                );
            });
            lstRoles.trigger({
                type: "select2:select",
                params: {
                    data: registros,
                },
            });
        });
    } else {
        lstRoles.select2({
            placeholder: "Seleccione una oficina",
            dropdownParent: $("#" + Modal),
            ajax: {
                url: "ajax/ciudadesajax.php",
                type: "post",
                dataType: "json",
                delay: 150,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                        proceso: "combo_ciudades",
                        id: Id,
                    };
                },
                processResults: function (response) {
                    return {
                        results: response,
                    };
                },
                cache: true,
            },
        });
    }
}
function cargar_ciudades(Id, nameSelect, Modal, Proceso) {
    var lstRoles = $("#" + nameSelect);

    if (Id != "") {
        lstRoles.select2({
            dropdownParent: $("#" + Modal),
        });
        // var lstRoles = $lstRoles
        lstRoles.find("option").remove();
        var searchTerm = "";
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "ajax/proveedoresajaxv1.php",
            data: {
                searchTerm: searchTerm,
                proceso: Proceso,
                id: Id,
            },
        }).then(function (registros) {
            $(registros).each(function (i, v) {
                lstRoles.append(
                    '<option selected value="' + v.id + '">' + v.text + "</option>"
                );
            });
            lstRoles.trigger({
                type: "select2:select",
                params: {
                    data: registros,
                },
            });
        });
    } else {
        lstRoles.select2({
            placeholder: "Seleccione una ciudad",
            dropdownParent: $("#" + Modal),
            ajax: {
                url: "ajax/proveedoresajaxv1.php",
                type: "post",
                dataType: "json",
                delay: 150,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                        proceso: "combo_ciudades",
                        id: Id,
                    };
                },
                processResults: function (response) {
                    return {
                        results: response,
                    };
                },
                cache: true,
            },
        });
    }
}

// Funcion para cargar las listas select con opcion de busqueda de vendedores
$("#btnBusquedaVendedoresFact").click(function () {
    cargar_vendedores("", "vende", "guardarModal");
});

function cargar_vendedores(Id, nameSelect, Modal) {
    var lstRoles = $("#" + nameSelect);

    if (Id != "") {
        lstRoles.select2({
            dropdownParent: $("#" + Modal),
        });
        // var lstRoles = $lstRoles
        lstRoles.find("option").remove();
        var searchTerm = "";
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "ajax/proveedoresajaxv1.php",
            data: {
                searchTerm: searchTerm,
                proceso: "combo_vendedores",
                id: Id,
            },
        }).then(function (registros) {
            $(registros).each(function (i, v) {
                lstRoles.append(
                    '<option selected value="' + v.id + '">' + v.text + "</option>"
                );
            });
            lstRoles.trigger({
                type: "select2:select",
                params: {
                    data: registros,
                },
            });
        });
    } else {
        lstRoles.select2({
            placeholder: "Seleccione un vendedor",
            dropdownParent: $("#" + Modal),
            ajax: {
                url: "ajax/proveedoresajaxv1.php",
                type: "post",
                dataType: "json",
                delay: 150,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                        proceso: "combo_vendedores",
                        id: Id,
                    };
                },
                processResults: function (response) {
                    return {
                        results: response,
                    };
                },
                cache: true,
            },
        });
    }
}

// editar
function editar(id) {
    // Hacer la solicitud AJAX al servidor
    var urlprocess = "ajax/proveedoresajaxv1.php";
    $.ajax({
        type: "POST",
        url: urlprocess,
        data: "id=" + id + "&proceso=get_id",
        dataType: "json",
        success: function (data) {

            document.getElementsByName("id")[0].value = data[0].id;
            document.getElementsByName("codigo_mod")[0].value = data[0].codigo;
            document.getElementsByName("nombre_mod")[0].value = data[0].nombre;
            document.getElementsByName("direccion_mod")[0].value = data[0].direccion;
            document.getElementsByName("correo_mod")[0].value = data[0].correo;
            document.getElementsByName("tel1_mod")[0].value = data[0].tel1;
            document.getElementsByName("tel2_mod")[0].value = data[0].tel2;

            cargar_departamentos(data[0].zona, "lstZonas_mod", "editarModal");
            cargar_oficinas(data[0].sucursal, "lstSucursal_mod", "editarModal");
            cargar_ciudades(
                data[0].subzona,
                "lstSubzonas_mod",
                "editarModal",
                "combo_ciudades_cod"
            );

            document.getElementsByName("legal_mod")[0].value = data[0].legal;
            document.getElementsByName("cupo_mod")[0].value = data[0].cupo;
            document.getElementsByName("fecha_ini_mod")[0].value = data[0].fecha_ini;
            document.getElementsByName("forma_pago_mod")[0].value = data[0].forma_pago;
            document.getElementsByName("caract_dev_mod")[0].value = data[0].caract_dev;
            document.getElementsByName("digito_mod")[0].value = data[0].digito;
            document.getElementsByName("riva_mod")[0].value = data[0].riva;
            document.getElementsByName("rfte_mod")[0].value = data[0].rfte;
            document.getElementsByName("rica_mod")[0].value = data[0].rica;
            document.getElementsByName("estado_mod")[0].value = data[0].estado;


            // Limpiar el cuerpo de la tabla
            $("#editarModal").modal("show"); // abrir
        },
        error: function () {
            // Error en la inserción, muestra mensaje de error con SweetAlert
            notificacion("Error", "error", response.message);
        },
    });
}

$(".fmr_proveedores_editar").submit(function (event) {
    event.preventDefault();
    codigo = $("#codigo_mod").val();

    // Supongamos que este código se ejecuta después de que se ha guardado con éxito una nuevo proveedor
    var nuevoproveedor = {
        codigo: $("#codigo_mod").val(),

        id: $("#id").val(),
    };
    if (
        codigo == "" || sucursal == "" || zona == "" || subzona == "" || nombre == "" ||
        correo == "" || direccion == "" || tel1 == "" || legal == "" || cupo == "" ||
        fecha_ini == "" || forma_pago == "" || caract_dev == "" || digito == "" ||
        riva == "" || rfte == "" || rica == ""
    ) {

        notificacion("Error", "error", "Por favor, completa todos los campos.");
        return;
    } else {
        // Hacer la solicitud AJAX para guardar la nuevo proveedor
        $.ajax({
            type: "POST",
            url: "ajax/proveedoresajax.php",
            data: {
                proceso: "modificar",
                codigo: nuevoproveedor.codigo,
                sucursal: nuevoproveedor.sucursal,
                nombre: nuevoproveedor.nombre,
                zona: nuevoproveedor.zona,
                subzona: nuevoproveedor.subzona,
                correo: nuevoproveedor.correo,
                direccion: nuevoproveedor.direccion,
                tel1: nuevoproveedor.tel1,
                tel2: nuevoproveedor.tel2,

                legal: nuevoproveedor.legal,
                cupo: nuevoproveedor.cupo,
                fecha_ini: nuevoproveedor.fecha_ini,
                forma_pago: nuevoproveedor.forma_pago,
                caract_dev: nuevoproveedor.caract_dev,
                digito: nuevoproveedor.digito,
                riva: nuevoproveedor.riva,
                rfte: nuevoproveedor.rfte,
                rica: nuevoproveedor.rica,
                estado: nuevoproveedor.estado,

                id: nuevoproveedor.id
            },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    // cerramos el modal
                    $("#editarModal").modal("hide");
                    // limpiamos el formulario
                    $("#fmr_proveedores_editar")[0].reset();
                    // mostramos la alerta
                    notificacion("Éxito", "success", response.message);

                    cargar_tabla();
                } else {
                    // Error en la inserción, muestra mensaje de error con SweetAlert
                    notificacion("Error", "error", response.message);
                }
            },
            error: function () {
                // Error en la inserción, muestra mensaje de error con SweetAlert
                notificacion("Error", "error", response.message);
            },
        });
    }
});

// eliminar
function eliminar(id) {
    // Utiliza SweetAlert para confirmar la eliminación
    Swal.fire({
        title: "¿Estás seguro?",
        text: "¿Seguro que deseas eliminar el proveedor?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, eliminarlo",
        cancelButtonText: "No, cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            // Realiza la solicitud de eliminación al servidor (aquí deberías hacer tu llamada AJAX)
            $.ajax({
                type: "POST",
                url: "ajax/proveedoresajax.php",
                data: {
                    proceso: "eliminar",
                    id: id,
                },
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        notificacion("Éxito", "success", response.message);

                        cargar_tabla();
                    } else {
                        // Error en la inserción, muestra mensaje de error con SweetAlert
                        notificacion("Error", "error", response.message);
                    }
                },
                error: function () {
                    notificacion("Error", "error", response.message);
                },
            });
        }
    });
}
