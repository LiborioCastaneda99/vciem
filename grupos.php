﻿<?php
session_start();

// llamamos clase para validarPerfil
require_once('modelo/validar_perfil.php');
$vp = new validarPerfil();

$usuario_id = $_SESSION['user_id'];
if (!isset($usuario_id)) {
    header('Location: login.php');
}

$permisoRequerido = "ver_grupos";
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

    <!-- ===============================================--><!--    Document Title--><!-- ===============================================-->
    <title>Visual Ciem | Grupos</title>

    <!-- ===============================================--><!--    Favicons--><!-- ===============================================-->
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
    <!-- ===============================================--><!--   Contenido--><!-- ===============================================-->
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
                                <h6 class="mb-0">Grupos</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-3">
                        <div class="tab-content">
                            <div class="tab-pane preview-tab-pane active" role="tabpanel" aria-labelledby="-" id="">
                                <div id="tableExample3" data-list='{"valueNames":["codigo","nombre"],"page":5,"pagination":true}'>
                                    <div class="row justify-content-end g-0">
                                        <div class="d-flex align-items-center" id="table-contact-replace-element">
                                            <button onclick="abrirModal()" class="btn btn-falcon-default btn-sm" type="button" id="btnAgregar" data-bs-toggle="modal" data-bs-target="#guardarModal">
                                                <span class="fas fa-plus" data-fa-transform="shrink-3"></span>
                                                <span class="d-none d-sm-inline-block d-xl-none d-xxl-inline-block ms-1" title="Registrar">Agregar</span>
                                            </button>
                                            <button onclick="generar()" class="btn btn-falcon-default btn-sm mx-2" type="button">
                                                <span class="fas fa-external-link-alt" data-fa-transform="shrink-3"></span>
                                                <span class="d-none d-sm-inline-block d-xl-none d-xxl-inline-block ms-1">Exportar</span>
                                            </button>
                                        </div>
                                        <div class="col-auto col-sm-5 mb-3">
                                            <form method="POST" action="#" id="" name="">
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
                                                    <th class="text-900 sort" data-sort="clase">Clase</th>
                                                    <th class="text-900 sort" data-sort="nombre">Nombre</th>
                                                    <th class="text-900 sort" data-sort="resumen">Resumen</th>
                                                    <th class="text-900 sort" data-sort="dias">Días</th>
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
                                        <button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next" data-list-pagination="next"><span class="fas fa-chevron-right"> </span></button>
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
                                    <h4 class="mb-1" id="staticBackdropLabel">Registro de grupos</h4>
                                    <!-- <p class="fs-11 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p> -->
                                </div>
                                <div class="p-4">
                                    <div class="row">
                                        <form id="fmr_grupos" method="POST" class="fmr_grupos row g-2 needs-validation" novalidate="">
                                            <div class="col-md-4">
                                                <label class="form-label" for="codigo">Código</label>
                                                <input class="form-control" id="codigo" name="codigo" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="form-label" for="clase_mod">Clase</label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <select class="form-select selectpicker" id="lstClaseAgg" size="1" name="lstClaseAgg" required>
                                                    </select>
                                                    <span class="input-group-addon"><button class="btn btn-primary icon-search4 Search" type="button" id="btnBusquedaClaseAgg" name="btnBusquedaClaseAgg" style="width: 15.7%;"><span class="fas fa-search search-box-icon"></span></button></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label" for="nombre">Nombre</label>
                                                <input class="form-control" id="nombre" name="nombre" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="resumen">Resumen</label>
                                                <input class="form-control" id="resumen" name="resumen" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="dias">Días</label>
                                                <input class="form-control" id="dias" name="dias" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="col-12 d-grid  gap-0">
                                                    <button class="btn btn-outline-primary me-1 mb-1" type="submit">Agregar grupo</button>
                                                </div>
                                            </div>
                                        </form>
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
                                    <h4 class="mb-1" id="staticBackdropLabel">Editar grupo</h4>
                                </div>
                                <div class="p-4">
                                    <div class="row">
                                        <form id="fmr_grupos_editar" method="POST" class="fmr_grupos_editar row g-2 needs-validation" novalidate="">
                                            <div class="col-md-4">
                                                <label class="form-label" for="codigo_mod">Código</label>
                                                <input class="form-control" id="id" name="id" type="hidden" />
                                                <input class="form-control" id="codigo_mod" name="codigo_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="form-label" for="clase_mod">Clase</label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <select class="form-select selectpicker" id="lstClaseMod" size="1" name="lstClaseMod" required>
                                                    </select>
                                                    <span class="input-group-addon"><button class="btn btn-primary icon-search4 Search" type="button" id="btnBusquedaClaseMod" name="btnBusquedaClaseMod" style="width: 15.7%;"><span class="fas fa-search search-box-icon"></span></button></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label" for="nombre_mod">Nombre</label>
                                                <input class="form-control" id="nombre_mod" name="nombre_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="resumen_mod">Resumen</label>
                                                <input class="form-control" id="resumen_mod" name="resumen_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="dias_mod">Días</label>
                                                <input class="form-control" id="dias_mod" name="dias_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
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
    <!-- ===============================================--><!--    End ofContenido--><!-- ===============================================-->

    <!-- ===============================================--><!--    JavaScripts--><!-- ===============================================-->
    <?php require_once("script.php"); ?>
    <script src="js/grupos.js"></script>
</body>

</html>