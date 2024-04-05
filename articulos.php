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
                            <div class="tab-pane preview-tab-pane active" role="tabpanel" aria-labelledby="-" id>
                                <div class="table-responsive scrollbar">
                                    <table id="tabla" class="table table-striped mb-0 data-table fs-10" data-datatables="data-datatables" style="width: 100%;">
                                        <thead class="bg-200">
                                            <tr>
                                                <th class="text-900 sort">Código</th>
                                                <th class="text-900 sort">Homologación</th>
                                                <th class="text-900 sort">Nombre</th>
                                                <th class="text-900 sort">Clase</th>
                                                <th class="text-900 sort">Grupo</th>
                                                <th class="text-900 sort">Referencia</th>
                                                <th class="text-900 sort">Umedida</th>
                                                <th class="text-900 sort">Stmin</th>
                                                <th class="text-900 sort">Stmax</th>
                                                <th class="text-900 sort">Ctostan</th>
                                                <th class="text-900 sort">Ctoult</th>
                                                <th class="text-900 sort">Fecult</th>
                                                <th class="text-900 sort">Nal</th>
                                                <th class="text-900 sort">Pv1</th>
                                                <th class="text-900 sort">Pv2</th>
                                                <th class="text-900 sort">Pv3</th>
                                                <th class="text-900 sort">Ubicación</th>
                                                <th class="text-900 sort">Uxemp</th>
                                                <th class="text-900 sort">Peso</th>
                                                <th class="text-900 sort">IVA</th>
                                                <th class="text-900 sort">Impo</th>
                                                <th class="text-900 sort">Flete</th>
                                                <th class="text-900 sort">Estado</th>
                                                <th class="text-900 sort">Canen</th>
                                                <th class="text-900 sort">Valen</th>
                                                <th class="text-900 sort">Pdes</th>
                                                <th class="text-900 sort">Ultpro</th>
                                                <th class="text-900 sort">Docpro</th>
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
                                    <h4 class="mb-1" id="staticBackdropLabel">Registro de articulos</h4>
                                    <!-- <p class="fs-11 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p> -->
                                </div>
                                <div class="p-4">
                                    <div class="row">
                                        <form id="fmr_articulos" method="POST" action="#" class="fmr_articulos row g-2 needs-validation" novalidate="">
                                            <div class="col-md-2">
                                                <label class="form-label" for="codigo">Código</label>
                                                <input class="form-control" id="codigo" name="codigo" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="homol">Homologación</label>
                                                <input class="form-control" id="homol" name="homol" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="nombre">Nombre</label>
                                                <input class="form-control" id="nombre" name="nombre" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Clase</label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <select class="form-select selectpicker" id="clase" size="1" name="clase" onchange="cargar_select(this.value)" required>
                                                    </select>
                                                    <span class="input-group-addon"><button class="btn btn-outline-primary icon-search4 Search" type="button" id="btnBusquedaClaseAgg" name="btnBusquedaClaseAgg" style="width: 15.7%;"><span class="fas fa-search search-box-icon"></span></button></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Grupo</label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <select class="form-select selectpicker" id="grupo" size="1" name="grupo" required>
                                                    </select>
                                                    <span class="input-group-addon"><button class="btn btn-outline-primary icon-search4 Search" type="button" id="btnBusquedaGrupoAgg" name="btnBusquedaGrupoAgg" style="width: 15.7%;"><span class="fas fa-search search-box-icon"></span></button></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="referencia">Referencia</label>
                                                <input class="form-control" id="referencia" name="referencia" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Umedida</label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <select class="form-select selectpicker" id="umedida" size="1" name="umedida" required>
                                                    </select>
                                                    <span class="input-group-addon"><button class="btn btn-outline-primary icon-search4 Search" type="button" id="btnBusquedaUmedidaAgg" name="btnBusquedaUmedidaAgg" style="width: 15.7%;"><span class="fas fa-search search-box-icon"></span></button></span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="stmin">Stmin</label>
                                                <input class="form-control" id="stmin" name="stmin" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="stmax">Stmax</label>
                                                <input class="form-control" id="stmax" name="stmax" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="ctostan">Ctostan</label>
                                                <input class="form-control" id="ctostan" name="ctostan" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="ctoult">Ctoult</label>
                                                <input class="form-control" id="ctoult" name="ctoult" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="fecult">Fecult</label>
                                                <input class="form-control" id="fecult" name="fecult" type="date" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="nal">Nal</label>
                                                <select name="nal" id="nal" class="form-control">
                                                    <option value="0" disabled selected>Seleccione</option>
                                                    <option value="N">NACIONAL</option>
                                                    <option value="I">IMPORTADO</option>
                                                </select>
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="pv1">Pv1</label>
                                                <input class="form-control" id="pv1" name="pv1" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="pv2">Pv2</label>
                                                <input class="form-control" id="pv2" name="pv2" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="pv3">Pv3</label>
                                                <input class="form-control" id="pv3" name="pv3" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="ubicacion">Ubicación</label>
                                                <input class="form-control" id="ubicacion" name="ubicacion" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="uxemp">Uxemp</label>
                                                <input class="form-control" id="uxemp" name="uxemp" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="peso">Peso</label>
                                                <input class="form-control" id="peso" name="peso" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="iva">Iva</label>
                                                <input class="form-control" id="iva" name="iva" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="impo">Impo</label>
                                                <input class="form-control" id="impo" name="impo" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="flete">Flete</label>
                                                <input class="form-control" id="flete" name="flete" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="estado">Estado</label>
                                                <input class="form-control" id="estado" name="estado" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="canen">Canen</label>
                                                <input class="form-control" id="canen" name="canen" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="valen">Valen</label>
                                                <input class="form-control" id="valen" name="valen" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="pdes">Pdes</label>
                                                <input class="form-control" id="pdes" name="pdes" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="ultpro">Ultpro</label>
                                                <input class="form-control" id="ultpro" name="ultpro" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-4">
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
                    <div class="modal-dialog modal-xl mt-6" role="document">
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
                                            <div class="col-md-2">
                                                <label class="form-label" for="codigo_mod">Código</label>
                                                <input class="form-control" id="id" name="id" type="hidden" />
                                                <input class="form-control" id="codigo_mod" name="codigo_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="homol_mod">Homologación</label>
                                                <input class="form-control" id="homol_mod" name="homol_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="nombre_mod">Nombre</label>
                                                <input class="form-control" id="nombre_mod" name="nombre_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Clase</label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <select class="form-select selectpicker" id="clase_mod" size="1" name="clase_mod" onchange="cargar_select_mod(this.value)" required>
                                                    </select>
                                                    <span class="input-group-addon"><button class="btn btn-outline-primary icon-search4 Search" type="button" id="btnBusquedaClaseMod" name="btnBusquedaClaseMod" style="width: 15.7%;"><span class="fas fa-search search-box-icon"></span></button></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Grupo</label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <select class="form-select selectpicker" id="grupo_mod" size="1" name="grupo_mod" required>
                                                    </select>
                                                    <span class="input-group-addon"><button class="btn btn-outline-primary icon-search4 Search" type="button" id="btnBusquedaGrupoMod" name="btnBusquedaGrupoMod" style="width: 15.7%;"><span class="fas fa-search search-box-icon"></span></button></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="referencia_mod">Referencia</label>
                                                <input class="form-control" id="referencia_mod" name="referencia_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Unidad medida</label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <select class="form-select selectpicker" id="umedida_mod" size="1" name="umedida_mod" required>
                                                    </select>
                                                    <span class="input-group-addon"><button class="btn btn-outline-primary icon-search4 Search" type="button" id="btnBusquedaUmedidaMod" name="btnBusquedaUmedidaMod" style="width: 15.7%;"><span class="fas fa-search search-box-icon"></span></button></span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="stmin_mod">Stmin</label>
                                                <input class="form-control" id="stmin_mod" name="stmin_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="stmax_mod">Stmax</label>
                                                <input class="form-control" id="stmax_mod" name="stmax_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="ctostan_mod">Ctostan</label>
                                                <input class="form-control" id="ctostan_mod" name="ctostan_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="ctoult_mod">Ctoult</label>
                                                <input class="form-control" id="ctoult_mod" name="ctoult_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="fecult_mod">Fecult</label>
                                                <input class="form-control" id="fecult_mod" name="fecult_mod" type="date" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="nal_mod">Nal</label>
                                                <select name="nal_mod" id="nal_mod" class="form-control">
                                                    <option value="0" disabled selected>Seleccione</option>
                                                    <option value="N">NACIONAL</option>
                                                    <option value="I">IMPORTADO</option>
                                                </select>
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="pv1_mod">Pv1</label>
                                                <input class="form-control" id="pv1_mod" name="pv1_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="pv2_mod">Pv2</label>
                                                <input class="form-control" id="pv2_mod" name="pv2_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="pv3_mod">Pv3</label>
                                                <input class="form-control" id="pv3_mod" name="pv3_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="ubicacion_mod">Ubicación</label>
                                                <input class="form-control" id="ubicacion_mod" name="ubicacion_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="uxemp_mod">Uxemp</label>
                                                <input class="form-control" id="uxemp_mod" name="uxemp_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="peso_mod">Peso</label>
                                                <input class="form-control" id="peso_mod" name="peso_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="iva_mod">Iva</label>
                                                <input class="form-control" id="iva_mod" name="iva_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="impo_mod">Impo</label>
                                                <input class="form-control" id="impo_mod" name="impo_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="flete_mod">Flete</label>
                                                <input class="form-control" id="flete_mod" name="flete_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="estado_mod">Estado</label>
                                                <input class="form-control" id="estado_mod" name="estado_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="canen_mod">Canen</label>
                                                <input class="form-control" id="canen_mod" name="canen_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="valen_mod">Valen</label>
                                                <input class="form-control" id="valen_mod" name="valen_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="pdes_mod">Pdes</label>
                                                <input class="form-control" id="pdes_mod" name="pdes_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="ultpro_mod">Ultpro</label>
                                                <input class="form-control" id="ultpro_mod" name="ultpro_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-4">
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