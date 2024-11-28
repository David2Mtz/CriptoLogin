
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turismo404</title>
    <link rel="stylesheet" href="../css/signup.css">
    <link rel="icon" href="../../inimgs/pest.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/error.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header>
        <!-- Aquí puedes agregar el encabezado de tu página, como el logo o la navegación principal -->
    </header>

    <main>
        <section class="login-container">
            <div class="welcome-column">
                <div class="welcome-content">
                    <div class="registrate-container">
                        <p class="registrate-password">¿Ya tienes una cuenta?</p>
                        <a href="../html/login.php" class="registrate-link">Inicia Sesión</a>
                    </div>
                    <h2 class="welcome-message">¡Sé parte de la mejor experiencia!</h2>
                    <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/d79709c8da7177657615c71b425971a94b1de76f25bb80e01dd93736c4c7ed9a?placeholderIfAbsent=true&apiKey=6e7bc380e91e466e8c33b15a363aec18" alt="Welcome illustration" class="welcome-image">
                </div>
            </div>

            <div class="login-form-column col-md-6 d-flex justify-content-center align-items-center">
                <form id="FormRegistro" class="login-form w-100"  method="POST">
                    <div class="iniciarseesion mb-3 text-center"> Regístrate </div>
                    
                    <div class="row g-3 mb-3 flex-row">
                        <div class="flex-item">
                            <label for="usuario" class="form-label">Usuario*:</label>
                            <input type="text" name="usuario" id="usuario" class="form-input form-control" placeholder="Ingresa un nombre de usuario">
                            <small id="usuarioError" class="form-label text-danger" style="display: none;"></small>
                        </div>
                    </div>
                    <div class="row g-3 mb-3 flex-row">
                        <div>
                            <label for="email" class="form-label">Correo electrónico*:</label>
                            <input type="email" name="email" id="email" class="form-input form-control" placeholder="Ingresa tu correo">
                            <small id="emailError" class="form-label text-danger" style="display: none;"></small>
                        </div>
                    </div>
                    <div class="row g-3 mb-3 flex-row">
                        <div class="flex-item">
                            <label for="password" class="form-label">Contraseña*:</label>
                            <input type="password" name="password" id="password" class="form-input form-control" placeholder="Ingresa tu contraseña">
                            <small id="passwordError" class="form-label text-danger" style="display: none;"></small>
                        </div>
                        <div class="flex-item">
                            <label for="confirm_password" class="form-label">Confirmar contraseña*:</label>
                            <input type="password" id="confirm_password" class="form-input form-control" placeholder="Ingresa tu contraseña otra vez">
                            <small id="confirmPasswordError" class="form-label text-danger" style="display: none;"></small>
                        </div>
                    </div>

                    
                <!-- Botón de envío original -->
                <button type="submit" class="login-button btn btn-primary w-100">Registrar</button>
                </form>
            </div>
        </section>
    </main>

    <footer>
        <!-- Pie de página con información adicional, enlaces o derechos de autor -->
    </footer>
    <!-- Div Modal / mensajes emergentes -->
    <!-- Div Modal / mensajes emergentes -->
    <!-- Modal Error -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Upps! Parece que hubo un error</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-8 d-lg-flex align-items-center">
                    <div class="textError" id="errorModalBody">
  
                    </div><!-- Mensaje de error irá aquí -->
                </div>
                <div class="col-lg-4 ms-auto contErrorImg">
                    <!-- Foto de mascota error -->
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
    </div>

    <!-- Modal Confirmacion -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="confirmationModalLabel">¡Registro Exitoso!</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-8 d-lg-flex align-items-center">
                    <div class="textError" id="successModalBody">
  
                    </div><!-- Mensaje de confirmacion-->
                </div>
                <div class="col-lg-4 ms-auto contSuccesImg">
                    <!-- Foto de mascota error -->
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" id="btnSuccess" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
    </div>

    <!-- Contenedor para el mensaje de carga -->
    <div id="loadingMessage" class="d-none text-center position-fixed top-50 start-50 translate-middle">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Cargando...</span>
        </div>
        <p>Cargando...</p>
    </div>
    <!-- Incluye CryptoJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script><!--Esta libreria incluye el SH2-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/signup.js"></script>
</body>
</html>
