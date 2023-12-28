<?php
session_start();

// if (isset($_SESSION['user_id'])) {
//     header('Location: index.php');
// }
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
    <!-- ===============================================--><!--    Main Content--><!-- ===============================================-->
    <main class="main" id="top">
        <div class="container" data-layout="container">
            <?php require_once("nav.php"); ?>

            <div class="content">
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
                            <div class="tab-pane preview-tab-pane active" role="tabpanel" aria-labelledby="tab-dom-88202497-593f-464d-888e-68d67a1d9bd3" id="dom-88202497-593f-464d-888e-68d67a1d9bd3">
                                <div id="tableExample3" data-list='{"valueNames":["name","email","age"],"page":8,"pagination":true}'>
                                    <div class="row justify-content-end g-0">
                                        <div class="col-auto col-sm-7 mb-3">
                                            <button class="btn btn-outline-primary btn-sm me-1 mb-1" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Registrar proveedor</button>

                                        </div>
                                        <div class="col-auto col-sm-5 mb-3">
                                            <form>
                                                <div class="input-group"><input class="form-control form-control-sm shadow-none search" type="search" placeholder="Buscar..." aria-label="search" />
                                                    <div class="input-group-text bg-transparent"><span class="fa fa-search fs-10 text-600"></span></div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="table-responsive scrollbar">
                                        <table class="table table-bordered table-striped fs-10 mb-0">
                                            <thead class="bg-200">
                                                <tr>
                                                    <th class="text-900 sort" data-sort="name">Name</th>
                                                    <th class="text-900 sort" data-sort="email">Email</th>
                                                    <th class="text-900 sort" data-sort="age">Age</th>
                                                </tr>
                                            </thead>
                                            <tbody class="list">
                                                <tr>
                                                    <td class="name">Anna</td>
                                                    <td class="email">anna@example.com</td>
                                                    <td class="age">18</td>
                                                </tr>
                                                <tr>
                                                    <td class="name">Homer</td>
                                                    <td class="email">homer@example.com</td>
                                                    <td class="age">35</td>
                                                </tr>
                                                <tr>
                                                    <td class="name">Oscar</td>
                                                    <td class="email">oscar@example.com</td>
                                                    <td class="age">52</td>
                                                </tr>
                                                <tr>
                                                    <td class="name">Emily</td>
                                                    <td class="email">emily@example.com</td>
                                                    <td class="age">30</td>
                                                </tr>
                                                <tr>
                                                    <td class="name">Jara</td>
                                                    <td class="email">jara@example.com</td>
                                                    <td class="age">25</td>
                                                </tr>
                                                <tr>
                                                    <td class="name">Clark</td>
                                                    <td class="email">clark@example.com</td>
                                                    <td class="age">39</td>
                                                </tr>
                                                <tr>
                                                    <td class="name">Jennifer</td>
                                                    <td class="email">jennifer@example.com</td>
                                                    <td class="age">52</td>
                                                </tr>
                                                <tr>
                                                    <td class="name">Tony</td>
                                                    <td class="email">tony@example.com</td>
                                                    <td class="age">30</td>
                                                </tr>
                                                <tr>
                                                    <td class="name">Tom</td>
                                                    <td class="email">tom@example.com</td>
                                                    <td class="age">25</td>
                                                </tr>
                                                <tr>
                                                    <td class="name">Michael</td>
                                                    <td class="email">michael@example.com</td>
                                                    <td class="age">39</td>
                                                </tr>
                                                <tr>
                                                    <td class="name">Antony</td>
                                                    <td class="email">antony@example.com</td>
                                                    <td class="age">39</td>
                                                </tr>
                                                <tr>
                                                    <td class="name">Raymond</td>
                                                    <td class="email">raymond@example.com</td>
                                                    <td class="age">52</td>
                                                </tr>
                                                <tr>
                                                    <td class="name">Marie</td>
                                                    <td class="email">marie@example.com</td>
                                                    <td class="age">30</td>
                                                </tr>
                                                <tr>
                                                    <td class="name">Cohen</td>
                                                    <td class="email">cohen@example.com</td>
                                                    <td class="age">25</td>
                                                </tr>
                                                <tr>
                                                    <td class="name">Rowen</td>
                                                    <td class="email">rowen@example.com</td>
                                                    <td class="age">39</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-center mt-3"><button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                                        <ul class="pagination mb-0"></ul><button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next" data-list-pagination="next"><span class="fas fa-chevron-right"> </span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- modal registro -->
                <div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg mt-6" role="document">
                        <div class="modal-content border-0">
                            <div class="position-absolute top-0 end-0 mt-3 me-3 z-1"><button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button></div>
                            <div class="modal-body p-0">
                                <div class="rounded-top-3 bg-body-tertiary py-3 ps-4 pe-6">
                                    <h4 class="mb-1" id="staticBackdropLabel">Registro de proveedores</h4>
                                    <!-- <p class="fs-11 mb-0">Added by <a class="link-600 fw-semi-bold" href="#!">Antony</a></p> -->
                                </div>
                                <div class="p-4">
                                    <div class="row">
                                        <form class="row g-2 needs-validation" novalidate="">
                                            <div class="col-md-4">
                                                <label class="form-label" for="pro_suc">Sucursal</label>
                                                <input class="form-control" id="pro_suc" name="pro_suc" type="text" required />
                                                <div class="valid-feedback">¡Se ve bien!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="pro_zona">Zona</label>
                                                <input class="form-control" id="pro_zona" name="pro_zona" type="text" required />
                                                <div class="valid-feedback">¡Se ve bien!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="pro_subz">Subzona</label>
                                                <input class="form-control" id="pro_subz" name="pro_subz" type="text" required />
                                                <div class="valid-feedback">¡Se ve bien!</div>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label" for="pro_nombre">Nombre del proveedor</label>
                                                <input class="form-control" id="pro_nombre" name="pro_nombre" type="text" required />
                                                <div class="valid-feedback">¡Se ve bien!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="pro_direc">Dirección</label>
                                                <input class="form-control" id="pro_direc" name="pro_direc" type="text" required />
                                                <div class="valid-feedback">¡Se ve bien!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="pro_tel1">Teléfono 1</label>
                                                <input class="form-control" id="pro_tel1" name="pro_tel1" type="text" required />
                                                <div class="valid-feedback">¡Se ve bien!</div>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label" for="pro_tel2">Teléfono 2</label>
                                                <input class="form-control" id="pro_tel2" name="pro_tel2" type="text" required />
                                                <div class="valid-feedback">¡Se ve bien!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="pro_ciudad">Ciudad</label>
                                                <input class="form-control" id="pro_ciudad" name="pro_ciudad" type="text" required />
                                                <div class="valid-feedback">¡Se ve bien!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="pro_cupo">Cupo</label>
                                                <input class="form-control" id="pro_cupo" name="pro_cupo" type="text" required />
                                                <div class="valid-feedback">¡Se ve bien!</div>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label" for="pro_legal">Información Legal</label>
                                                <input class="form-control" id="pro_legal" name="pro_legal" type="text" required />
                                                <div class="valid-feedback">¡Se ve bien!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="pro_fing">Fecha de Inicio</label>
                                                <input class="form-control" id="pro_fing" name="pro_fing" type="date" required />
                                                <div class="valid-feedback">¡Se ve bien!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="pro_fpago">Forma de Pago</label>
                                                <input class="form-control" id="pro_fpago" name="pro_fpago" type="text" required />
                                                <div class="valid-feedback">¡Se ve bien!</div>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label" for="pro_correo">Correo Electrónico</label>
                                                <input class="form-control" id="pro_correo" name="pro_correo" type="email" required />
                                                <div class="valid-feedback">¡Se ve bien!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="pro_chdev">Característica de Devolución</label>
                                                <input class="form-control" id="pro_chdev" name="pro_chdev" type="text" required />
                                                <div class="valid-feedback">¡Se ve bien!</div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="pro_digito">Dígito</label>
                                                <input class="form-control" id="pro_digito" name="pro_digito" type="text" required />
                                                <div class="valid-feedback">¡Se ve bien!</div>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="form-label" for="pro_riva">Retención de IVA</label>
                                                <select class="form-select js-choice" id="pro_riva" size="1" name="pro_riva" data-options='{"removeItemButton":true,"placeholder":true}' required>
                                                    <option value="" disabled selected>Seleccione...</option>
                                                    <option value="S">Si</option>
                                                    <option value="N">No</option>
                                                </select>
                                                <div class="valid-feedback">¡Se ve bien!</div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label" for="pro_rfte">Retención de Fuente</label>
                                                <select class="form-select js-choice" id="pro_rfte" size="1" name="pro_rfte" data-options='{"removeItemButton":true,"placeholder":true}' required>
                                                    <option value="" disabled selected>Seleccione...</option>
                                                    <option value="S">Si</option>
                                                    <option value="N">No</option>
                                                </select>
                                                <div class="valid-feedback">¡Se ve bien!</div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label" for="pro_rica">Retención de ICA</label>
                                                <select class="form-select js-choice" id="pro_rica" size="1" name="pro_rica" data-options='{"removeItemButton":true,"placeholder":true}' required>
                                                    <option value="" disabled selected>Seleccione...</option>
                                                    <option value="S">Si</option>
                                                    <option value="N">No</option>
                                                </select>
                                                <div class="valid-feedback">¡Se ve bien!</div>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="form-label" for="pro_est">Estado</label>
                                                <input class="form-control" id="pro_est" name="pro_est" type="text" required />
                                                <div class="valid-feedback">¡Se ve bien!</div>
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


                <?php require_once("footer.php"); ?>
            </div>
        </div>
    </main>
    <!-- ===============================================--><!--    End of Main Content--><!-- ===============================================-->

    <!-- ===============================================--><!--    JavaScripts--><!-- ===============================================-->
    <?php require_once("script.php"); ?>
</body>

</html>