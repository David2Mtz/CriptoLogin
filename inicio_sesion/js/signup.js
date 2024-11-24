// Función para el Modal para mensaje emergente
function showErrorModal(message) {
    $("#errorModalBody").text(message); // Inserta el mensaje de error en el cuerpo del modal
    $("#exampleModal").modal("show"); // Muestra el modal
}
  


$(document).ready(function() {
    // Función para redirigir después de mostrar la confirmación
    function redirectToLogin() {
        window.location.href = "../html/login.php";
    }

    // Función para mostrar el modal de confirmación
    function showConfirmationModal() {
        $("#confirmationModal").modal("show");
    }
    function showLoadingModal() {
        $("#loadingMessage").removeClass("d-none").addClass("d-flex");
    }
    function unshowLoadingModal() {
        $("#loadingMessage").addClass("d-none").removeClass("d-flex");
    }
    

    // Validación del nombre
    $("#nombre").on("input", function() {
        if (/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/.test($(this).val())) {
            $("#nombreError").hide();
        } else {
            $("#nombreError").show().text("Solo puede contener letras.");
        }
    });

    

    // Validación del correo electrónico
    $("#email").on("blur", function() {
        if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test($(this).val())) {
            $("#emailError").hide();
        } else {
            $("#emailError").show().text("Por favor, ingresa un correo electrónico válido.");
        }
    });
    
    // Validación en tiempo real de la contraseña
    $("#password").on("input", function() {
        const password = $(this).val();
        const errors = [];

        if (!/[A-Za-z]/.test(password)) {
            errors.push("Debe contener al menos una letra.");
        }
        if (!/\d/.test(password)) {
            errors.push("Debe contener al menos un número.");
        }
        if (!/[@$!%*?&#&-]/.test(password)) {
            errors.push("Debe contener al menos un carácter especial.");
        }
        if (password.length < 8 || password.length > 16) {
            errors.push("Debe tener entre 8 y 16 caracteres.");
        }

        if (errors.length === 0) {
            $("#passwordError").hide();
        } else {
            $("#passwordError").show().html(errors.join("<br>"));
        }
    });

    // Confirmación de la contraseña
    $("#confirm_password").on("input", function() {
        const password = $("#password").val();
        const confirmPassword = $(this).val();

        // Solo valida cuando el campo de confirmación tiene la misma longitud que el campo de contraseña
        if (confirmPassword.length >= password.length) {
            if (confirmPassword === password) {
                $("#confirmPasswordError").hide();
            } else {
                $("#confirmPasswordError").show().text("Las contraseñas deben coincidir.");
            }
        } else {
            $("#confirmPasswordError").show().text("Las contraseñas deben coincidir."); // Oculta el error mientras se escribe
        }
    });

    

    // Validación general al enviar el formulario
    $("#FormRegistro").on("submit", function(e) {
        e.preventDefault(); // Evita el envío predeterminado del formulario
        showLoadingModal();

        if ($(".text-danger:visible").length > 0) {
            showErrorModal("Ocurrió un error inesperado. Corrige los errores en el formulario.");
            return;
        }

        const password = $("#password").val();
        const confirmPassword = $("#confirm_password").val();
        if (password !== confirmPassword) {
            $("#confirmPasswordError").show().text("Las contraseñas deben coincidir.");
            return;
        }
        

        $.ajax({
            type: "POST",
            url: "../php/signup.php", // Cambia esta ruta a la URL correcta de tu archivo PHP
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    
                    showConfirmationModal();
                    setTimeout(redirectToLogin, 3500); // Redirige después de 3 segundos
                } else if (response.error) {
                    unshowLoadingModal();
                    showErrorModal(response.error);
                    console.log(response.error);
                }
            },
            error: function(xhr, status, error) {
                unshowLoadingModal();
                console.error("Estado:", status);
                console.error("Error:", error);
                console.error("Respuesta del servidor:", xhr.responseText);
                showErrorModal("Ocurrió un error al enviar el formulario. Intente de nuevo.");
            }
        });
    });
});
