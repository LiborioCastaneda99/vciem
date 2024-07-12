<?php
session_start();

// llamamos clase para validarPerfil
require_once('modelo/validar_perfil.php');
$vp = new validarPerfil();

$usuario_id = $_SESSION['user_id'];
if (!isset($usuario_id)) {
    header('Location: login.php');
}

$permisoRequerido = "ver_compras_proveedores";
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
    <title>Visual Ciem | Compras Proveedores</title>

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
                                <h6 class="mb-0">Ventas</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-3">
                        <div class="tab-content">
                            <div class="tab-pane preview-tab-pane active" role="tabpanel" aria-labelledby="-" id="">
                                <div class="p-2">
                                    <div class="row">
                                        <form id="frm_facturacion" method="POST" class="frm_facturacion row g-2 needs-validation" novalidate="">

                                            <div class="col-md-2">
                                                <label>Fecha <span class="text-danger"> * </span></label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <input type="date" class="form-control" id="fechaFact" name="fechaFact">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Tipo movimiento <span class="text-danger"> * </span></label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <select class="form-select selectpicker" id="lstTipoMovimientoFact" size="1" name="lstTipoMovimientoFact" disabled>
                                                    </select>
                                                    <span class="input-group-addon"><button class="btn btn-outline-primary icon-search4 Search" type="button" id="btn" name="btn" style="width: 15.7%;"><span class="fas fa-search search-box-icon"></span></button></span>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Nit <span class="text-danger"> * </span></label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <select class="form-select selectpicker" id="lstProveedoresFact" size="1" name="lstProveedoresFact" required>
                                                    </select>
                                                    <span class="input-group-addon"><button class="btn btn-outline-primary icon-search4 Search" type="button" id="btnBusquedaProveedoresFact" name="btnBusquedaProveedoresFact" style="width: 12.7%;"><span class="fas fa-search search-box-icon"></span></button></span>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Sucursal <span class="text-danger"> * </span></label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <select class="form-select selectpicker" id="lstSucursalFact" size="1" name="lstSucursalFact" required>
                                                    </select>
                                                    <span class="input-group-addon"><button class="btn btn-outline-primary icon-search4 Search" type="button" id="btnBusquedaSucursalFact" name="btnBusquedaSucursalFact" style="width: 15.7%;"><span class="fas fa-search search-box-icon"></span></button></span>
                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                <label>Plazo <span class="text-danger"> * </span></label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <input type="text" class="form-control" id="plazoFact" name="plazoFact">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <label>Documento <span class="text-danger"> * </span></label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <input type="text" class="form-control" id="documentoFact" name="documentoFact">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Bodega afectada <span class="text-danger"> * </span></label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <select class="form-select selectpicker" id="lstBodegaFact" size="1" name="lstBodegaFact" required>
                                                    </select>
                                                    <span class="input-group-addon"><button class="btn btn-outline-primary icon-search4 Search" type="button" id="btnBusquedaBodegaFact" name="btnBusquedaBodegaFact" style="width: 15.7%;"><span class="fas fa-search search-box-icon"></span></button></span>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Vendedor <span class="text-danger"> * </span></label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <select class="form-select selectpicker" id="lstVendedoresFact" size="1" name="lstVendedoresFact" required>
                                                    </select>
                                                    <span class="input-group-addon"><button class="btn btn-outline-primary icon-search4 Search" type="button" id="btnBusquedaVendedoresFact" name="btnBusquedaVendedoresFact" style="width: 15.7%;"><span class="fas fa-search search-box-icon"></span></button></span>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Transporte <span class="text-danger"> * </span></label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <select class="form-select selectpicker" id="lstTransporteFact" size="1" name="lstTransporteFact" required>
                                                    </select>
                                                    <span class="input-group-addon"><button class="btn btn-outline-primary icon-search4 Search" type="button" id="btnBusquedaTransporteFact" name="btnBusquedaTransporteFact" style="width: 15.7%;"><span class="fas fa-search search-box-icon"></span></button></span>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Orden No. <span class="text-danger"> * </span></label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <input type="text" class="form-control" id="ordenFact" name="ordenFact" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Remisión <span class="text-danger"> * </span></label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <input type="text" class="form-control" id="remisionFact" name="remisionFact" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label>Nota</label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <input class="form-control" name="notaFact" id="notaFact" cols="50" rows="2">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group col-md-12 mb-2">
                                                    <input type="text" class="form-control" id="total" name="total" readonly hidden>
                                                </div>
                                            </div>
                                            <hr>
                                            <!-- <div class="mt-4">
                                                <div class="form-group col-md-12 mb-2">
                                                    <span class="input-group-addon d-grid  gap-0">
                                                        <button class="btn btn-outline-dark me-1 mb-1 icon-search4 Search" type="button" id="btnBuscarFacturaEspera" name="btnBuscarFacturaEspera" title="Buscar producto o servicio">
                                                            Buscar factura en espera <span class="fas fa-search search-box-icon"></span>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="">
                                                <div class="form-group col-md-12 mb-2">
                                                    <span class="input-group-addon d-grid  gap-0">
                                                        <button class="btn btn-outline-dark me-1 mb-1 icon-search4 Search" type="button" id="btnBuscarProducto" name="btnBuscarProducto" title="Buscar producto o servicio">
                                                            Buscar productos <span class="fas fa-search search-box-icon"></span>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div> -->
                                            <table class="table table-striped mb-0 fs-10" id="tablaProductos">
                                                <thead>
                                                    <tr class="datos_productos" id="datos_productos">
                                                        <td colspan="2">
                                                            <input class="form-control form-control-sm" type="text" name="codigo" id="codigo" onchange="" placeholder="codigo">
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="text" name="descripcion" id="descripcion" placeholder="descripcion" readonly>
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="text" name="um" id="um" placeholder="um" readonly>
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="text" name="cant" placeholder="cant" id="cant">
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="text" name="vlr_unitario" placeholder="vlr_unitario" id="vlr_unitario">
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="text" name="desc" id="desc" placeholder="desc" readonly>
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="text" name="vlr_descuento" placeholder="vlr_descuento" id="vlr_descuento">
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="text" name="vlr_unit_final" placeholder="vlr_unit_final" id="vlr_unit_final" readonly>
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="text" name="imp" id="imp" placeholder="imp" readonly>
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="text" name="vlr_impuesto" placeholder="vlr_impuesto" id="vlr_impuesto" readonly>
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="text" name="vlr_parcial" placeholder="vlr_parcial" id="vlr_parcial">
                                                        </td>
                                                        <td>
                                                            <div class="form-group col-md-12">
                                                                <span class="input-group-addon col-12 d-grid  gap-0">
                                                                    <button class="btn btn-outline-success icon-search4 Search" type="button" id="btnAgregarProducto" name="btnAgregarProducto" title="Agregar producto o servicio">
                                                                        <span class="fas fa-cart-plus search-box-icon"></span>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <thead class="bg-200">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Código</th>
                                                        <th>Descripción</th>
                                                        <th>UM</th>
                                                        <th>Cant</th>
                                                        <th>Vlr.Unit</th>
                                                        <th>Desc</th>
                                                        <th>Vlr.Desc</th>
                                                        <th>Vlr.Unit Final</th>
                                                        <th>% Imp</th>
                                                        <th>Vlr. Imp</th>
                                                        <th>Vlr. Parcial</th>
                                                        <th style="width: 150px;" class="text-center">Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="cuerpoTabla">
                                                    <tr id="no_hay_registros" class="oculto">
                                                        <td colspan="13" class="text-center">No hay registros agregados.</td>
                                                    </tr>
                                                    <!-- Las filas se agregarán dinámicamente aquí -->
                                                </tbody>
                                            </table>

                                            <!-- pie de factura -->

                                            <div class="col-md-3 text-end">
                                                <label>Valor antes descuento</label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <p class="valorAntesDescuentoFact" id="valorAntesDescuento"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-end">
                                                <label>Descuento</label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <p class="descuentoFact" id="descuentoFact"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-end">
                                                <label>Valor antes impuesto</label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <p class="Valor antes ImpuestoFact" id="Valor antes Impuesto"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-end">
                                                <label>Valor IVA</label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <p class="valorIvaFact" id="valorIvaFact"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-end">
                                                <label>Valor Retefuente</label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <p class="valorRetefuenteFact" id="valorRetefuenteFact"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-end">
                                                <label>Valor ReteIVA</label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <p class="valorReteIvaFact" id="valorReteIvaFact"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-end">
                                                <label>Valor ReteICA</label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <p class="valorReteIcaFact" id="valorReteIcaFact"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-end">
                                                <label>Valor Parcial</label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <p class="valorParcialFact" id="valorParcialFact"></p>
                                                </div>
                                            </div>


                                            <div class="col-md-2 d-grid  gap-0 mt-4">
                                                <button class="btn btn-outline-primary me-1 mb-1 btnComprar" id="btnComprar" type="button"><span class="fas fa-file-invoice-dollar search-box-icon"></span> Comprar</button>
                                            </div>
                                            <div class="col-md-2 d-grid  gap-0 mt-4">
                                                <button class="btn btn-outline-primary me-1 mb-1 btnVerCompra" id="btnVerCompra" type="button"><span class="fas fa-eye search-box-icon"></span> Ver Compra</button>
                                            </div>
                                            <div class="col-md-2 d-grid  gap-0 mt-4">
                                                <button class="btn btn-outline-primary me-1 mb-1 btnNuevaCompra" id="btnNuevaCompra" type="button"><span class="fas fa-plus search-box-icon"></span> Nueva Compra</button>
                                            </div>
                                            <div class="col-md-2 d-grid  gap-0 mt-4">
                                                <button class="btn btn-outline-primary me-1 mb-1 btnBolsas" id="btnBolsas" type="button"><span class="fas fa-shopping-bag search-box-icon"></span> Bolsas</button>
                                            </div>
                                            <div class="col-md-2 d-grid  gap-0 mt-4">
                                                <button class="btn btn-outline-primary me-1 mb-1 btnCompraEspera" id="btnCompraEspera" type="button"><span class="fas fa-clock search-box-icon"></span> Compra en espera</button>
                                            </div>
                                            <div class="col-md-2 d-grid  gap-0 mt-4">
                                                <button class="btn btn-outline-primary me-1 mb-1 btnBorrarCompra" id="btnBorrarCompra" type="button"><span class="fas fa-trash search-box-icon"></span> Borrar Compra</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- modal registro -->
                <div class="modal fade" id="buscarProductos" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl mt-6" role="document">
                        <div class="modal-content border-0">
                            <div class="position-absolute top-0 end-0 mt-3 me-3 z-1"><button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button></div>
                            <div class="modal-body p-0">
                                <div class="rounded-top-3 bg-body-tertiary py-3 ps-4 pe-6">
                                    <h4 class="mb-1" id="staticBackdropLabel">Buscar productos</h4>
                                    <!-- <p class="fs-11 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p> -->
                                </div>
                                <div class="p-4">
                                    <div class="table-responsive scrollbar">

                                        <table id="tablaListadoProductos" class="table table-striped mb-0 data-table fs-10" data-datatables="data-datatables" style="width: 100%;">
                                            <thead class="bg-200">
                                                <tr>
                                                    <th class="text-900 sort">Código</th>
                                                    <th class="text-900 sort">Nombre</th>
                                                    <th class="text-900 text-center">Exist.</th>
                                                    <th class="text-900 text-center">Vlr. Minimo</th>
                                                    <th class="text-900 text-center">Vlr. Sugerido</th>
                                                    <th class="text-900 text-center">Comprar</th>
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
                </div>

                <!-- modal consultar cliente -->
                <div class="modal fade" id="buscarFactura" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg mt-6" role="document">
                        <div class="modal-content border-0">
                            <div class="position-absolute top-0 end-0 mt-3 me-3 z-1"><button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button></div>
                            <div class="modal-body p-0">
                                <div class="rounded-top-3 bg-body-tertiary py-3 ps-4 pe-6">
                                    <h4 class="mb-1" id="staticBackdropLabel">Buscar factura</h4>
                                    <!-- <p class="fs-11 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p> -->
                                </div>
                                <div class="p-4">

                                    <div class="col-md-12">
                                        <label>Clientes <span class="text-danger"> * </span></label>
                                        <div class="form-group col-md-12 mb-2">
                                            <select class="form-select selectpicker lstClientesFactEsp" id="lstClientesFactEsp" size="1" name="lstClientesFactEsp" required>
                                            </select>
                                            <span class="input-group-addon">
                                                <button class="btn btn-outline-primary icon-search4 Search" type="button" id="btnConsultarFactEsp" name="btnConsultarFactEsp" style="width: 15.7%;">
                                                    <span class="fas fa-check check-box-icon"></span>
                                                </button>
                                            </span>
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
                                    <h4 class="mb-1" id="staticBackdropLabel">Editar producto</h4>
                                    <!-- <p class="fs-11 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p> -->
                                </div>
                                <div class="p-4">
                                    <form class="formEditar" id="formEditar" class="row g-2">
                                        <div class="row">

                                            <input type="hidden" id="idProducto">
                                            <input type="hidden" id="impEditar">

                                            <div class="col-md-3">
                                                <label>Código <span class="text-danger"> * </span></label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <input type="text" class="form-control" id="codigoEditar" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-9">
                                                <label>Descripción <span class="text-danger"> * </span></label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <input type="text" class="form-control" id="descripcionEditar" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Valor Unitario Inicial <span class="text-danger"> * </span></label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <input type="text" class="form-control" id="vlrUnitarioInicialEditar" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Cantidad <span class="text-danger"> * </span></label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <input type="text" class="form-control" id="cantidadEditar">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Valor Unitario Final <span class="text-danger"> * </span></label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <input type="text" class="form-control" id="vlrUnitarioFinalEditar">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label>Valor Parcial <span class="text-danger"> * </span></label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <input type="text" class="form-control" id="vlrParcialEditar">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label>Descuento <span class="text-danger"> * </span></label>
                                                <div class="form-group col-md-12 mb-2">
                                                    <input type="text" class="form-control" id="descuentoEditar">
                                                </div>
                                            </div>
                                            <div class="modal-footer mt-3">
                                                <div class="col-12 d-grid  gap-0">
                                                    <button class="btn btn-outline-primary me-1 mb-1 btnModificar" id="btnModificar" type="button">Modificar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- modal pagar -->
                <div class="modal fade" id="pagarFactura" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg mt-6" role="document">
                        <div class="modal-content border-0">
                            <div class="position-absolute top-0 end-0 mt-3 me-3 z-1"><button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button></div>
                            <div class="modal-body p-0">
                                <div class="rounded-top-3 bg-body-tertiary py-3 ps-4 pe-6">
                                    <h4 class="mb-1" id="staticBackdropLabel">Pagar factura</h4>
                                    <!-- <p class="fs-11 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p> -->
                                </div>
                                <div class="p-4">
                                    <form action="" method="post" id="payForm">
                                        <div class="row">
                                            <div class="col-12">
                                                <h2>Total a pagar <span id="pay_total_"></span></h2>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="fac_efecti">Efectivo</label>
                                                <input type="number" min="0" class="form-control pay-field" id="fac_efecti" name="fac_efecti" value="0">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="fac_tdebit">Tarjeta debito</label>
                                                <input type="number" min="0" class="form-control pay-field" id="fac_tdebit" name="fac_tdebit" value="0">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="fac_tcredi">Tarjeta credito</label>
                                                <input type="number" min="0" class="form-control pay-field" id="fac_tcredi" name="fac_tcredi" value="0">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="fac_tchequ">Cheque</label>
                                                <input type="number" min="0" class="form-control pay-field" id="fac_tchequ" name="fac_tchequ" value="0">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="fac_tvales">Vales</label>
                                                <input type="number" min="0" class="form-control pay-field" id="fac_tvales" name="fac_tvales" value="0">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="fac_cambio">Cambio</label>
                                                <input type="number" readonly class="form-control pay-field" id="fac_cambio" name="fac_cambio" value="0">
                                            </div>
                                        </div>
                                        <div class="modal-footer mt-3">
                                            <div class="col-12 d-grid  gap-0">
                                                <button class="btn btn-outline-primary me-1 mb-1 btnFacturar" id="btnFacturar" type="button">Facturar</button>
                                            </div>
                                        </div>
                                    </form>
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
    <script src="js/compras_proveedores.js"></script>
</body>

</html>