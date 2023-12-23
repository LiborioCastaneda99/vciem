﻿<?php
session_start();

// llamamos clase para validarPerfil
require_once('modelo/validar_perfil.php');
$vp = new validarPerfil();

$usuario_id = $_SESSION['user_id'];
if (!isset($usuario_id)) {
    header('Location: login.php');
}

$permisoRequerido = "ver_articulos";
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
    <title>Visual Ciem | Artículos</title>

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
                                <h6 class="mb-0">Artículos</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-3">
                        <div class="tab-content">
                            <div class="tab-pane preview-tab-pane active" role="tabpanel" aria-labelledby="-" id="">
                                <div id="tableExample3" data-list='{"valueNames":["codigo","nombre"],"page":5,"pagination":true}'>
                                    <div class="row justify-content-end g-0">
                                        <div class="col-auto col-sm-7 mb-3">
                                            <button class="btn btn-outline-primary btn-sm me-1 mb-1" type="button" data-bs-toggle="modal" data-bs-target="#guardarModal">Registrar articulo</button>
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
                                                    <th class="text-900 sort" data-sort="homol">Homologación</th>
                                                    <th class="text-900 sort" data-sort="nombre">Nombre</th>
                                                    <th class="text-900 sort" data-sort="clase">Clase</th>
                                                    <th class="text-900 sort" data-sort="grupo">Grupo</th>
                                                    <th class="text-900 sort" data-sort="referencia">Referencia</th>
                                                    <th class="text-900 sort" data-sort="umedida">Umedida</th>
                                                    <th class="text-900 sort" data-sort="stmin">Stmin</th>
                                                    <th class="text-900 sort" data-sort="stmax">Stmax</th>
                                                    <th class="text-900 sort" data-sort="ctostan">Ctostan</th>
                                                    <th class="text-900 sort" data-sort="ctoult">Ctoult</th>
                                                    <th class="text-900 sort" data-sort="fecult">Fecult</th>
                                                    <th class="text-900 sort" data-sort="nal">Nal</th>
                                                    <th class="text-900 sort" data-sort="pv1">Pv1</th>
                                                    <th class="text-900 sort" data-sort="pv2">Pv2</th>
                                                    <th class="text-900 sort" data-sort="pv3">Pv3</th>
                                                    <th class="text-900 sort" data-sort="ubicacion">Ubicación</th>
                                                    <th class="text-900 sort" data-sort="uxemp">Uxemp</th>
                                                    <th class="text-900 sort" data-sort="peso">Peso</th>
                                                    <th class="text-900 sort" data-sort="iva">IVA</th>
                                                    <th class="text-900 sort" data-sort="impo">Impo</th>
                                                    <th class="text-900 sort" data-sort="flete">Flete</th>
                                                    <th class="text-900 sort" data-sort="estado">Estado</th>
                                                    <th class="text-900 sort" data-sort="canen">Canen</th>
                                                    <th class="text-900 sort" data-sort="valen">Valen</th>
                                                    <th class="text-900 sort" data-sort="pdes">Pdes</th>
                                                    <th class="text-900 sort" data-sort="ultpro">Ultpro</th>
                                                    <th class="text-900 sort" data-sort="docpro">Docpro</th>
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
                                    <h4 class="mb-1" id="staticBackdropLabel">Registro de articulos</h4>
                                    <!-- <p class="fs-11 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p> -->
                                </div>
                                <div class="p-4">
                                    <div class="row">
                                        <form id="fmr_articulos" method="POST" action="#" class="fmr_articulos row g-2 needs-validation" novalidate="">
                                            <div class="col-md-6">
                                                <label class="form-label" for="codigo">Código</label>
                                                <input class="form-control" id="codigo" name="codigo" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="homol">Homologación</label>
                                                <input class="form-control" id="homol" name="homol" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="nombre">Nombre</label>
                                                <input class="form-control" id="nombre" name="nombre" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="clase">Clase</label>
                                                <input class="form-control" id="clase" name="clase" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="grupo">Grupo</label>
                                                <input class="form-control" id="grupo" name="grupo" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="referencia">Referencia</label>
                                                <input class="form-control" id="referencia" name="referencia" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="umedida">Umedida</label>
                                                <input class="form-control" id="umedida" name="umedida" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="stmin">Stmin</label>
                                                <input class="form-control" id="stmin" name="stmin" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="stmax">Stmax</label>
                                                <input class="form-control" id="stmax" name="stmax" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="ctostan">Ctostan</label>
                                                <input class="form-control" id="ctostan" name="ctostan" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="ctoult">Ctoult</label>
                                                <input class="form-control" id="ctoult" name="ctoult" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="fecult">Fecult</label>
                                                <input class="form-control" id="fecult" name="fecult" type="date" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="nal">Nal</label>
                                                <select name="nal" id="nal" class="form-control">
                                                    <option value="0" disabled selected>Seleccione</option>
                                                    <option value="N">NACIONAL</option>
                                                    <option value="I">IMPORTADO</option>
                                                </select>
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="pv1">Pv1</label>
                                                <input class="form-control" id="pv1" name="pv1" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="pv2">Pv2</label>
                                                <input class="form-control" id="pv2" name="pv2" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="pv3">Pv3</label>
                                                <input class="form-control" id="pv3" name="pv3" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="ubicacion">Ubicación</label>
                                                <input class="form-control" id="ubicacion" name="ubicacion" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="uxemp">Uxemp</label>
                                                <input class="form-control" id="uxemp" name="uxemp" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="peso">Peso</label>
                                                <input class="form-control" id="peso" name="peso" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="iva">Iva</label>
                                                <input class="form-control" id="iva" name="iva" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="impo">Impo</label>
                                                <input class="form-control" id="impo" name="impo" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="flete">Flete</label>
                                                <input class="form-control" id="flete" name="flete" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="estado">Estado</label>
                                                <input class="form-control" id="estado" name="estado" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="canen">Canen</label>
                                                <input class="form-control" id="canen" name="canen" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="valen">Valen</label>
                                                <input class="form-control" id="valen" name="valen" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="pdes">Pdes</label>
                                                <input class="form-control" id="pdes" name="pdes" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="ultpro">Ultpro</label>
                                                <input class="form-control" id="ultpro" name="ultpro" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="docpro">Docpro</label>
                                                <input class="form-control" id="docpro" name="docpro" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="col-12 d-grid  gap-0">
                                                    <button class="btn btn-outline-primary me-1 mb-1" type="submit">Agregar artículo</button>
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
                                    <h4 class="mb-1" id="staticBackdropLabel">Editar articulo</h4>
                                    <!-- <p class="fs-11 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p> -->
                                </div>
                                <div class="p-4">
                                    <div class="row">
                                        <form id="fmr_articulos_editar" method="POST" class="fmr_articulos_editar row g-2 needs-validation" novalidate="">
                                            <div class="col-md-6">
                                                <label class="form-label" for="codigo_mod">Código</label>
                                                <input class="form-control" id="id" name="id" type="hidden" />
                                                <input class="form-control" id="codigo_mod" name="codigo_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="homol_mod">Homologación</label>
                                                <input class="form-control" id="homol_mod" name="homol_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="nombre_mod">Nombre</label>
                                                <input class="form-control" id="nombre_mod" name="nombre_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="clase_mod">Clase</label>
                                                <input class="form-control" id="clase_mod" name="clase_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="grupo_mod">Grupo</label>
                                                <input class="form-control" id="grupo_mod" name="grupo_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="referencia_mod">Referencia</label>
                                                <input class="form-control" id="referencia_mod" name="referencia_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="umedida_mod">Umedida</label>
                                                <input class="form-control" id="umedida_mod" name="umedida_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="stmin_mod">Stmin</label>
                                                <input class="form-control" id="stmin_mod" name="stmin_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="stmax_mod">Stmax</label>
                                                <input class="form-control" id="stmax_mod" name="stmax_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="ctostan_mod">Ctostan</label>
                                                <input class="form-control" id="ctostan_mod" name="ctostan_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="ctoult_mod">Ctoult</label>
                                                <input class="form-control" id="ctoult_mod" name="ctoult_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="fecult_mod">Fecult</label>
                                                <input class="form-control" id="fecult_mod" name="fecult_mod" type="date" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="nal_mod">Nal</label>
                                                <select name="nal_mod" id="nal_mod" class="form-control">
                                                    <option value="0" disabled selected>Seleccione</option>
                                                    <option value="N">NACIONAL</option>
                                                    <option value="I">IMPORTADO</option>
                                                </select>
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="pv1_mod">Pv1</label>
                                                <input class="form-control" id="pv1_mod" name="pv1_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="pv2_mod">Pv2</label>
                                                <input class="form-control" id="pv2_mod" name="pv2_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="pv3_mod">Pv3</label>
                                                <input class="form-control" id="pv3_mod" name="pv3_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="ubicacion_mod">Ubicación</label>
                                                <input class="form-control" id="ubicacion_mod" name="ubicacion_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="uxemp_mod">Uxemp</label>
                                                <input class="form-control" id="uxemp_mod" name="uxemp_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="peso_mod">Peso</label>
                                                <input class="form-control" id="peso_mod" name="peso_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="iva_mod">Iva</label>
                                                <input class="form-control" id="iva_mod" name="iva_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="impo_mod">Impo</label>
                                                <input class="form-control" id="impo_mod" name="impo_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="flete_mod">Flete</label>
                                                <input class="form-control" id="flete_mod" name="flete_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="estado_mod">Estado</label>
                                                <input class="form-control" id="estado_mod" name="estado_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="canen_mod">Canen</label>
                                                <input class="form-control" id="canen_mod" name="canen_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="valen_mod">Valen</label>
                                                <input class="form-control" id="valen_mod" name="valen_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="pdes_mod">Pdes</label>
                                                <input class="form-control" id="pdes_mod" name="pdes_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="ultpro_mod">Ultpro</label>
                                                <input class="form-control" id="ultpro_mod" name="ultpro_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="docpro_mod">Docpro</label>
                                                <input class="form-control" id="docpro_mod" name="docpro_mod" type="number" required />
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
    <script src="js/articulos.js"></script>
</body>

</html>