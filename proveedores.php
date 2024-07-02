<?php
session_start();

// llamamos clase para validarPerfil
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

    <!-- ===============================================--><!--    Document Title--><!-- ===============================================-->
    <title>Visual Ciem | Proveedores</title>

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
                                                <th class="text-900 sort">Zona</th>
                                                <th class="text-900 sort">Subzona</th>
                                                <th class="text-900 sort">Nombre</th>
                                                <th class="text-900 sort">Dirección</th>
                                                <th class="text-900 sort">Teléfono 1</th>
                                                <th class="text-900 sort">Teléfono 2</th>
                                                <th class="text-900 sort">Ciudad</th>
                                                <th class="text-900 sort">Cupo</th>
                                                <th class="text-900 sort">Legal</th>
                                                <th class="text-900 sort">Fecha Inicial</th>
                                                <th class="text-900 sort">Forma de Pago</th>
                                                <th class="text-900 sort">Correo</th>
                                                <th class="text-900 sort">Caract. Devolución</th>
                                                <th class="text-900 sort">Dígito</th>
                                                <th class="text-900 sort">Retención de IVA</th>
                                                <th class="text-900 sort">Retención de Fuente</th>
                                                <th class="text-900 sort">Retención de ICA</th>
                                                <th class="text-900 sort">Estado</th>
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
                                    <h4 class="mb-1" id="staticBackdropLabel">Registro de proveedores</h4>
                                    <!-- <p class="fs-11 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p> -->
                                </div>
                                <div class="p-4">
                                    <div class="row">
                                        <form id="fmr_proveedores" method="POST" class="fmr_proveedores row g-2 needs-validation" novalidate="">
                                            <div class="col-md-2">
                                                <label class="form-label" for="codigo">Código</label>
                                                <input class="form-control" id="codigo" name="codigo" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label" for="nombre">Nombre</label>
                                                <input class="form-control" id="nombre" name="nombre" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label" for="dir">Dirección</label>
                                                <input class="form-control" id="dir" name="dir" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="tel1">Teléfono 1</label>
                                                <input class="form-control" id="tel1" name="tel1" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="tel2">Teléfono 2</label>
                                                <input class="form-control" id="tel2" name="tel2" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Sucursal</label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <select class="form-select selectpicker" id="suc" size="1" name="suc" required>
                                                    </select>
                                                    <span class="input-group-addon">
                                                        <button class="btn btn-outline-primary icon-search4 Search" type="button" id="btnBusquedaSucursal" name="btnBusquedaSucursal" style="width: 15.7%;">
                                                            <span class="fas fa-search search-box-icon"></span></button></span>
                                                </div>
                                                <div class="valid-feedback">¡Ok!</div>
                                                <div class="invalid-feedback">Por favor, seleccione uno</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Zona</label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <select class="form-select selectpicker" id="zona" size="1" name="zona" onchange="cargar_select_agg(this.value)" required>
                                                    </select>
                                                    <span class="input-group-addon">
                                                        <button class="btn btn-outline-primary icon-search4 Search" type="button" id="btnBusquedaZona" name="btnBusquedaZona" style="width: 15.7%;">
                                                            <span class="fas fa-search search-box-icon"></span></button></span>
                                                </div>
                                                <div class="valid-feedback">¡Ok!</div>
                                                <div class="invalid-feedback">Por favor, seleccione uno</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Subzona</label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <select class="form-select selectpicker" id="subzona" size="1" name="subzona" required>
                                                    </select>
                                                    <span class="input-group-addon">
                                                        <button class="btn btn-outline-primary icon-search4 Search" type="button" id="btnBusquedaSubzona" name="btnBusquedaSubzona" style="width: 15.7%;">
                                                            <span class="fas fa-search search-box-icon"></span></button></span>
                                                </div>
                                                <div class="valid-feedback">¡Ok!</div>
                                                <div class="invalid-feedback">Por favor, seleccione uno</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Ciudad</label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <select class="form-select selectpicker" id="ciudad" size="1" name="ciudad" required>
                                                    </select>
                                                    <span class="input-group-addon">
                                                        <button class="btn btn-outline-primary icon-search4 Search" type="button" id="btnBusquedaCiudadAgg" name="btnBusquedaCiudadAgg" style="width: 15.7%;">
                                                            <span class="fas fa-search search-box-icon"></span></button></span>
                                                </div>
                                                <div class="valid-feedback">¡Ok!</div>
                                                <div class="invalid-feedback">Por favor, seleccione uno</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="cupo">Cupo</label>
                                                <input class="form-control" id="cupo" name="cupo" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="legal">Información Legal</label>
                                                <input class="form-control" id="legal" name="legal" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="fecha_ini">Fecha de Inicio</label>
                                                <input class="form-control" id="fecha_ini" name="fecha_ini" type="date" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="fpago">Forma de Pago</label>
                                                <input class="form-control" id="fpago" name="fpago" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label" for="correo">Correo</label>
                                                <input class="form-control" id="correo" name="correo" type="email" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="caract_dev">Caract. Devolución</label>
                                                <input class="form-control" id="caract_dev" name="caract_dev" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="digito">Dígito</label>
                                                <input class="form-control" id="digito" name="digito" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label" for="riva">Retención de IVA</label>
                                                <select name="riva" id="riva" class="form-control">
                                                    <option value="0" disabled selected>Seleccione</option>
                                                    <option value="S">SI</option>
                                                    <option value="N">NO</option>
                                                </select>
                                                <!-- <input class="form-control" id="riva" name="riva" type="text" required /> -->
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="rfte">Retención de Fuente</label>
                                                <select name="rfte" id="rfte" class="form-control">
                                                    <option value="0" disabled selected>Seleccione</option>
                                                    <option value="S">SI</option>
                                                    <option value="N">NO</option>
                                                </select>
                                                <!-- <input class="form-control" id="rfte" name="rfte" type="text" required /> -->
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="rica">Retención de ICA</label>
                                                <select name="rica" id="rica" class="form-control">
                                                    <option value="0" disabled selected>Seleccione</option>
                                                    <option value="S">SI</option>
                                                    <option value="N">NO</option>
                                                </select>
                                                <!-- <input class="form-control" id="rica" name="rica" type="text" required /> -->
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="estado">Estado</label>
                                                <input class="form-control" id="estado" name="estado" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="col-12 d-grid  gap-0">
                                                    <button class="btn btn-outline-primary me-1 mb-1" type="submit">Agregar proveedor</button>
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
                                    <h4 class="mb-1" id="staticBackdropLabel">Editar proveedor</h4>
                                    <!-- <p class="fs-11 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p> -->
                                </div>
                                <div class="p-4">
                                    <div class="row">
                                        <form id="fmr_proveedores_editar" method="POST" class="fmr_proveedores_editar row g-2 needs-validation" novalidate="">
                                            <div class="col-md-2">
                                                <label class="form-label" for="codigo_mod">Código</label>
                                                <input class="form-control" id="id" name="id" type="hidden" />
                                                <input class="form-control" id="codigo_mod" name="codigo_mod" type="text" required readonly/>
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label" for="nombre_mod">Nombre</label>
                                                <input class="form-control" id="nombre_mod" name="nombre_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label" for="dir_mod">Dirección</label>
                                                <input class="form-control" id="dir_mod" name="dir_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="tel1_mod">Teléfono 1</label>
                                                <input class="form-control" id="tel1_mod" name="tel1_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="tel2_mod">Teléfono 2</label>
                                                <input class="form-control" id="tel2_mod" name="tel2_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Sucursal</label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <select class="form-select selectpicker" id="suc_mod" size="1" name="suc_mod" required>
                                                    </select>
                                                    <span class="input-group-addon">
                                                        <button class="btn btn-outline-primary icon-search4 Search" type="button" id="btnBusquedaSucursalMod" name="btnBusquedaSucursalMod" style="width: 15.7%;">
                                                            <span class="fas fa-search search-box-icon"></span></button></span>
                                                </div>
                                                <div class="valid-feedback">¡Ok!</div>
                                                <div class="invalid-feedback">Por favor, seleccione uno</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Zona</label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <select class="form-select selectpicker" id="zona_mod" size="1" name="zona_mod" onchange="cargar_select(this.value)" required>
                                                    </select>
                                                    <span class="input-group-addon">
                                                        <button class="btn btn-outline-primary icon-search4 Search" type="button" id="btnBusquedaZonaMod" name="btnBusquedaZonaMod" style="width: 15.7%;">
                                                            <span class="fas fa-search search-box-icon"></span></button></span>
                                                </div>
                                                <div class="valid-feedback">¡Ok!</div>
                                                <div class="invalid-feedback">Por favor, seleccione uno</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Subzona</label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <select class="form-select selectpicker" id="subzona_mod" size="1" name="subzona_mod" required>
                                                    </select>
                                                    <span class="input-group-addon">
                                                        <button class="btn btn-outline-primary icon-search4 Search" type="button" id="btnBusquedaSubzonaMod" name="btnBusquedaSubzonaMod" style="width: 15.7%;">
                                                            <span class="fas fa-search search-box-icon"></span></button></span>
                                                </div>
                                                <div class="valid-feedback">¡Ok!</div>
                                                <div class="invalid-feedback">Por favor, seleccione uno</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Ciudad</label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <select class="form-select selectpicker" id="ciudad_mod" size="1" name="ciudad_mod" required>
                                                    </select>
                                                    <span class="input-group-addon">
                                                        <button class="btn btn-outline-primary icon-search4 Search" type="button" id="btnBusquedaCiudadMod" name="btnBusquedaCiudadMod" style="width: 15.7%;">
                                                            <span class="fas fa-search search-box-icon"></span></button></span>
                                                </div>
                                                <div class="valid-feedback">¡Ok!</div>
                                                <div class="invalid-feedback">Por favor, seleccione uno</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="cupo_mod">Cupo</label>
                                                <input class="form-control" id="cupo_mod" name="cupo_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="legal_mod">Información Legal</label>
                                                <input class="form-control" id="legal_mod" name="legal_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="fecha_ini_mod">Fecha de Inicio</label>
                                                <input class="form-control" id="fecha_ini_mod" name="fecha_ini_mod" type="date" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="fpago_mod">Forma de Pago</label>
                                                <input class="form-control" id="fpago_mod" name="fpago_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label" for="correo_mod">Correo</label>
                                                <input class="form-control" id="correo_mod" name="correo_mod" type="email" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="caract_dev_mod">Caract. Devolución</label>
                                                <input class="form-control" id="caract_dev_mod" name="caract_dev_mod" type="number" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="digito_mod">Dígito</label>
                                                <input class="form-control" id="digito_mod" name="digito_mod" type="text" required />
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label" for="riva_mod">Retención de IVA</label>
                                                <select name="riva_mod" id="riva_mod" class="form-control">
                                                    <option value="0" disabled selected>Seleccione</option>
                                                    <option value="S">SI</option>
                                                    <option value="N">NO</option>
                                                </select>
                                                <!-- <input class="form-control" id="riva" name="riva" type="text" required /> -->
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="rfte_mod">Retención de Fuente</label>
                                                <select name="rfte_mod" id="rfte_mod" class="form-control">
                                                    <option value="0" disabled selected>Seleccione</option>
                                                    <option value="S">SI</option>
                                                    <option value="N">NO</option>
                                                </select>
                                                <!-- <input class="form-control" id="rfte" name="rfte" type="text" required /> -->
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="rica_mod">Retención de ICA</label>
                                                <select name="rica_mod" id="rica_mod" class="form-control">
                                                    <option value="0" disabled selected>Seleccione</option>
                                                    <option value="S">SI</option>
                                                    <option value="N">NO</option>
                                                </select>
                                                <!-- <input class="form-control" id="rica" name="rica" type="text" required /> -->
                                                <div class="valid-feedback">¡Ok!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="estado_mod">Estado</label>
                                                <input class="form-control" id="estado_mod" name="estado_mod" type="text" required />
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
    <script src="js/proveedores.js"></script>
</body>

</html>