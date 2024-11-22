function showErrorModal(message) {
    $("#errorModalBody").text(message); // Inserta el mensaje de error en el cuerpo del modal
    $("#exampleModal").modal("show"); // Muestra el modal
}

function showSuccesModal(){
    $("#confirmationModal").modal("show");
}

document.addEventListener("DOMContentLoaded", function() {
    const addButton = document.querySelector(".btn-add");
    const container = document.getElementById("destinos-container");
    let destinoCount = 1;
    addButton.addEventListener("click", function() {
        if (destinoCount < 5) {
            const newInput = document.createElement("input");
            newInput.type = "text";
            newInput.name = `destino${destinoCount + 1}`;
            newInput.placeholder = "Punto de llegada adicional";
            container.appendChild(newInput);
            destinoCount++;
        } else {
            showErrorModal("Número máximo de destinos adicionales alcanzado.");
        }
    });
});

$(document).ready(()=>{
    let currentStep = 1;
    const totalSteps = 5;
    //respuesta del primer formulario:
    let idFormularioS;
    const steps = document.querySelectorAll(".step-section");
    const stepIndicators = document.querySelectorAll(".step");
    const btnNext = document.querySelector(".btn-next"); 
    const btnPrev = document.querySelector(".btn-prev"); 
    const btnSave = document.querySelector(".btn-save"); 
    const btnRespParciales = document.querySelectorAll(".btn-guardar"); 

    /*Inputs de tipo range*/ 
    //input de prioridad de transporte
    const inputPrioridadTransporte = document.getElementById('prioridad-transporte');
    //span de prioridad
    const spanValorTransporte = document.getElementById('valor-prioridad');
    //input de prioridad de hospedaje
    const inputPrioridadHospedaje = document.getElementById('prioridad-hospedaje');
    //span de prioridad de hospedaje
    const spanValorHospedaje = document.getElementById('valor-prioridadHospedaje');
    //input de prioridad de comida
    const inputPrioridadComida = document.getElementById('prioridad-comida');
    //span de prioridad de comida
    const spanValorComida = document.getElementById('valor-prioridadComida');
    //input de prioridad de actividades
    const inputPrioridadActividades = document.getElementById('prioridad-act');
    //span de prioridad de actividades
    const spanValorActividades = document.getElementById('valor-prioridadActividades');

    // Ocultar el botón de guardar inicialmente
    btnSave.style.display = 'none';

    //validar los datos del formulario de presupuesto:
    const ValidarPresuppuesto= new JustValidate('#presupuestoForm');
    ValidarPresuppuesto
    .addField("#presupuesto",[
        {
            rule: 'required',
            errorMessage: "Introduce tu presupuesto"
        },
        {
            rule:"number",
            errorMessage:"Solo números"
        },
    ])
    .addField("#acompanantes",[
        {
            rule:"required",
            errorMessage:"Introduce la cantidad de acompañantes"
        },
        {
            rule:"integer",
            errorMessage:"Solo numeros enteros"
        },
    ])
    .addField("#origen",[
        {
            rule:"required",
            errorMessage:"Introduce el lugar de origen"
        },
    ])
    .addField("#destino",[
        {
            rule:"required",
            errorMessage:"Introduce el lugar de destino"
        },
    ])
    .addField("#fecha-inicio",[
        {
            rule:"required",
            errorMessage:"Introduce la fecha de inicio del viaje"
        },
    ])
    .addField("#fecha-fin",[
        {
            rule:"required",
            errorMessage:"Introduce la fecha de fin del viaje"
        },
    ])
    .onSuccess((event) => {
        event.preventDefault(); // Evita el envío estándar del formulario
        $.ajax({
            url: "../php/viaje.php",
            type: "POST",
            data: $(event.target).serialize(),
            cache: false,
            success: (respAX) => {
                //convertimos la respuesta del servidor a un objeto JSON
                let respAjax = JSON.parse(respAX);
                idFormularioS=respAjax.idFormulario;
                // Aquí puedes verificar la respuesta del servidor y realizar acciones en consecuencia
                if (respAjax.status === "success") {
                    // Si la respuesta indica éxito, muestra SweetAlert
                    //localStorage.setItem('usuario', JSON.stringify(respAjax.datos));
                    //sessionStorage.removeItem('carritoSesion');
                    showSuccesModal();
                    //Swal.fire({
                        //title: "Respuestas registradas",
                        //text: `Sus respuestas han sido registradas`,
                        //icon: "success"
                    //});
                }else{
                    showErrorModal("No se pudieron guardar tus respuestas. Intenta de nuevo.")
                    //Swal.fire({
                        //title: "Respuestas No registradas",
                        //text: `Sus respuestas no han sido registradas, intentelo más tarde`,
                        //icon: "error"
                    //});
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

    //validar los datos del formulario de transporte:
    const ValidarTransporte= new JustValidate('#transporteForm');
    ValidarTransporte
    .addField("#prioridad-transporte",[
        {
            rule: 'required',
            errorMessage: "Selecciona la prioridad"
        },
        {
            rule:"number",
            errorMessage:"Solo números"
        },
    ])
    .addRequiredGroup('#tipoTransporteRadio', 'Selecciona un transporte')
    .addRequiredGroup('#tipoCarreteraRadio', 'Selecciona una opción')
    .addField("#Pres-Transporte",[
        {
            rule:"required",
            errorMessage:"Introduce el presupuesto aproximado"
        },
        {
            rule:"number",
            errorMessage:"Solo numeros"
        },
    ])
    .onSuccess((event) => {
        /*event.preventDefault(); // Evita el envío estándar del formulario
        // Serializar todos los campos del formulario
        const datosSerializados = $(event.target).serialize();
        console.log(datosSerializados);*/
        event.preventDefault(); // Evita el envío estándar del formulario
        // Crear FormData a partir del formulario
        const formDataTransporte = new FormData(event.target);
        // Agregar datos adicionales
        formDataTransporte.append('idFormulario', idFormularioS); // Dato adicional
        console.log(idFormularioS);
        $.ajax({
            url: "../php/transporte.php",
            type: "POST",
            data: formDataTransporte,
            processData: false,  // Evita que jQuery procese los datos
            contentType: false,  // Permite que el navegador establezca el encabezado correcto
            cache: false,
            success: (respAX) => {
                //convertimos la respuesta del servidor a un objeto JSON
                let respAjax = JSON.parse(respAX);
                // Aquí puedes verificar la respuesta del servidor y realizar acciones en consecuencia
                if (respAjax.status === "success") {
                    // Si la respuesta indica éxito, muestra SweetAlert
                    //localStorage.setItem('usuario', JSON.stringify(respAjax.datos));
                    //sessionStorage.removeItem('carritoSesion');
                    showSuccesModal();
                    //Swal.fire({
                        //title: "Respuestas registradas",
                        //text: `Sus respuestas han sido registradas`,
                        //icon: "success"
                    //});
                }else{
                    showErrorModal("Ocurrió un error inesperado. Inténtelo de nuevo más tarde.");
                    //Swal.fire({
                        //title: "Respuestas No registradas",
                        //text: `Sus respuestas no han sido registradas, intentelo más tarde`,
                        //icon: "error"
                    //});
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
    /*Colocar una bandera que indique si el usuario por lo menos ha hecho click
    una vez en el boton de guardar respuestas parciales, esto con el fin
    de sabes si vamos a insertar o a actualizar un registro*/
    //validar los datos del formulario de hospedaje:
    const ValidarHospedaje= new JustValidate('#hospedajeForm');
    ValidarHospedaje
    .addField("#prioridad-hospedaje",[
        {
            rule: 'required',
            errorMessage: "Selecciona la prioridad"
        },
        {
            rule:"number",
            errorMessage:"Solo números"
        },
    ])
    .addRequiredGroup('#advanced-usage_communication_checkbox_group',
        'Selecciona al menos una opción'
      )
    .addField("#Pres-Hospedaje",[
        {
            rule:"required",
            errorMessage:"Introduce el presupuesto aproximado"
        },
        {
            rule:"number",
            errorMessage:"Solo numeros"
        },
    ])
    .onSuccess((event) => {
        event.preventDefault(); // Evita el envío estándar del formulario
        // Crear FormData a partir del formulario
        const formDataHospedaje = new FormData(event.target);
        // Agregar datos adicionales
        formDataHospedaje.append('idFormulario', idFormularioS); // Dato adicional
        $.ajax({
            url: "../php/hospedaje.php",
            type: "POST",
            data: formDataHospedaje,
            processData: false,  // Evita que jQuery procese los datos
            contentType: false,  // Permite que el navegador establezca el encabezado correcto
            cache: false,
            success: (respAX) => {
                //convertimos la respuesta del servidor a un objeto JSON
                let respAjax = JSON.parse(respAX);
                // Aquí puedes verificar la respuesta del servidor y realizar acciones en consecuencia
                if (respAjax.status === "success") {
                    // Si la respuesta indica éxito, muestra SweetAlert
                    //localStorage.setItem('usuario', JSON.stringify(respAjax.datos));
                    //sessionStorage.removeItem('carritoSesion');
                    showSuccesModal();
                }else{
                    showErrorModal("Ocurrió un error inesperado. Inténtelo de nuevo más tarde.");
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

    //validar los datos del formulario de comida:
    const ValidarComida= new JustValidate('#comidaForm');
    ValidarComida
    .addField("#prioridad-comida",[
        {
            rule: 'required',
            errorMessage: "Selecciona la prioridad"
        },
        {
            rule:"number",
            errorMessage:"Solo números"
        },
    ])
    .addRequiredGroup('#comidaCheckbox', 'Selecciona al menos una opción')
    .addField("#Pres-Comida",[
        {
            rule:"required",
            errorMessage:"Introduce el presupuesto aproximado"
        },
        {
            rule:"number",
            errorMessage:"Solo numeros"
        },
    ])
    .onSuccess((event) => {
        event.preventDefault(); // Evita el envío estándar del formulario
        // Crear FormData a partir del formulario
        const formDataComida = new FormData(event.target);
        // Agregar datos adicionales
         formDataComida.append('idFormulario', idFormularioS); // Dato adicional
        $.ajax({
            url: "../php/comida.php",
            type: "POST",
            data: formDataComida,
            processData: false,  // Evita que jQuery procese los datos
            contentType: false,  // Permite que el navegador establezca el encabezado correcto
            cache: false,
            success: (respAX) => {
                //convertimos la respuesta del servidor a un objeto JSON
                let respAjax = JSON.parse(respAX);
               // Aquí puedes verificar la respuesta del servidor y realizar acciones en consecuencia
               if (respAjax.status === "success") {
                // Si la respuesta indica éxito, muestra SweetAlert
                //localStorage.setItem('usuario', JSON.stringify(respAjax.datos));
                //sessionStorage.removeItem('carritoSesion');
                showSuccesModal();
            }else{
                showErrorModal("Ocurrió un error inesperado. Inténtelo de nuevo más tarde.");
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

    //validar los datos del formulario de actividades:
    const ValidarActividades= new JustValidate('#ActividadesForm');
    ValidarActividades
    .addField("#prioridad-act",[
        {
            rule: 'required',
            errorMessage: "Selecciona la prioridad"
        },
        {
            rule:"number",
            errorMessage:"Solo números"
        },
    ])
    .addRequiredGroup('#TipoActividadesRadio', 'Selecciona una opción')
    .addRequiredGroup('#actividadesCheckbox', 'Selecciona al menos una opción')
    .addField("#Pres-Act",[
        {
            rule:"required",
            errorMessage:"Introduce el presupuesto aproximado"
        },
        {
            rule:"number",
            errorMessage:"Solo numeros"
        },
    ])
    .onSuccess((event) => {
        event.preventDefault(); // Evita el envío estándar del formulario
        event.preventDefault(); // Evita el envío estándar del formulario
        // Crear FormData a partir del formulario
        const formDataActividades = new FormData(event.target);
        // Agregar datos adicionales
        formDataActividades.append('idFormulario', idFormularioS); // Dato adicional
        $.ajax({
            url: "../php/actividades.php",
            type: "POST",
            data: formDataActividades,
            processData: false,  // Evita que jQuery procese los datos
            contentType: false,  // Permite que el navegador establezca el encabezado correcto
            cache: false,
            success: (respAX) => {
                //convertimos la respuesta del servidor a un objeto JSON
                let respAjax = JSON.parse(respAX);
               // Aquí puedes verificar la respuesta del servidor y realizar acciones en consecuencia
               if (respAjax.status === "success") {
                // Si la respuesta indica éxito, muestra SweetAlert
                //localStorage.setItem('usuario', JSON.stringify(respAjax.datos));
                //sessionStorage.removeItem('carritoSesion');
                showSuccesModal();
            }else{
                showErrorModal("Ocurrió un error inesperado. Respuestas No registradas. Inténtelo de nuevo más tarde.");
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

    // Actualizar lo visible del formulario
    function showStep(step) {
        // Mostrar solo el paso actual
        steps.forEach((section) => {
            section.classList.add('hidden');
        });
        document.querySelector(`.Paso${step}`).classList.remove('hidden');
    
        // Actualizar indicadores de pasos
        stepIndicators.forEach((element, index) => {
            element.classList.remove('active');
            if (index < step - 1) {
                element.classList.add('completed');
            }
        });
        stepIndicators[step - 1].classList.add('active');
    
        // Habilitar botones según el paso
        btnPrev.style.display = step === 1 ? 'none' : 'inline-block';
        btnNext.style.display = step === totalSteps ? 'none' : 'inline-block';
        btnSave.style.display = step === totalSteps ? 'inline-block' : 'none';
    }
    

    // Siguiente paso si las entradas son correctas
    function validateStep() {
        switch (currentStep) {
            case 1:
                // Se valida el formulario de viaje para poder pasar al siguiente paso
                ValidarPresuppuesto.revalidate().then(isValid => {
                    if (isValid) {
                        if (currentStep < totalSteps) {
                            currentStep++;
                            showStep(currentStep);
                        }
                    }
                });
                break;
            case 2:
                // Se valida el formulario de transporte para poder pasar al siguiente paso
                ValidarTransporte.revalidate().then(isValid => {
                    if (isValid) {
                        if (currentStep < totalSteps) {
                            currentStep++;
                            showStep(currentStep);
                        }
                    }
                });
                break;
            case 3:
                // Se valida el formulario de hospedaje para poder pasar al siguiente paso
                ValidarHospedaje.revalidate().then(isValid => {
                    if (isValid) {
                        if (currentStep < totalSteps) {
                            currentStep++;
                            showStep(currentStep);
                        }
                    }
                });
                break;
            case 4:
                // Se valida el formulario de comida para poder pasar al siguiente paso
                ValidarComida.revalidate().then(isValid => {
                    if (isValid) {
                        if (currentStep < totalSteps) {
                            currentStep++;
                            showStep(currentStep);
                        }
                    }
                });
                break;
        }
    }
    // Paso siguiente
    function nextStep() {
        if (currentStep < totalSteps) {
            currentStep++;
            showStep(currentStep);
        }
    }   

    // Paso anterior
    function previousStep() {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    }

    function goToStep(step) {
        if (step >= 1 && step <= totalSteps) {
            currentStep = step;
            showStep(currentStep);
        }
    }
    



    //Verifica que al guardar las respuestas parciales esten validados todos los inputs para pasar al siguiente formulario
    btnRespParciales.forEach(btn => {
        btn.addEventListener("click", validateStep);
    });

    // Función para botón "siguiente"
    btnNext.addEventListener("click", nextStep);
    // Función para botón "Anterior"
    btnPrev.addEventListener("click", previousStep);

    // Para los numeros
    stepIndicators.forEach((indicator, index) => {
        indicator.addEventListener("click", () => {
            goToStep(index + 1); 
        });
    });

    //Actualizar el valor seleccionado en la barra de prioridad del transporte
    inputPrioridadTransporte.addEventListener('input', function() {
        spanValorTransporte.textContent = inputPrioridadTransporte.value;
    });
    //Actualizar el valor seleccionado en la barra de prioridad del hospedaje
    inputPrioridadHospedaje.addEventListener('input', function() {
        spanValorHospedaje.textContent = inputPrioridadHospedaje.value;
    });
    //Actualizar el valor seleccionado en la barra de prioridad de comida
    inputPrioridadComida.addEventListener('input', function() {
        spanValorComida.textContent = inputPrioridadComida.value;
    });
    //Actualizar el valor seleccionado en la barra de prioridad de actividades
    inputPrioridadActividades.addEventListener('input', function() {
        spanValorActividades.textContent = inputPrioridadActividades.value;
    });
    showStep(currentStep);
});
