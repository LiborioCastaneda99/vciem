$(document).ready(function() {
    cargar_menu()
});

// consultar
function cargar_menu() {
    // Hacer la solicitud AJAX al servidor
    var urlprocess = 'ajax/menu_ajax.php';
    $.ajax({
        type: 'POST',
        url: urlprocess,
        data: 'proceso=get',
        dataType: 'json',
        success: function(data) {
            // Limpiar el cuerpo de la tabla
            const menuContainer = $('#navbarVerticalNav');
            menuContainer.empty();

            // Iterar sobre los menús y crear elementos HTML
            const menuP = $(`<li class="nav-item">`);
            menuContainer.append(menuP);
            data.forEach(menu => {
                if (menu.es_cabecera == 1) {
                    const menuItem = $(`<li class="nav-item">
                        <a class="nav-link dropdown-indicator" href="#${menu.modulo}" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="${menu.modulo}">
                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                    class="fas ${menu.icono}"></span></span><span class="nav-link-text ps-1">${menu.nombre}</span></div>
                        </a>
                    `);
                    menuContainer.append(menuItem);
                } else {
                    const menuItem = $(`<ul class="nav collapse show" id="${menu.modulo}">
                        <li class="nav-item">
                            <a class="nav-link" href="${menu.ruta}">
                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1"><span
                                class="fas ${menu.icono}"></span> ${menu.nombre}</span></div>
                            </a>
                        </li>
                    `);
                    menuContainer.append(menuItem);
                }

            });
            const menuF = $(`</ul></li>`);
            menuContainer.append(menuF);
        },
        error: function() {
            // Error en la inserción, muestra mensaje de error con SweetAlert
            Swal.fire({
                title: 'Error',
                text: 'Error al traer los datos.',
                icon: 'error',
                confirmButtonColor: "#EF5350"
            });
        }
    });
}