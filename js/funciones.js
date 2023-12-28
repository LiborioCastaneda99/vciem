$(document).ready(function () {

  
});

$('#btnIniciar').submit(function (event) {
    event.preventDefault();

    var action = $('input#action').val();

    $.ajax({
        url: "ajax/loginajax.php",
        method: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (data) {
            console.log(data)
            if (data == 1) {
                $('#frmLineas')[0].reset();
                $('#createRow').modal('hide');
                if (action == 'create') {

                    Swal.fire({
                        title: 'Registrado',
                        text: 'Información almacenada con éxito',
                        confirmButtonColor: "#2196f3"
                    });
                } else {
                    Swal.fire({
                        title: 'Actualizado',
                        text: 'Información almacenada con éxito',
                        confirmButtonColor: "#2196f3"
                    });
                }
                tabla();
            } else {
                $('#createRow').modal('hide');
                tabla();
                Swal.fire({
                    title: '!! Atención !!',
                    text: 'La información no se modificó',
                    confirmButtonColor: "#2196f3",
                    icon: 'warning'
                });
            }

        },
        error: function (data) {
            swal.fire("Error!", "Hubo un error, intente nuevamente!", "error");
        }


    });


});
