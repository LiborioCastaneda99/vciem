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
                                            <button class="btn btn-falcon-default btn-sm" type="button" id="btnAgregar" data-bs-toggle="modal" data-bs-target="#guardarModal">
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
                                                    <th class="text-900 sort" data-sort="ciudad">Ciudad</th>
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
                                                        <a class="nav-link active fw-semi-bold" href="#bootstrap-wizard-validation-tab1" data-bs-toggle="tab" data-wizard-step="1">
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
                                                        <form id="fmr_clientes" class="fmr_clientes needs-validation" novalidate="novalidate" data-wizard-form="1">
                                                            <div class="row">
                                                                <input type="hidden" value="" name="id_pestana1" id="id_pestana1">
                                                                <input type="hidden" value="" name="id" id="id">
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
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-sucursal">Sucursal</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-sucursal" name="sucursal" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-zona">Zona</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-zona" name="zona" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-subzona">Subzona</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-subzona" name="subzona" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
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
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-tel2" name="tel2" type="number" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel" aria-labelledby="bootstrap-wizard-validation-tab2" id="bootstrap-wizard-validation-tab2">
                                                        <form  id="fmr_clientes" class="fmr_clientes needs-validation" novalidate="novalidate" data-wizard-form="2">
                                                            <div class="row">
                                                                <input type="hidden" name="id_pestana2" id="id_pestana2">

                                                                <div class="col-md-8">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-nombre1">Nombre</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-nombre1" name="nombre" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-sucursal1">Sucursal</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-sucursal1" name="sucursal" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-zona2">Zona</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-zona2" name="zona" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-subzona2">Subzona</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-subzona2" name="subzona" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label" for="bootstrap-wizard-validation-wizard-direc2">Dirección</label>
                                                                    <input class="form-control" id="bootstrap-wizard-validation-wizard-direc2" name="direc" type="text" required />
                                                                    <div class="valid-feedback">¡Ok!</div>
                                                                </div>

                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel" aria-labelledby="bootstrap-wizard-validation-tab3" id="bootstrap-wizard-validation-tab3">
                                                        <form class="form-validation" data-wizard-form="2">
                                                            <div class="row g-2">
                                                                <div class="col">
                                                                    <div class="mb-3"><label class="form-label" for="bootstrap-wizard-validation-card-number">Card Number</label><input class="form-control" placeholder="XXXX XXXX XXXX XXXX" type="text" id="bootstrap-wizard-validation-card-number"></div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="mb-3"><label class="form-label" for="bootstrap-wizard-validation-card-name">Name on Card</label><input class="form-control" placeholder="John Doe" name="cardName" type="text" id="bootstrap-wizard-validation-card-name"></div>
                                                                </div>
                                                            </div>
                                                            <div class="row g-2">
                                                                <div class="col-6">
                                                                    <div class="mb-3"><label class="form-label" for="bootstrap-wizard-validation-card-holder-zip-code">Zip Code</label><input class="form-control" placeholder="1234" name="zipCode" type="text" id="bootstrap-wizard-validation-card-holder-zip-code"></div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group mb-0"><label class="form-label" for="bootstrap-wizard-validation-card-exp-date">Exp Date</label><input class="form-control" placeholder="15/2024" name="expDate" type="text" id="bootstrap-wizard-validation-card-exp-date"></div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group mb-0"><label class="form-label" for="bootstrap-wizard-validation-card-cvv">CVV</label><span class="ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Card verification value"><span class="fa fa-question-circle"></span></span><input class="form-control" placeholder="123" name="cvv" maxlength="3" pattern="[0-9]{3}" type="text" id="bootstrap-wizard-validation-card-cvv"></div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="tab-pane text-center px-sm-3 px-md-5" role="tabpanel" aria-labelledby="bootstrap-wizard-validation-tab4" id="bootstrap-wizard-validation-tab4">
                                                        <div class="wizard-lottie-wrapper">
                                                            <div class="lottie wizard-lottie mx-auto my-3" data-options='{"path":"../../assets/img/animated-icons/celebration.json"}'></div>
                                                        </div>
                                                        <h4 class="mb-1">Your account is all set!</h4>
                                                        <p>Now you can access to your account</p><a class="btn btn-primary px-5 my-3" href="wizard.html.htm">Start Over</a>
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
                                                            <button class="btn btn-primary px-5 px-sm-6" type="submit" name="btnSiguiente" id="btnSiguiente">Siguiente<span class="fas fa-chevron-right ms-2" data-fa-transform="shrink-3"></span></button>
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
                                <div class="p-4">
                                    <div class="row">
                                        <form id="fmr_clientes_editar" method="POST" class="fmr_clientes_editar row g-2 needs-validation" novalidate>
                                            <div class="col-md-6">
                                                <label class="form-label" for="codigo_mod">Código</label>
                                                <input class="form-control" id="id" name="id" type="hidden" />
                                                <input class="form-control" id="codigo_mod" name="codigo_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="sucursal_mod">Sucursal</label>
                                                <input class="form-control" id="sucursal_mod" name="sucursal_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="zona_mod">Zona</label>
                                                <input class="form-control" id="zona_mod" name="zona_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="subzona_mod">Subzona</label>
                                                <input class="form-control" id="subzona_mod" name="subzona_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="nombre_mod">Nombre</label>
                                                <input class="form-control" id="nombre_mod" name="nombre_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="direc_mod">Dirección</label>
                                                <input class="form-control" id="direc_mod" name="direc_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="tel1_mod">Teléfono
                                                    1</label>
                                                <input class="form-control" id="tel1_mod" name="tel1_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="tel2_mod">Teléfono
                                                    2</label>
                                                <input class="form-control" id="tel2_mod" name="tel2_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="ciudad_mod">Ciudad</label>
                                                <input class="form-control" id="ciudad_mod" name="ciudad_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <!-- <div class="col-md-6">
                                                <label class="form-label" for="vendedor_mod">Vendedor</label>
                                                <input class="form-control" id="vendedor_mod" name="vendedor_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="cupo_mod">Cupo</label>
                                                <input class="form-control" id="cupo_mod" name="cupo_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="legal_mod">Legal</label>
                                                <input class="form-control" id="legal_mod" name="legal_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="fecha_ini_mod">Fecha De Inicio</label>
                                                <input class="form-control" id="fecha_ini_mod" name="fecha_ini_mod" type="date" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="forma_pago_mod">Forma De Pago</label>
                                                <input class="form-control" id="forma_pago_mod" name="forma_pago_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="correo_mod">Correo</label>
                                                <input class="form-control" id="correo_mod" name="correo_mod" type="email" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="cod_viejo_mod">Código Viejo</label>
                                                <input class="form-control" id="cod_viejo_mod" name="cod_viejo_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="caract_dev_mod">Caract. Devolución</label>
                                                <input class="form-control" id="caract_dev_mod" name="caract_dev_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="digito_mod">Dígito</label>
                                                <input class="form-control" id="digito_mod" name="digito_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="riva_mod">Retención De IVA</label>
                                                <input class="form-control" id="riva_mod" name="riva_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="rfte_mod">Retención De Fuente</label>
                                                <input class="form-control" id="rfte_mod" name="rfte_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="rica_mod">Retención De ICA</label>
                                                <input class="form-control" id="rica_mod" name="rica_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="alma_mod">Alma</label>
                                                <input class="form-control" id="alma_mod" name="alma_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="cali_mod">Calificación</label>
                                                <select name="cali_mod" id="cali_mod" class="form-control">
                                                    <option value="0" disabled selected>Seleccione</option>
                                                    <option value="I">INSUFICIENTE</option>
                                                    <option value="R">REGULAR</option>
                                                    <option value="B">BUENO</option>
                                                    <option value="E">EXCELENTE</option>
                                                </select>
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="tipo_mod">Tipo</label>
                                                <select name="tipo_mod" id="tipo_mod" class="form-control">
                                                    <option value="0" disabled selected>Seleccione</option>
                                                    <option value="RC">RÉGIMEN COMÚN</option>
                                                    <option value="RS">RÉGIMEN SIMPLIFICADO</option>
                                                    <option value="GC">GRAN CONTRIBUYENTE</option>
                                                </select>
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="distri_mod">Distribuidor</label>
                                                <select name="distri_mod" id="distri_mod" class="form-control">
                                                    <option value="0" disabled selected>Seleccione</option>
                                                    <option value="C">CLIENTE</option>
                                                    <option value="D">DISTRIBUIDOR</option>
                                                </select>
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="genom_mod">Genom</label>
                                                <input class="form-control" id="genom_mod" name="genom_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="geema_mod">Geema</label>
                                                <input class="form-control" id="geema_mod" name="geema_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="getel1_mod">Getel1</label>
                                                <input class="form-control" id="getel1_mod" name="getel1_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="getel2_mod">Getel2</label>
                                                <input class="form-control" id="getel2_mod" name="getel2_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="conom_mod">Conom</label>
                                                <input class="form-control" id="conom_mod" name="conom_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="coema_mod">Coema</label>
                                                <input class="form-control" id="coema_mod" name="coema_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="cotel1_mod">Cotel1</label>
                                                <input class="form-control" id="cotel1_mod" name="cotel1_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="cotel2_mod">Cotel2</label>
                                                <input class="form-control" id="cotel2_mod" name="cotel2_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="panom_mod">Panom</label>
                                                <input class="form-control" id="panom_mod" name="panom_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="paema_mod">Paema</label>
                                                <input class="form-control" id="paema_mod" name="paema_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="patel1_mod">Patel1</label>
                                                <input class="form-control" id="patel1_mod" name="patel1_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="patel2_mod">Patel2</label>
                                                <input class="form-control" id="patel2_mod" name="patel2_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="otnom_mod">Otnom</label>
                                                <input class="form-control" id="otnom_mod" name="otnom_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="otema_mod">Otema</label>
                                                <input class="form-control" id="otema_mod" name="otema_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="ottel1_mod">Ottel1</label>
                                                <input class="form-control" id="ottel1_mod" name="ottel1_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="ottel2_mod">Ottel2</label>
                                                <input class="form-control" id="ottel2_mod" name="ottel2_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="remis_mod">Remis</label>
                                                <select name="remis_mod" id="remis_mod" class="form-control">
                                                    <option value="0" disabled selected>Seleccione</option>
                                                    <option value="S">SI</option>
                                                    <option value="N">NO</option>
                                                </select>
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="fbloq_mod">Fbloq</label>
                                                <input class="form-control" id="fbloq_mod" name="fbloq_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="diaser_mod">Diaser</label>
                                                <input class="form-control" id="diaser_mod" name="diaser_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="diater_mod">Diater</label>
                                                <input class="form-control" id="diater_mod" name="diater_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="vlrarr_mod">Vlrarr</label>
                                                <input class="form-control" id="vlrarr_mod" name="vlrarr_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="acta_mod">Acta</label>
                                                <input class="form-control" id="acta_mod" name="acta_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="pacta_mod">Pacta</label>
                                                <input class="form-control" id="pacta_mod" name="pacta_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="exclui_mod">Exclui</label>
                                                <input class="form-control" id="exclui_mod" name="exclui_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="person_mod">Person</label>
                                                <input class="form-control" id="person_mod" name="person_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="regime_mod">Regime</label>
                                                <input class="form-control" id="regime_mod" name="regime_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="tipoid_mod">Tipoid</label>
                                                <input class="form-control" id="tipoid_mod" name="tipoid_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="nomreg_mod">Nomreg</label>
                                                <input class="form-control" id="nomreg_mod" name="nomreg_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="pais_mod">País</label>
                                                <input class="form-control" id="pais_mod" name="pais_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="nom1_mod">Nom1</label>
                                                <input class="form-control" id="nom1_mod" name="nom1_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="nom2_mod">Nom2</label>
                                                <input class="form-control" id="nom2_mod" name="nom2_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="ape1_mod">Ape1</label>
                                                <input class="form-control" id="ape1_mod" name="ape1_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="ape2_mod">Ape2</label>
                                                <input class="form-control" id="ape2_mod" name="ape2_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="ofi_mod">Ofi</label>
                                                <input class="form-control" id="ofi_mod" name="ofi_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="difici_mod">Difici</label>
                                                <select name="difici_mod" id="difici_mod" class="form-control">
                                                    <option value="0" disabled selected>Seleccione</option>
                                                    <option value="S">SI</option>
                                                    <option value="N">NO</option>
                                                </select>
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div> 
                                            <div class="col-md-6">
                                                <label class="form-label" for="remval_mod">Remval</label>
                                                <input class="form-control" id="remval_mod" name="remval_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="estado_mod">Estado</label>
                                                <input class="form-control" id="estado_mod" name="estado_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="cono_mod">Cono</label>
                                                <select name="cono_mod" id="cono_mod" class="form-control">
                                                    <option value="0" disabled selected>Seleccione</option>
                                                    <option value="I">INTERNET</option>
                                                    <option value="R">RECOMENDADO</option>
                                                    <option value="O">OTRO</option>
                                                </select>
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div> 
                                            <div class="col-md-6">
                                                <label class="form-label" for="emailq_mod">Emailq</label>
                                                <input class="form-control" id="emailq_mod" name="emailq_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div> -->
                                            <div class="modal-footer">
                                                <div class="col-12 d-grid  gap-0">
                                                    <button class="btn btn-outline-primary me-1 mb-1" type="submit">Modificar</button>
                                                </div>
                                            </div>
                                        </form>
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