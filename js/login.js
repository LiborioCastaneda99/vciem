$(document).ready(function() {

    $(".form_login").submit(function(event) {
        event.preventDefault();

        var urlprocess = 'ajax/loginajax.php';
        var username = $("#username").val();
        var password = $("#password").val();
        var dataString = 'usuario=' + username + '&password=' + password;

        $.ajax({
            type: 'POST',
            url: urlprocess,
            data: dataString + '&proceso=login',
            dataType: 'json',
            success: function(data) {
                if (data === "Validado") {
                    Swal.fire({
                        title: 'Acceso Autorizado',
                        text: 'Bienvenido',
                        confirmButtonColor: "#2196f3"
                    }).then((result) => {
                        // Redirigir al index después de cerrar el mensaje
                        if (result.isConfirmed || result.isDismissed) {
                            window.location.href = 'index.php';
                        }
                    });
                } else if (data === "Bad Pass") {
                    Swal.fire({
                        title: "Verifica tus datos!",
                        text: "Tu usuario o contraseña son incorrectos",
                        confirmButtonColor: "#EF5350",
                        icon: "warning"
                    });
                } else {
                    Swal.fire({
                        title: "Verifica tus datos!",
                        text: "Tu usuario o contraseña son incorrectos",
                        confirmButtonColor: "#EF5350",
                        icon: "warning"
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: "Lo sentimos...",
                    text: "No pudimos ingresarte al sistema!",
                    confirmButtonColor: "#EF5350",
                    icon: "error"
                });
            }
        });
    });
});