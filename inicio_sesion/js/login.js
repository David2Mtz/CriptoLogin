// Función para mostrar el modal con un mensaje personalizado
function showErrorModal(message) {
    $("#errorModalBody").text(message); // Inserta el mensaje de error en el cuerpo del modal
    $("#exampleModal").modal("show"); // Muestra el modal
}

$(document).ready(()=>{
    // Selecciona el icono y el campo de contraseña
    const $togglePassword = $("#togglePassword");
    const $password = $("#password");

    // Agrega un evento de clic al icono
    $togglePassword.on("click", function () {
        // Alterna el tipo de input entre "password" y "text"
        const type = $password.attr("type") === "password" ? "text" : "password";
        $password.attr("type", type);

        // Cambia el icono según el estado
        if (type === "text") {
            $(this).removeClass("fa-eye").addClass("fa-eye-slash"); // Muestra el ojo cerrado
        } else {
            $(this).removeClass("fa-eye-slash").addClass("fa-eye"); // Muestra el ojo abierto
        }
    });
    $(".login-form").on("submit", function (e) {
        e.preventDefault(); // Evita el envío normal del formulario

        // Obtiene los datos del formulario
        const email = $("#email").val();
        const password = $("#password").val();

        // Realiza la solicitud AJAX
        $.ajax({
            type: "POST",
            url: "../php/login1.php",
            data: { email: email, password: password },
            dataType: "json",
            success: function (response) {
                if (response.error) {
                    //Swal.fire({
                    //    icon: "error",
                    //    title: "Error",
                    //    text: response.error,
                    //});
                    showErrorModal(response.error); //envia el mensaje de error al modal (mensaje emergente)
                } else {
                    window.location.href = "../../index.php"; // Redirige si no hay error
                }
            },
            error: function () {
                //Pueden usar la funcion de Swal.fire para probar sus errores solo no olviden volver a comentar jaja
                //Swal.fire({
                //    icon: "error",
                //    title: "Error",
                //    text: "Ocurrió un error inesperado. Inténtelo de nuevo más tarde.",
                //});
                showErrorModal("Ocurrió un error inesperado. Inténtelo de nuevo más tarde."); //envia el mensaje de error al modal por defecto
            },
        });
    });

})    
    
   
