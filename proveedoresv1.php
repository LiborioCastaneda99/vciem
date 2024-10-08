﻿<?php
session_start();

// llamamos zona para validarPerfil
require_once('modelo/validar_perfil.php');
$vp = new validarPerfil();

$usuario_id = $_SESSION['user_id'];
if (!isset($usuario_id)) {
    header('Location: login.php');
}

$permisoRequerido = "ver_proveedores";
// Verificar si el usuario tiene el permiso requerido
if (!$vp->tienePermiso($usuario_id, $permisoRequerido)) {
    // Mostrar un mensaje de error o redirigir a otra página
    header('Location: index.php');
}

?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Visual Ciem | Proveedores</title>

    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <?php require_once("head.php"); ?>
    <script>
        var isRTL = JSON.parse(localStorage.getItem('isRTL'));
        if (isRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
        }
    </script>
</head>

<body>
    <!-- ===============================================-->
    <!--   Contenido-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container" data-layout="container">
            <!-- navbar -->
            <?php require_once("nav.php"); ?>

            <div class="content">
                <!-- menu -->
                <?php require_once("menu.php"); ?>

                <!-- Llenar tabla -->
                <div class="card mb-3">
                    <div class="card-header bg-body-tertiary">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0">Proveedores</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-3">
                        <div class="tab-content">
                            <div class="tab-pane preview-tab-pane active" role="tabpanel" aria-labelledby="-" id>
                                <div class="table-responsive scrollbar">
                                    <table id="tabla" class="table table-striped mb-0 data-table fs-10" data-datatables="data-datatables" style="width: 100%;">
                                        <thead class="bg-200">
                                            <tr>
                                                <th class="text-900 sort">Código</th>
                                                <th class="text-900 sort">Sucursal</th>
                                                <th class="text-900 sort">Nombre</th>
                                                <th class="text-900 sort">Zona</th>
                                                <th class="text-900 sort">Subzona</th>
                                                <th class="text-900 sort">Dirección</th>
                                                <th class="text-900 sort">Teléfono 1</th>
                                                <th class="text-900 sort">Teléfono 2</th>
                                                <th class="text-900 text-center">Editar</th>
                                                <th class="text-900 text-center">Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- modal registro -->
                <div class="modal fade" id="guardarModal" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl mt-6" role="document">
                        <div class="modal-content border-0">
                            <div class="position-absolute top-0 end-0 mt-3 me-3 z-1"><button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button></div>
                            <div class="modal-body p-0">
                                <div class="rounded-top-3 bg-body-tertiary py-3 ps-4 pe-6">
                                    <h4 class="mb-1" id="staticBackdropLabel">Registro de proveedores
                                    </h4>

                                </div>
                                <div class="p-3">
                                    <div class="col-lg-6 col-xl-12 col-xxl-6 h-100">

                                        <div class="card theme-wizard h-100 mb-5">
                                            <div class="card-header bg-body-tertiary pt-3 pb-2">
                                                <ul class="nav justify-content-between nav-wizard">
                                                    <li class="nav-item">
                                                        <!-- definimos las opciones de llenado de proveedores -->
                                                        <a id="abrir" class="nav-link active fw-semi-bold" href="#bootstrap-wizard-validation-tab1" data-bs-toggle="tab" data-wizard-step="1">
                                                            <span class="nav-item-circle-parent">
                                                                <span class="nav-item-circle">
                                                                    <span class="fas fa-lock"></span>
                                                                </span>
                                                            </span>
                                                            <span class="d-none d-md-block mt-1 fs-10">
                                                                Información Basica
                                                            </span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link fw-semi-bold" href="#bootstrap-wizard-validation-tab2" data-bs-toggle="tab" data-wizard-step="2">
                                                            <span class="nav-item-circle-parent">
                                                                <span class="nav-item-circle">
                                                                    <span class="fas fa-user"></span>
                                                                </span>
                                                            </span>
                                                            <span class="d-none d-md-block mt-1 fs-10">
                                                                Información comercial
                                                            </span>
                                                        </a>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a class="nav-link fw-semi-bold" href="#bootstrap-wizard-validation-tab4" data-bs-toggle="tab" data-wizard-step="4">
                                                            <span class="nav-item-circle-parent">
                                                                <span class="nav-item-circle">
                                                                    <span class="fas fa-thumbs-up"></span>
                                                                </span>
                                                            </span>
                                                            <span class="d-none d-md-block mt-1 fs-10">
                                                                Finalizado
                                                            </span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="card-body py-4" id="wizard-controller">
                                                <div class="tab-content">
                                                    <div class="tab-pane active px-sm-3 px-md-5" role="tabpanel" aria-labelledby="bootstrap-wizard-validation-tab1" id="bootstrap-wizard-validation-tab1">
                                                        <form id="fmr_proveedores1" class="fmr_proveedores needs-validation" novalidate="novalidate" data-wizard-form="1">
                                                            <div class="row">
                                                                <input type="hidden" value="1" name="id_pestana1" id="id_pestana1">
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-codigo">Código</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-codigo" name="codigo" type="number" onchange="obtenerDocumento(this.value)" required>
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-lstSucursal">Sucursal</label>
                                                                    <div class="form-group col-md-12 mb-2">
                                                                        <select class="form-select" id="lstSucursal" size="1" name="lstSucursal" required="required">
                                                                        </select>
                                                                        <span class="input-group-addon"><button class="btn btn-outline-primary icon-search4 Search" type="button" id="btn" name="btn" style="width: 15%;"><span class="fas fa-search search-box-icon"></span></button></span>
                                                                        <div class="valid-feedback">¡Ok!</div>
                                                                        <div class="invalid-feedback">Por favor, seleccione uno</div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-5">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-nombre">Nombre</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-nombre" name="nombre" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-zona">Zona</label> <br>
                                                                    <div class="form-group col-md-12 mb-2">
                                                                        <select class="form-select" id="lstZonas" size="1" name="lstZonas" required onchange="cargar_select(this.value)">
                                                                        </select>
                                                                        <span class="input-group-addon"><button class="btn btn-outline-primary icon-search4 Search" type="button" id="btn" name="btn" style="width: 15%;"><span class="fas fa-search search-box-icon"></span></button></span>
                                                                        <div class="valid-feedback">¡Ok!</div>
                                                                        <div class="invalid-feedback">Por favor, seleccione uno</div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-subzona">Subzona</label>
                                                                    <div class="form-group col-md-12 mb-2">
                                                                        <select class="form-select" id="lstSubzonas" size="1" name="lstSubzonas" required>
                                                                        </select>
                                                                        <span class="input-group-addon"><button class="btn btn-outline-primary icon-search4 Search" type="button" id="btn" name="btn" style="width: 15%;"><span class="fas fa-search search-box-icon"></span></button></span>
                                                                        <div class="valid-feedback">¡Ok!</div>
                                                                        <div class="invalid-feedback">Por favor, seleccione uno</div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-direccion">Dirección</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-direccion" name="direccion" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-correo">Correo</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-correo" name="correo" type="email" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-tel1">Teléfono 1</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-tel1" name="tel1" type="number" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-tel2">Teléfono 2</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-tel2" name="tel2" type="number" />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel" aria-labelledby="bootstrap-wizard-validation-tab2" id="bootstrap-wizard-validation-tab2">
                                                        <form id="fmr_proveedores2" class="fmr_proveedores needs-validation" novalidate="novalidate" data-wizard-form="2">
                                                            <div class="row">
                                                                <input type="hidden" value="1" name="id_pestana2" id="id_pestana2">

                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-legal">Representante legal</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-legal" name="legal" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-cupo">Cupo crédito</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-cupo" name="cupo" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="fecha_ini">Fecha de ingreso</label>
                                                                    <input class="form-control" id="fecha_ini" name="fecha_ini" type="date" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="">Forma de pago</label>
                                                                    <div class="form-group col-md-12 mb-2">
                                                                        <input class="form-control" id="bootstrap-wizard-validation-wizard-forma_pago" name="forma_pago" type="number" required />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-caract_dev">Caract. Devolución</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-caract_dev" name="caract_dev" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-digito">Dígito</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-digito" name="digito" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label>Rete IVA</label>
                                                                    <div class="form-group col-md-12 mb-2">
                                                                        <select class="form-select" id="riva" size="1" name="riva" required>
                                                                            <option value="" selected disabled>Seleccione...</option>
                                                                            <option value="N">No</option>
                                                                            <option value="S">Si</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label>Rete Fuente</label>
                                                                    <div class="form-group col-md-12 mb-2">
                                                                        <select class="form-select" id="rfte" size="1" name="rfte" required>
                                                                            <option value="" selected disabled>Seleccione...</option>
                                                                            <option value="N">No</option>
                                                                            <option value="S">Si</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label>Rete ICA</label>
                                                                    <div class="form-group col-md-12 mb-2">
                                                                        <select class="form-select" id="rica" size="1" name="rica" required>
                                                                            <option value="" selected disabled>Seleccione...</option>
                                                                            <option value="N">No</option>
                                                                            <option value="S">Si</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-estado">Estado</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-estado" name="estado" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>

                                                    <div class="tab-pane text-center px-sm-3 px-md-5" role="tabpanel" aria-labelledby="bootstrap-wizard-validation-tab4" id="bootstrap-wizard-validation-tab4">
                                                        <div class="wizard-lottie-wrapper">

                                                        </div>
                                                        <h4 id="resp_titulo" class="mb-1">{resp_titulo}</h4>
                                                        <p id="resp_mensaje">{resp_mensaje}</p><a class="btn btn-primary px-5 my-3" href="#" onclick="cerrar_modal('guardarModal')">Cerrar</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer mt-4 bg-body-tertiary">
                                                <div class="px-sm-3 px-md-5">
                                                    <ul class="pager wizard list-inline mb-0">
                                                        <li class="previous">
                                                            <button class="btn btn-link ps-0" type="button"><span class="fas fa-chevron-left me-2" data-fa-transform="shrink-3"></span>Atrás</button>
                                                        </li>
                                                        <li class="next">
                                                            <button class="btn btn-primary px-5 px-sm-6" disabled type="submit" name="btnSiguiente" id="btnSiguiente">Siguiente<span class="fas fa-chevron-right ms-2" data-fa-transform="shrink-3"></span></button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- modal editar -->
                <div class="modal fade" id="editarModal" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl mt-6" role="document">
                        <div class="modal-content border-0">
                            <div class="position-absolute top-0 end-0 mt-3 me-3 z-1"><button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button></div>
                            <div class="modal-body p-0">
                                <div class="rounded-top-3 bg-body-tertiary py-3 ps-4 pe-6">
                                    <h4 class="mb-1" id="staticBackdropLabel">Editar proveedores
                                    </h4>

                                </div>
                                <div class="p-3">
                                    <div class="col-lg-6 col-xl-12 col-xxl-6 h-100">

                                        <div class="card theme-wizard h-100 mb-5">
                                            <div class="card-header bg-body-tertiary pt-3 pb-2">
                                                <ul class="nav justify-content-between nav-wizard">
                                                    <li class="nav-item">
                                                        <!-- definimos las opciones de llenado de proveedores -->
                                                        <a id="abrir" class="nav-link active fw-semi-bold" href="#bootstrap-wizard-validation-tab1-mod" data-bs-toggle="tab" data-wizard-step="1">
                                                            <span class="nav-item-circle-parent">
                                                                <span class="nav-item-circle">
                                                                    <span class="fas fa-lock"></span>
                                                                </span>
                                                            </span>
                                                            <span class="d-none d-md-block mt-1 fs-10">
                                                                Información Basica
                                                            </span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link fw-semi-bold" href="#bootstrap-wizard-validation-tab2-mod" data-bs-toggle="tab" data-wizard-step="2">
                                                            <span class="nav-item-circle-parent">
                                                                <span class="nav-item-circle">
                                                                    <span class="fas fa-user"></span>
                                                                </span>
                                                            </span>
                                                            <span class="d-none d-md-block mt-1 fs-10">
                                                                Información comercial
                                                            </span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link fw-semi-bold" href="#bootstrap-wizard-validation-tab3-mod" data-bs-toggle="tab" data-wizard-step="3">
                                                            <span class="nav-item-circle-parent">
                                                                <span class="nav-item-circle">
                                                                    <span class="fas fa-thumbs-up"></span>
                                                                </span>
                                                            </span>
                                                            <span class="d-none d-md-block mt-1 fs-10">
                                                                Finalizado
                                                            </span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="card-body py-4" id="wizard-controller">
                                                <div class="tab-content">
                                                    <div class="tab-pane active px-sm-3 px-md-5" role="tabpanel" aria-labelledby="bootstrap-wizard-validation-tab1-mod" id="bootstrap-wizard-validation-tab1-mod">
                                                        <form id="fmr_proveedores1_mod" class="fmr_proveedores_mod needs-validation" novalidate="novalidate" data-wizard-form="1">
                                                            <div class="row">
                                                                <input type="hidden" value="1" name="id_pestana1" id="id_pestana1">
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-codigo">Código</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-codigo" name="codigo_mod" type="number" onchange="obtenerDocumento(this.value)" required readonly>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-id" name="id" type="hidden" required>
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-lstSucursal">Sucursal</label>
                                                                    <select class="form-control" id="lstSucursal_mod" size="1" name="lstSucursal_mod" required="required">
                                                                    </select>
                                                                    <span class="input-group-addon"><button class="btn btn-outline-primary icon-search4 Search" type="button" id="btnBusquedaSucursalMod" name="btnBusquedaSucursalMod" style="width: 15%;"><span class="fas fa-search search-box-icon"></span></button></span>
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                    <div class="invalid-feedback">Por favor, seleccione uno</div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-nombre">Nombre</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-nombre" name="nombre_mod" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-zona">Zona</label> <br>
                                                                    <select class="" id="lstZonas_mod" size="1" name="lstZonas_mod" required onchange="cargar_select_mod(this.value)">
                                                                    </select>
                                                                    <span class="input-group-addon"><button class="btn btn-outline-primary icon-search4 Search" type="button" id="btnBusquedaZonaMod" name="btnBusquedaZonaMod" style="width: 15%;"><span class="fas fa-search search-box-icon"></span></button></span>
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                    <div class="invalid-feedback">Por favor, seleccione uno</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-subzona">Subzona</label>
                                                                    <select class="" id="lstSubzonas_mod" size="1" name="lstSubzonas_mod" required>
                                                                    </select>
                                                                    <span class="input-group-addon"><button class="btn btn-outline-primary icon-search4 Search" type="button" id="btnBusquedaSubzonaMod" name="btnBusquedaSubzonaMod" style="width: 15%;"><span class="fas fa-search search-box-icon"></span></button></span>
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                    <div class="invalid-feedback">Por favor, seleccione uno</div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-direccion">Dirección</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-direccion" name="direccion_mod" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-correo">Correo</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-correo" name="correo_mod" type="email" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-tel1">Teléfono 1</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-tel1" name="tel1_mod" type="number" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-tel2">Teléfono 2</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-tel2" name="tel2_mod" type="number" />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel" aria-labelledby="bootstrap-wizard-validation-tab2-mod" id="bootstrap-wizard-validation-tab2-mod">
                                                        <form id="fmr_proveedores2_mod" class="fmr_proveedores_mod needs-validation" novalidate="novalidate" data-wizard-form="2">
                                                            <div class="row">
                                                                <input type="hidden" value="1" name="id_pestana2" id="id_pestana2">

                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-legal">Representante legal</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-legal" name="legal_mod" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-cupo">Cupo crédito</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-cupo" name="cupo_mod" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-fecha_ini_mod">Fecha de ingreso</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-fecha_ini_mod" name="fecha_ini_mod" type="date" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-forma_pago">Forma pago</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-forma_pago" name="forma_pago_mod" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-caract_dev">Caract. Devolución</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-caract_dev" name="caract_dev_mod" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-digito">Dígito</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-digito" name="digito_mod" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-riva">Rete IVA</label>
                                                                    <select class="form-select" id="riva_mod" size="1" name="riva_mod" required>
                                                                        <option value="" selected disabled>Seleccione...</option>
                                                                        <option value="N">No</option>
                                                                        <option value="S">Si</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-rfte">Rete Fuente</label>
                                                                    <select class="form-select" id="rfte_mod" size="1" name="rfte_mod" required>
                                                                        <option value="" selected disabled>Seleccione...</option>
                                                                        <option value="N">No</option>
                                                                        <option value="S">Si</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-rica">Rete ICA</label>
                                                                    <select class="form-select" id="rica_mod" size="1" name="rica_mod" required>
                                                                        <option value="" selected disabled>Seleccione...</option>
                                                                        <option value="N">No</option>
                                                                        <option value="S">Si</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-estado">Estado</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-estado" name="estado_mod" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    
                                                    <div class="tab-pane text-center px-sm-3 px-md-5" role="tabpanel" aria-labelledby="bootstrap-wizard-validation-tab3-mod" id="bootstrap-wizard-validation-tab3-mod">
                                                        <div class="wizard-lottie-wrapper">

                                                        </div>
                                                        <h4 id="resp_titulo_mod" class="mb-1">{resp_titulo}</h4>
                                                        <p id="resp_mensaje_mod">{resp_mensaje}</p>
                                                        <a class="btn btn-primary px-5 my-3" href="#" onclick="cerrar_modal('editarModal')">Cerrar</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer mt-4 bg-body-tertiary">
                                                <div class="px-sm-3 px-md-5">
                                                    <ul class="pager wizard list-inline mb-0">
                                                        <li class="previous">
                                                            <button class="btn btn-link ps-0" type="button"><span class="fas fa-chevron-left me-2" data-fa-transform="shrink-3"></span>Atrás</button>
                                                        </li>
                                                        <li class="next">
                                                            <button class="btn btn-primary px-5 px-sm-6" type="submit" name="btnSiguienteMod" id="btnSiguienteMod">Siguiente<span class="fas fa-chevron-right ms-2" data-fa-transform="shrink-3"></span></button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pie de pagina -->
                <?php require_once("footer.php"); ?>
            </div>
        </div>
    </main>
    <!-- ===============================================-->
    <!--    End ofContenido-->
    <!-- ===============================================-->

    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <?php require_once("script.php"); ?>
    <script src="js/proveedoresv1.js"></script>
</body>

</html>