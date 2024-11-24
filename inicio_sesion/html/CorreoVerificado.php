<?php

// Iniciar la sesión
session_start();

// Incluir la conexión a la base de datos
include "../../BasedeDatos/php/Conexion_base_datos.php";


// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/nuevaContra.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <main class="container-fluid">
        
    </main>
    <footer>
        <!-- Pie de página con información adicional, enlaces o derechos de autor -->
    </footer>
    <!-- Modal confirmacion para token-->
    <div class="modal fade" id="succesModalToken" tabindex="-1" aria-labelledby="succesModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header colorprincipal">
            <h1 class="modal-title fs-5" id="succesModalLabel">Sólo un paso más</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="d-lg-flex align-items-center">
                <div id="succesModalBody">
                  <div class="d-flex">
                    <h6 id="modalMessageToken" class="mensajeModalConfirmacion">1<!-- Aquí se inserta el mensaje de confirmacion --></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
            
          </div>
        </div>
      </div>
  </div>
  <!-- Modal confirmacion para confirmacion-->
  <div class="modal fade" id="succesModal" tabindex="-1" aria-labelledby="succesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header colorprincipal">
          <h1 class="modal-title fs-5" id="succesModalLabel">Sólo un paso más</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="d-lg-flex align-items-center">
              <div id="succesModalBody">
                <div class="d-flex">
                  <h6 id="modalMessage" class="mensajeModalConfirmacion">1<!-- Aquí se inserta el mensaje de confirmacion --></h6>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="btn_conf" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
          
        </div>
      </div>
    </div>
</div>
    <!-- Div Modal / mensajes de error -->
    <!-- Modal -->
  <div id="ErroresModal"></div>
     <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
     <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>
      <script src="../../js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../error/error.js"></script>
    <script src="../js/correoVerificado.js"></script>
</body>
</html>