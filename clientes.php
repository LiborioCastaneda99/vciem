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

    <!-- ===============================================--><!--    Document Title--><!-- ===============================================-->
    <title>Visual Ciem | Clientes</title>

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
                                <h6 class="mb-0">Clientes</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-3">
                        <div class="tab-content">
                            <div class="tab-pane preview-tab-pane active" role="tabpanel" aria-labelledby="-" id="">
                                <div id="tableExample3" data-list='{"valueNames":["codigo","subzona"],"page":5,"pagination":true}'>
                                    <div class="row justify-content-end g-0">
                                        <div class="d-flex align-items-center" id="table-contact-replace-element">
                                            <button class="btn btn-falcon-default btn-sm" type="button" id="btnAgregar" data-bs-toggle="modal" data-bs-target="#guardarModal">
                                                <span class="fas fa-plus" data-fa-transform="shrink-3"></span>
                                                <span class="d-none d-sm-inline-block d-xl-none d-xxl-inline-block ms-1" title="Registrar">Agregar</span>
                                            </button>
                                            <button onclick="generar()" class="btn btn-falcon-default btn-sm mx-2" type="button">
                                                <span class="fas fa-extercali-link-alt" data-fa-transform="shrink-3"></span>
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
                                                    <th class="text-900 sort" data-sort="subzona">Subzona</th>
                                                    <th class="text-900 sort" data-sort="zona">Zona</th>
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
                                    <h4 class="mb-1" id="staticBackdropLabel">Registro de clientes</h4>
                                    <!-- <p class="fs-11 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p> -->
                                </div>
                                <div class="p-4">
                                    <div class="row">
                                        <form id="fmr_clientes" method="POST" action="#" class="fmr_clientes row g-2 needs-validation" novalidate="">
                                            <div class="col-md-6">
                                                <label class="form-label" for="codigo">Código</label>
                                                <input class="form-control" id="codigo" name="codigo" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="sucursal">Sucursal</label>
                                                <input class="form-control" id="sucursal" name="sucursal" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="zona">Zona</label>
                                                <input class="form-control" id="zona" name="zona" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="subzona">Subzona</label>
                                                <input class="form-control" id="subzona" name="subzona" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="nombre">Nombre</label>
                                                <input class="form-control" id="nombre" name="nombre" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="direc">Dirección</label>
                                                <input class="form-control" id="direc" name="direc" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="tel1">Teléfono 1</label>
                                                <input class="form-control" id="tel1" name="tel1" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="tel2">Teléfono 2</label>
                                                <input class="form-control" id="tel2" name="tel2" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="ciudad">Ciudad</label>
                                                <input class="form-control" id="ciudad" name="ciudad" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="vendedor">Vendedor</label>
                                                <input class="form-control" id="vendedor" name="vendedor" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="cupo">Cupo</label>
                                                <input class="form-control" id="cupo" name="cupo" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="legal">Legal</label>
                                                <input class="form-control" id="legal" name="legal" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="fecha_ini">Fecha De Inicio</label>
                                                <input class="form-control" id="fecha_ini" name="fecha_ini" type="date" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="forma_pago">Forma De Pago</label>
                                                <input class="form-control" id="forma_pago" name="forma_pago" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="correo">Correo</label>
                                                <input class="form-control" id="correo" name="correo" type="email" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="cod_viejo">Código Viejo</label>
                                                <input class="form-control" id="cod_viejo" name="cod_viejo" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="caract_dev">Caract. Devolución</label>
                                                <input class="form-control" id="caract_dev" name="caract_dev" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="digito">Dígito</label>
                                                <input class="form-control" id="digito" name="digito" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="riva">Retención De IVA</label>
                                                <input class="form-control" id="riva" name="riva" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="rfte">Retención De Fuente</label>
                                                <input class="form-control" id="rfte" name="rfte" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="rica">Retención De ICA</label>
                                                <input class="form-control" id="rica" name="rica" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="alma">Alma</label>
                                                <input class="form-control" id="alma" name="alma" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="cali">Calificación</label>
                                                <select name="cali" id="cali" class="form-control">
                                                    <option value="0" disabled selected>Seleccione</option>
                                                    <option value="I">INSUFICIENTE</option>
                                                    <option value="R">REGULAR</option>
                                                    <option value="B">BUENO</option>
                                                    <option value="E">EXCELENTE</option>
                                                </select>
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="tipo">Tipo</label>
                                                <select name="tipo" id="tipo" class="form-control">
                                                    <option value="0" disabled selected>Seleccione</option>
                                                    <option value="RC">RÉGIMEN COMÚN</option>
                                                    <option value="RS">RÉGIMEN SIMPLIFICADO</option>
                                                    <option value="GC">GRAN CONTRIBUYENTE</option>
                                                </select>
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="distri">Distribuidor</label>
                                                <select name="distri" id="distri" class="form-control">
                                                    <option value="0" disabled selected>Seleccione</option>
                                                    <option value="C">CLIENTE</option>
                                                    <option value="D">DISTRIBUIDOR</option>
                                                </select>
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="genom">Genom</label>
                                                <input class="form-control" id="genom" name="genom" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="geema">Geema</label>
                                                <input class="form-control" id="geema" name="geema" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="getel1">Getel1</label>
                                                <input class="form-control" id="getel1" name="getel1" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="getel2">Getel2</label>
                                                <input class="form-control" id="getel2" name="getel2" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="conom">Conom</label>
                                                <input class="form-control" id="conom" name="conom" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="coema">Coema</label>
                                                <input class="form-control" id="coema" name="coema" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="cotel1">Cotel1</label>
                                                <input class="form-control" id="cotel1" name="cotel1" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="cotel2">Cotel2</label>
                                                <input class="form-control" id="cotel2" name="cotel2" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="panom">Panom</label>
                                                <input class="form-control" id="panom" name="panom" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="paema">Paema</label>
                                                <input class="form-control" id="paema" name="paema" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="patel1">Patel1</label>
                                                <input class="form-control" id="patel1" name="patel1" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="patel2">Patel2</label>
                                                <input class="form-control" id="patel2" name="patel2" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="otnom">Otnom</label>
                                                <input class="form-control" id="otnom" name="otnom" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="otema">Otema</label>
                                                <input class="form-control" id="otema" name="otema" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="ottel1">Ottel1</label>
                                                <input class="form-control" id="ottel1" name="ottel1" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="ottel2">Ottel2</label>
                                                <input class="form-control" id="ottel2" name="ottel2" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="remis">Remis</label>
                                                <select name="remis" id="remis" class="form-control">
                                                    <option value="0" disabled selected>Seleccione</option>
                                                    <option value="S">SI</option>
                                                    <option value="N">NO</option>
                                                </select>
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="fbloq">Fbloq</label>
                                                <input class="form-control" id="fbloq" name="fbloq" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="diaser">Diaser</label>
                                                <input class="form-control" id="diaser" name="diaser" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="diater">Diater</label>
                                                <input class="form-control" id="diater" name="diater" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="vlrarr">Vlrarr</label>
                                                <input class="form-control" id="vlrarr" name="vlrarr" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="acta">Acta</label>
                                                <input class="form-control" id="acta" name="acta" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="pacta">Pacta</label>
                                                <input class="form-control" id="pacta" name="pacta" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="exclui">Exclui</label>
                                                <input class="form-control" id="exclui" name="exclui" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="person">Person</label>
                                                <input class="form-control" id="person" name="person" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="regime">Regime</label>
                                                <input class="form-control" id="regime" name="regime" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="tipoid">Tipoid</label>
                                                <input class="form-control" id="tipoid" name="tipoid" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="nomreg">Nomreg</label>
                                                <input class="form-control" id="nomreg" name="nomreg" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="pais">País</label>
                                                <input class="form-control" id="pais" name="pais" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="nom1">Nom1</label>
                                                <input class="form-control" id="nom1" name="nom1" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="nom2">Nom2</label>
                                                <input class="form-control" id="nom2" name="nom2" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="ape1">Ape1</label>
                                                <input class="form-control" id="ape1" name="ape1" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="ape2">Ape2</label>
                                                <input class="form-control" id="ape2" name="ape2" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="ofi">Ofi</label>
                                                <input class="form-control" id="ofi" name="ofi" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="difici">Difici</label>
                                                <select name="difici" id="difici" class="form-control">
                                                    <option value="0" disabled selected>Seleccione</option>
                                                    <option value="S">SI</option>
                                                    <option value="N">NO</option>
                                                </select>
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div> 
                                            <div class="col-md-6">
                                                <label class="form-label" for="remval">Remval</label>
                                                <input class="form-control" id="remval" name="remval" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="estado">Estado</label>
                                                <input class="form-control" id="estado" name="estado" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="cono">Cono</label>
                                                <select name="cono" id="cono" class="form-control">
                                                    <option value="0" disabled selected>Seleccione</option>
                                                    <option value="I">INTERNET</option>
                                                    <option value="R">RECOMENDADO</option>
                                                    <option value="O">OTRO</option>
                                                </select>
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div> 
                                            <div class="col-md-6">
                                                <label class="form-label" for="emailq">emailq</label>
                                                <input class="form-control" id="emailq" name="emailq" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="col-12 d-grid  gap-0">
                                                    <button class="btn btn-outline-primary me-1 mb-1" type="submit">Agregar cliente</button>
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
                                    <h4 class="mb-1" id="staticBackdropLabel">Editar cliente</h4>
                                    <!-- <p class="fs-11 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p> -->
                                </div>
                                <div class="p-4">
                                    <div class="row">
                                        <form id="fmr_clientes_editar" method="POST" class="fmr_clientes_editar row g-2 needs-validation" novalidate="">
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
                                                <label class="form-label" for="tel1_mod">Teléfono 1</label>
                                                <input class="form-control" id="tel1_mod" name="tel1_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="tel2_mod">Teléfono 2</label>
                                                <input class="form-control" id="tel2_mod" name="tel2_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="ciudad_mod">Ciudad</label>
                                                <input class="form-control" id="ciudad_mod" name="ciudad_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-6">
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
    <script src="js/clientes.js"></script>
</body>

</html>