// Función para el Modal para mensaje emergente
function showErrorModal(message) {
    $("#errorModalBody").text(message); // Inserta el mensaje de error en el cuerpo del modal
    $("#exampleModal").modal("show"); // Muestra el modal
}
// Función para el Modal para mensaje emergente
function showSuccesModal() {
    $("#confirmationModal").modal("show"); // Muestra el modal
}
$(document).ready(() => {

    // Validación del nombre
    $("#nombre").on("input", function() {
        if (/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/.test($(this).val())) {
            $("#nombreError").hide();
        } else {
            $("#nombreError").show().text("Solo puede contener letras.");
        }
    });

    // Validación del apellido
    $("#apellido").on("input", function() {
        if (/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/.test($(this).val())) {
            $("#apellidoError").hide();
        } else {
            $("#apellidoError").show().text("Solo puede contener letras.");
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
                errors.push("Debe tener entre 8 y 16 carácteres.");
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
                    //showErrorModal("Corrige el siguiente error: Las contraseñas deben coincidir.");
                }
            } else {
                $("#confirmPasswordError").hide(); // Oculta el error mientras se escribe
            }
        });

        // Validación en tiempo real para el campo de teléfono
    $("#phone").on("input", function() {
        this.value = this.value.replace(/\D/g, ''); // Eliminar letras
        if (this.value.length > 10) {
            this.value = this.value.slice(0, 10); // Limitar a diez dígitos
        }
    }).on("blur", function(){
        if (iti.isValidNumber() && this.value.length === 10) {
            $("#phoneError").hide();
        } else {
            $("#phoneError").show().text("Número invalido, debe contener 10 dígitos.");
        }
    });

    // Validación de la fecha de nacimiento (entre 18 y 85 años)
    $("#fecha_nacimiento").on("blur", function() {
        const birthdate = new Date($(this).val());
        const today = new Date();
        let age = today.getFullYear() - birthdate.getFullYear();
        if (today < new Date(birthdate.setFullYear(birthdate.getFullYear() + age))) age--;
        if (age >= 18 && age < 85) {
            $("#birthdateError").hide();
        } else {
            $("#birthdateError").show().text("La edad debe ser mayor a 18 y menor a 85 años.");
        }
    });

    // Validación del género
    $("#genero").on("change", function() {
        if ($(this).val() !== "") {
            $("#generoError").hide();
        } else {
            $("#generoError").show().text("Por favor, selecciona tu género.");
        }
    });

    // Validación en tiempo real para el campo de teléfono
    $("#phone").on("input", function() {
        this.value = this.value.replace(/\D/g, ''); // Eliminar letras
        if (this.value.length > 10) {
            this.value = this.value.slice(0, 10); // Limitar a diez dígitos
        }
    }).on("blur", function(){
        if (this.value.length === 10 && iti.isValidNumber()) {
            $("#phoneError").hide();
        } else {
            $("#phoneError").show().text("Número inválido, debe contener 10 dígitos.");
        }
    }).on("focus", function() {
        $("#phoneError").hide(); // Oculta el error mientras el usuario está ingresando el número
    });

    // Validación de la fecha de nacimiento (entre 18 y 85 años)
    $("#birthdate").on("blur", function() {
        const birthdate = new Date($(this).val());
        const today = new Date();
        let age = today.getFullYear() - birthdate.getFullYear();
        if (today < new Date(birthdate.setFullYear(birthdate.getFullYear() + age))) age--;
        if (age >= 18 && age < 85) {
            $("#birthdateError").hide();
        } else {
            $("#birthdateError").show().text("La edad debe ser mayor a 18 y menor a 85 años.");
        }
    });

    // Validación del género
    $("#gender").on("change", function() {
        if ($(this).val() !== "") {
            $("#genderError").hide();
        } else {
            $("#genderError").show().text("Por favor, selecciona tu género.");
        }
    });

    // Validación de la biografía
    document.getElementById("biografia").addEventListener("input", function () {
        const bio = this.value;
        const minLength = 10; // Longitud mínima
        const maxLength = 250; // Longitud máxima
        const errorContainer = document.getElementById("biografiaError");
    
        // Si el texto excede el máximo, recorta a 250 carácteres
        if (bio.length > maxLength) {
            this.value = bio.substring(0, maxLength); // Limita el texto a 250 carácteres
            errorContainer.textContent = `La biografía no debe exceder los ${maxLength} carácteres.`;
            errorContainer.style.display = "block";
        }
        // Si el texto es más corto que el mínimo, muestra el mensaje de error
        else if (bio.length < minLength) {
            errorContainer.textContent = `La biografía debe tener al menos ${minLength} carácteres.`;
            errorContainer.style.display = "block";
        } 
        // Si la longitud es válida, oculta el mensaje de error
        else {
            errorContainer.textContent = "";
            errorContainer.style.display = "none";
        }
    });    
    
    // Cambiar a sección de preferencias
    $('#editPreferencesButton').on('click', function () {
        $('#formSection').hide(); 
        $('#preferencesSection').show(); 
    });

    // Cambiar a sección de edición de perfil
    $('#editProfileButton').on('click', function () {
        $('#preferencesSection').hide(); 
        $('#formSection').show(); 
    });

    // Cambiar el color de fondo en los botones de preferencia al hacer clic
    $('.preference-button').on('click', function () {
        const selected = $(this).data('selected') === true;
        $(this).css('background-color', selected ? '' : 'lightgreen');
        $(this).data('selected', !selected);
    });

    // Abrir el selector de archivos para editar foto
    $('#editPhotoButton').on('click', function () {
        const input = $('<input type="file" accept="image/*">');
        input.on('change', function () {
            // Aquí puedes manejar la imagen seleccionada
        });
        input.click();
    });

    // Configura la validación de JustValidate
    const validacion = new JustValidate('#Editar_Usuario');

    validacion
        
        .onSuccess((event) => {
            event.preventDefault(); // Evita el envío estándar del formulario

            // Realiza una petición AJAX para enviar el formulario a 'editarperfil.php'
            $.ajax({
                url: 'editarperfil.php',
                type: 'POST',
                data: $('#Editar_Usuario').serialize(), // Envía los datos del formulario serializados
                success: function() {
                    // Muestra un SweetAlert si el cambio fue exitoso
                    showSuccesModal();
                    //Swal.fire({
                        //icon: 'success',
                        //title: 'Cambios guardados exitosamente',
                        //showConfirmButton: true,
                        //confirmButtonText: 'OK'
                    //});
                },
                error: function() {
                    // Muestra un SweetAlert de error si algo falla
                    showErrorModal("Hubo un problema al guardar los cambios.");
                    //Swal.fire({
                        //icon: 'error',
                        //title: 'Error',
                        //text: 'Hubo un problema al guardar los cambios.',
                        //showConfirmButton: true,
                        //confirmButtonText: 'OK'
                    //});
                }
            });
        });

        const apiURL = "https://restcountries.com/v3.1/all";
    const selectPais = $('#pais');

    async function cargarPaises() {
        try {
            const response = await fetch(apiURL);
            const data = await response.json();
            selectPais.empty();
            selectPais.append('<option value="">Selecciona un país</option>');
            const paisesOrdenados = data.sort((a, b) => {
                if (a.name.common < b.name.common) {
                    return -1;
                }
                if (a.name.common > b.name.common) {
                    return 1;
                }
                return 0;
            });
            paisesOrdenados.forEach(pais => {
                const option = $('<option></option>'); 
                option.val(pais.name.common);
                option.text(pais.name.common);
                selectPais.append(option); 
            });
        } catch (error) {
            console.error("Error al cargar los países:", error);
            selectPais.empty();
            selectPais.append('<option value="">Error al cargar países</option>');
        }
    }


    cargarPaises();
});

document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("preferencesModal");
    const editPreferencesButton = document.getElementById("editPreferencesButton");
    const closeButton = document.querySelector(".close-button");

    // Mostrar el modal
    editPreferencesButton.addEventListener("click", () => {
        modal.style.display = "flex";
    });

    // Ocultar el modal al hacer clic en la "X"
    closeButton.addEventListener("click", () => {
        modal.style.display = "none";
    });

    // Ocultar el modal al hacer clic fuera del contenido
    window.addEventListener("click", (event) => {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    });
});

// Función para alternar la visibilidad de subcategorías
function toggleSubcategories(id) {
    const element = document.getElementById(id);
    if (element.classList.contains("hidden")) {
        element.classList.remove("hidden");
    } else {
        element.classList.add("hidden");
    }
}
