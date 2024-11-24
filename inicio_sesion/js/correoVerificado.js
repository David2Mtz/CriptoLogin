// Función para mostrar el modal con un mensaje personalizado de éxito
function showSuccessModal(message) {
    $("#modalMessage").text(message); // Inserta el mensaje en el párrafo específico
    $("#succesModal").modal("show"); // Muestra el modal de éxito
}

// Función para mostrar el modal con un mensaje personalizado de error
function showErrorModal(message) {
    $("#errorModalBody").text(message); // Inserta el mensaje de error en el cuerpo del modal
    $("#exampleModal").modal("show"); // Muestra el modal de error
}

// Función para mostrar el modal de éxito con token (puedes reutilizar la anterior si es igual)
function showSuccessModalToken(message) {
    $("#modalMessageToken").text(message); // Inserta el mensaje en el párrafo específico
    $("#succesModalToken").modal("show"); // Muestra el modal de éxito
}

$(document).ready(() => {
    // Obtener el token de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const token = urlParams.get("token");

    if (token) {
        $.ajax({
            url: `../php/verificarTokenCorreo.php?token=${token}`,
            method: "GET",
            dataType: "json",
            success: function (response) {
                if (response.error) {
                    showErrorModal(response.error); // Envía el mensaje de error al modal
                } else if (response.message) {
                    showSuccessModal(response.message); // Envía el mensaje de éxito al modal
                    // Redirigir después de un breve retraso
                    setTimeout(() => {
                        window.location.href = "../html/login.php";
                    }, 3000); // Esperar 3 segundos
                } else {
                    showErrorModal("Respuesta inesperada del servidor.");
                }
            },
            error: function () {
                showErrorModal("Ocurrió un error inesperado. Inténtelo de nuevo más tarde."); // Muestra un mensaje de error por defecto
            },
        });
    } else {
        showErrorModal("Token no proporcionado."); // Muestra el error en el modal
        // Redirigir después de un breve retraso
        setTimeout(() => {
            window.location.href = "../html/login.php";
        }, 3000);
    }
});
