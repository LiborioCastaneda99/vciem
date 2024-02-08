<?php
session_start();

// llamamos zona para validarPerfil
require_once('modelo/validar_perfil.php');
$vp = new validarPerfil();

$usuario_id = $_SESSION['user_id'];
if (!isset($usuario_id)) {
    header('Location: login.php');
}

$permisoRequerido = "ver_clientes";
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
    <title>Visual Ciem | Clientes</title>

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
                                <h6 class="mb-0">Clientes</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-3">
                        <div class="tab-content">
                            <div class="tab-pane preview-tab-pane active" role="tabpanel" aria-labelledby="-" id>
                                <div id="tableExample3" data-list='{"valueNames":["codigo","subzona"],"page":5,"pagination":true}'>
                                    <div class="row justify-content-end g-0">
                                        <div class="d-flex align-items-center" id="table-contact-replace-element">
                                            <button onclick="abrir_modal()" class="btn btn-falcon-default btn-sm" type="button" id="btnAgregar" data-bs-toggle="modal">
                                                <span class="fas fa-plus" data-fa-transform="shrink-3"></span>
                                                <span class="d-none d-sm-inline-block d-xl-none d-xxl-inline-block ms-1" title="Registrar">Agregar</span>
                                            </button>
                                            <button onclick="generar()" class="btn btn-falcon-default btn-sm mx-2" type="button">
                                                <span class="fas fa-external-link-alt" data-fa-transform="shrink-3"></span>
                                                <span class="d-none d-sm-inline-block d-xl-none d-xxl-inline-block ms-1">Exportar</span>
                                            </button>
                                        </div>
                                        <div class="col-auto col-sm-5 mb-3">
                                            <form method="POST" action="#" id name>
                                                <div class="input-group"><input class="form-control form-control-sm shadow-none search" type="search" placeholder="Buscar..." aria-label="search" />
                                                    <div class="input-group-text bg-transparent"><span class="fa fa-search fs-10 text-600"></span></div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="table-responsive scrollbar">
                                        <table id="myTable" class="table table-bordered table-striped fs-10 mb-0 ">

                                            <thead class="bg-200">
                                                <tr>
                                                    <th class="text-900 sort" data-sort="codigo">Código</th>
                                                    <th class="text-900 sort" data-sort="zona">Zona</th>
                                                    <th class="text-900 sort" data-sort="subzona">Subzona</th>
                                                    <th class="text-900 sort" data-sort="nombre">Nombre</th>
                                                    <th class="text-900 sort" data-sort="direc">Direc</th>
                                                    <th class="text-900 sort" data-sort="tel1">Teléfono 1
                                                    </th>
                                                    <th class="text-900 sort" data-sort="tel2">Teléfono 2
                                                    </th>
                                                    <!-- <th class="text-900 sort" data-sort="ciudad">Ciudad</th> -->
                                                    <th class="text-900 no-sort pe-1 align-middle data-table-row-action">Editar</th>
                                                    <th class="text-900 no-sort pe-1 align-middle data-table-row-action">Eliminar</th>
                                                </tr>
                                            </thead>
                                            <tbody class="list">

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-center mt-3">
                                        <button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                                        <ul class="pagination mb-0"></ul>
                                        <button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next" data-list-pagination="next"><span class="fas fa-chevron-right">
                                            </span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- modal registro -->
                <div class="modal fade" id="guardarModal" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg mt-6" role="document">
                        <div class="modal-content border-0">
                            <div class="position-absolute top-0 end-0 mt-3 me-3 z-1"><button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button></div>
                            <div class="modal-body p-0">
                                <div class="rounded-top-3 bg-body-tertiary py-3 ps-4 pe-6">
                                    <h4 class="mb-1" id="staticBackdropLabel">Registro de clientes
                                    </h4>
                                    <!-- <p class="fs-11 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p> -->
                                </div>
                                <div class="p-3">
                                    <div class="col-lg-6 col-xl-12 col-xxl-6 h-100">

                                        <div class="card theme-wizard h-100 mb-5">
                                            <div class="card-header bg-body-tertiary pt-3 pb-2">
                                                <ul class="nav justify-content-between nav-wizard">
                                                    <li class="nav-item">
                                                        <!-- definimos las opciones de llenado de clientes -->
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
                                                        <a class="nav-link fw-semi-bold" href="#bootstrap-wizard-validation-tab3" data-bs-toggle="tab" data-wizard-step="3">
                                                            <span class="nav-item-circle-parent">
                                                                <span class="nav-item-circle">
                                                                    <span class="fas fa-dollar-sign"></span>
                                                                </span>
                                                            </span>
                                                            <span class="d-none d-md-block mt-1 fs-10">
                                                                Información facturación
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
                                                        <form id="fmr_clientes1" class="fmr_clientes needs-validation" novalidate="novalidate" data-wizard-form="1">
                                                            <div class="row">
                                                                <input type="hidden" value="1" name="id_pestana1" id="id_pestana1">
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-codigo">Código</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-codigo" name="codigo" type="number" onchange="obtenerDocumento(this.value)" required>
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-nombre">Nombre</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-nombre" name="nombre" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-lstSucursal">Sucursal</label>
                                                                    <select class="form-control" id="lstSucursal" size="1" name="lstSucursal" required="required">
                                                                    </select>
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                    <div class="invalid-feedback">Por favor, seleccione uno</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-zona">Zona</label>
                                                                    <select class="" id="lstZonas" size="1" name="lstZonas" required onchange="cargar_select(this.value)">
                                                                    </select>
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                    <div class="invalid-feedback">Por favor, seleccione uno</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-subzona">Subzona</label>
                                                                    <!-- <input class="form-control" id="bootstrap-wizard-validation-wizard-subzona" name="subzona" type="text" required /> -->
                                                                    <select class="" id="lstSubzonas" size="1" name="lstSubzonas" required>
                                                                    </select>
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                    <div class="invalid-feedback">Por favor, seleccione uno</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-direc">Dirección</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-direc" name="direc" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-correo">Correo</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-correo" name="correo" type="email" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-tel1">Teléfono 1</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-tel1" name="tel1" type="number" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-tel2">Teléfono 2</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-tel2" name="tel2" type="number" />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel" aria-labelledby="bootstrap-wizard-validation-tab2" id="bootstrap-wizard-validation-tab2">
                                                        <form id="fmr_clientes2" class="fmr_clientes needs-validation" novalidate="novalidate" data-wizard-form="2">
                                                            <div class="row">
                                                                <input type="hidden" value="1" name="id_pestana2" id="id_pestana2">

                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-vende">vende</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-vende" name="vende" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-cupo">cupo</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-cupo" name="cupo" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-legal">legal</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-legal" name="legal" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-fing">fing</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-fing" name="fing" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-fpago">fpago</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-fpago" name="fpago" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-codviejo">codviejo</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-codviejo" name="codviejo" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-chdev">chdev</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-chdev" name="chdev" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-digito">digito</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-digito" name="digito" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-riva">riva</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-riva" name="riva" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-rfte">rfte</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-rfte" name="rfte" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-rica">rica</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-rica" name="rica" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-alma">alma</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-alma" name="alma" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-cali">cali</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-cali" name="cali" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-tipo">tipo</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-tipo" name="tipo" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-distri">distri</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-distri" name="distri" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-genom">genom</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-genom" name="genom" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-getel1">getel1</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-getel1" name="getel1" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-getel2">getel2</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-getel2" name="getel2" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-conom">conom</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-conom" name="conom" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-coema">coema</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-coema" name="coema" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-cotel1">cotel1</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-cotel1" name="cotel1" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-cotel2">cotel2</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-cotel2" name="cotel2" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-panom">panom</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-panom" name="panom" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-paema">paema</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-paema" name="paema" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-patel1">patel1</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-patel1" name="patel1" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-patel2">patel2</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-patel2" name="patel2" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-otnom">otnom</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-otnom" name="otnom" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-otema">otema</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-otema" name="otema" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-ottel1">ottel1</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-ottel1" name="ottel1" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-ottel2">ottel2</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-ottel2" name="ottel2" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-remis">remis</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-remis" name="remis" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-fbloq">fbloq</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-fbloq" name="fbloq" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-diaser">diaser</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-diaser" name="diaser" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-diater">diater</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-diater" name="diater" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-vlrarr">vlrarr</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-vlrarr" name="vlrarr" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-acta">acta</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-acta" name="acta" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-pacta">pacta</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-pacta" name="pacta" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-exclui">exclui</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-exclui" name="exclui" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-person">person</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-person" name="person" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-regime">regime</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-regime" name="regime" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-tipoid">tipoid</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-tipoid" name="tipoid" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-nomreg">nomreg</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-nomreg" name="nomreg" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-pais">pais</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-pais" name="pais" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel" aria-labelledby="bootstrap-wizard-validation-tab3" id="bootstrap-wizard-validation-tab3">
                                                        <form id="fmr_clientes3" class="fmr_clientes needs-validation" novalidate="novalidate" data-wizard-form="3">
                                                            <div class="row">
                                                                <input type="hidden" value="1" name="id_pestana2" id="id_pestana2">

                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-nom1">nom1</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-nom1" name="nom1" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-nom2">nom2</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-nom2" name="nom2" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-ape1">ape1</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-ape1" name="ape1" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-ape2">ape2</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-ape2" name="ape2" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-ofi">ofi</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-ofi" name="ofi" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-difici">difici</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-difici" name="difici" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-remval">remval</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-remval" name="remval" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-est">est</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-est" name="est" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-cono">cono</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-cono" name="cono" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-emailq">emailq</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-emailq" name="emailq" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>

                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="tab-pane text-center px-sm-3 px-md-5" role="tabpanel" aria-labelledby="bootstrap-wizard-validation-tab4" id="bootstrap-wizard-validation-tab4">
                                                        <div class="wizard-lottie-wrapper">
                                                            <!-- <div class="lottie wizard-lottie mx-auto my-3" data-options='{"path":"assets/img/animated-icons/celebration.json"}'></div> -->
                                                        </div>
                                                        <h4 id="resp_titulo" class="mb-1">{resp_titulo}</h4>
                                                        <p id="resp_mensaje">{resp_mensaje}</p><a class="btn btn-primary px-5 my-3" href="#" onclick="cerrar_modal()">Cerrar</a>
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
                    <div class="modal-dialog modal-lg mt-6" role="document">
                        <div class="modal-content border-0">
                            <div class="position-absolute top-0 end-0 mt-3 me-3 z-1"><button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button></div>
                            <div class="modal-body p-0">
                                <div class="rounded-top-3 bg-body-tertiary py-3 ps-4 pe-6">
                                    <h4 class="mb-1" id="staticBackdropLabel">Editar cliente
                                    </h4>
                                    <!-- <p class="fs-11 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p> -->
                                </div>
                                <div class="col-lg-6 col-xl-12 col-xxl-6 h-100">

                                    <div class="card theme-wizard h-100 mb-5">
                                        <div class="card-header bg-body-tertiary pt-3 pb-2">
                                            <ul class="nav justify-content-between nav-wizard">
                                                <li class="nav-item">
                                                    <!-- definimos las opciones de llenado de clientes -->
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
                                                    <a class="nav-link fw-semi-bold" href="#bootstrap-wizard-validation-tab3" data-bs-toggle="tab" data-wizard-step="3">
                                                        <span class="nav-item-circle-parent">
                                                            <span class="nav-item-circle">
                                                                <span class="fas fa-dollar-sign"></span>
                                                            </span>
                                                        </span>
                                                        <span class="d-none d-md-block mt-1 fs-10">
                                                            Información facturación
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
                                                    <form id="fmr_clientes1" class="fmr_clientes needs-validation" novalidate="novalidate" data-wizard-form="1">
                                                        <div class="row">
                                                            <input type="hidden" value="1" name="id_pestana1" id="id_pestana1">
                                                            <div class="col-md-4">
                                                                <label class="form-label" for="bootstrap-wizard-validation-wizard-codigo_mod">Código</label>
                                                                <input class="form-control" id="id" name="id" type="hidden" />
                                                                <input class="form-control" id="bootstrap-wizard-validation-wizard-codigo_mod" name="codigo_mod" type="number" onchange="obtenerDocumento(this.value)" required>
                                                                <div class="valid-feedback">¡Ok!</div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <label class="form-label" for="bootstrap-wizard-validation-wizard-nombre_mod">Nombre</label>
                                                                <input class="form-control" id="bootstrap-wizard-validation-wizard-nombre_mod" name="nombre_mod" type="text" required />
                                                                <div class="valid-feedback">¡Ok!</div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label" for="bootstrap-wizard-validation-wizard-lstSucursal_mod">Sucursal</label>
                                                                <select class="form-control" id="lstSucursal_mod" size="1" name="lstSucursal_mod" required="required">
                                                                </select>
                                                                <div class="valid-feedback">¡Ok!</div>
                                                                <div class="invalid-feedback">Por favor, seleccione uno</div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label" for="bootstrap-wizard-validation-wizard-zona_mod">Zona</label>
                                                                <select class="" id="lstZonas_mod" size="1" name="lstZonas_mod" required onchange="cargar_select(this.value)">
                                                                </select>
                                                                <div class="valid-feedback">¡Ok!</div>
                                                                <div class="invalid-feedback">Por favor, seleccione uno</div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label" for="bootstrap-wizard-validation-wizard-subzona_mod">Subzona</label>
                                                                <!-- <input class="form-control" id="bootstrap-wizard-validation-wizard-subzona_mod" name="subzona_mod" type="text" required /> -->
                                                                <select class="" id="lstSubzonas_mod" size="1" name="lstSubzonas_mod" required>
                                                                </select>
                                                                <div class="valid-feedback">¡Ok!</div>
                                                                <div class="invalid-feedback">Por favor, seleccione uno</div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label" for="bootstrap-wizard-validation-wizard-direc_mod">Dirección</label>
                                                                <input class="form-control" id="bootstrap-wizard-validation-wizard-direc_mod" name="direc_mod" type="text" required />
                                                                <div class="valid-feedback">¡Ok!</div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label" for="bootstrap-wizard-validation-wizard-correo_mod">Correo</label>
                                                                <input class="form-control" id="bootstrap-wizard-validation-wizard-correo_mod" name="correo_mod" type="email" required />
                                                                <div class="valid-feedback">¡Ok!</div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label" for="bootstrap-wizard-validation-wizard-tel1_mod">Teléfono 1</label>
                                                                <input class="form-control" id="bootstrap-wizard-validation-wizard-tel1_mod" name="tel1_mod" type="number" required />
                                                                <div class="valid-feedback">¡Ok!</div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label" for="bootstrap-wizard-validation-wizard-tel2_mod">Teléfono 2</label>
                                                                <input class="form-control" id="bootstrap-wizard-validation-wizard-tel2_mod" name="tel2_mod" type="number" />
                                                                <div class="valid-feedback">¡Ok!</div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel" aria-labelledby="bootstrap-wizard-validation-tab2" id="bootstrap-wizard-validation-tab2">
                                                    <form id="fmr_clientes2" class="fmr_clientes needs-validation" novalidate="novalidate" data-wizard-form="2">
                                                        <div class="row">
                                                            <input type="hidden" value="1" name="id_pestana2" id="id_pestana2">

                                                            <div class="col-md-8">
                                                                <label class="form-label" for="bootstrap-wizard-validation-wizard-nombre1">Nombre</label>
                                                                <input class="form-control" id="bootstrap-wizard-validation-wizard-nombre1" name="nombre1" type="text" required />
                                                                <div class="valid-feedback">¡Ok!</div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label" for="bootstrap-wizard-validation-wizard-sucursal1">Sucursal</label>
                                                                <input class="form-control" id="bootstrap-wizard-validation-wizard-sucursal1" name="sucursal1" type="text" required />
                                                                <div class="valid-feedback">¡Ok!</div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label" for="bootstrap-wizard-validation-wizard-zona1">Zona</label>
                                                                <input class="form-control" id="bootstrap-wizard-validation-wizard-zona1" name="zona1" type="text" required />
                                                                <div class="valid-feedback">¡Ok!</div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label" for="bootstrap-wizard-validation-wizard-subzona1">Subzona</label>
                                                                <input class="form-control" id="bootstrap-wizard-validation-wizard-subzona1" name="subzona1" type="text" required />
                                                                <div class="valid-feedback">¡Ok!</div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label" for="bootstrap-wizard-validation-wizard-direc1">Dirección</label>
                                                                <input class="form-control" id="bootstrap-wizard-validation-wizard-direc1" name="direc1" type="text" required />
                                                                <div class="valid-feedback">¡Ok!</div>
                                                            </div>

                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel" aria-labelledby="bootstrap-wizard-validation-tab3" id="bootstrap-wizard-validation-tab3">
                                                    <form id="fmr_clientes3" class="fmr_clientes needs-validation" novalidate="novalidate" data-wizard-form="3">
                                                        <div class="row">
                                                            <input type="hidden" value="1" name="id_pestana3" id="id_pestana3">

                                                            <div class="col-md-8">
                                                                <label class="form-label" for="bootstrap-wizard-validation-wizard-nombre2">Nombre</label>
                                                                <input class="form-control" id="bootstrap-wizard-validation-wizard-nombre2" name="nombre2" type="text" required />
                                                                <div class="valid-feedback">¡Ok!</div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label" for="bootstrap-wizard-validation-wizard-sucursal2">Sucursal</label>
                                                                <input class="form-control" id="bootstrap-wizard-validation-wizard-sucursal2" name="sucursal2" type="text" required />
                                                                <div class="valid-feedback">¡Ok!</div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label" for="bootstrap-wizard-validation-wizard-zona2">Zona</label>
                                                                <input class="form-control" id="bootstrap-wizard-validation-wizard-zona2" name="zona2" type="text" required />
                                                                <div class="valid-feedback">¡Ok!</div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label" for="bootstrap-wizard-validation-wizard-subzona2">Subzona</label>
                                                                <input class="form-control" id="bootstrap-wizard-validation-wizard-subzona2" name="subzona2" type="text" required />
                                                                <div class="valid-feedback">¡Ok!</div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label" for="bootstrap-wizard-validation-wizard-direc2">Dirección</label>
                                                                <input class="form-control" id="bootstrap-wizard-validation-wizard-direc2" name="direc2" type="text" required />
                                                                <div class="valid-feedback">¡Ok!</div>
                                                            </div>

                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane text-center px-sm-3 px-md-5" role="tabpanel" aria-labelledby="bootstrap-wizard-validation-tab4" id="bootstrap-wizard-validation-tab4">
                                                    <div class="wizard-lottie-wrapper">
                                                        <!-- <div class="lottie wizard-lottie mx-auto my-3" data-options='{"path":"assets/img/animated-icons/celebration.json"}'></div> -->
                                                    </div>
                                                    <h4 id="resp_titulo" class="mb-1">{resp_titulo}</h4>
                                                    <p id="resp_mensaje">{resp_mensaje}</p><a class="btn btn-primary px-5 my-3" href="#" onclick="cerrar_modal()">Cerrar</a>
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
    <script src="js/clientesv1.js"></script>
</body>

</html>