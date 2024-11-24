<?php

// Iniciar la sesión
session_start();

// Incluir la conexión a la base de datos
include "./BasedeDatos/php/Conexion_base_datos.php";

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['email'])) {
    // Si no está iniciada la sesión, redirige a la página de inicio de sesión
    header("Location: ./inicio_sesion/html/login.php");
    exit();
}


// Inicializar la variable del nombre del usuario
$nombre_usuario = "";

// Obtener el email del usuario desde la sesión
$email = $_SESSION['email'];

// Preparar y ejecutar la consulta para obtener el nombre
$stmt = $conn->prepare("SELECT Usuario FROM usuario WHERE Correo = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($nombre_usuario);
$stmt->fetch();
$stmt->close();

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turismo 404</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="icon" href="inimgs/pest.png" type="image/x-icon">
    <link rel="stylesheet" href="./navbar/css/navbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    
</head>

<body>
    <header>
        <!-- Barra de menú -->
        <div class="menu conta">
            <div class="sub-izq">
                <!--Botón de hamburguesa-->
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                    <img src="./inimgs/menu.png" alt="Menú">
                </button>
                <a href="index.php" class="logo">
                    <img src="./inimgs/logo.png" class="menu-icono" alt="Logo">
                </a>
                <h1>Turismo 404</h1>
            </div>

            <!-- Barra de búsqueda-->
            <div class="input-group busqueda">
                <input class="form-control" type="search" placeholder="Búsqueda" aria-label="Search">
                <button class="btn btn-light" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                        <path d="M21 21l-6 -6" />
                    </svg>
                </button>
            </div>

            <!-- Iconos -->
            <div class="submenu">
                <img src="./inimgs/notif.png" alt="Notificaciones" class="notif-icon" onclick="toggleNotifications()">
                <a href="clima/clima.html">
                    <img src="./inimgs/clima.png" alt="Clima">
                </a>
                <a href="./editarperfil/php/editarperfil.php">
                    <img src="./inimgs/user.png" alt="Usuario" class="menu-iconoUs">
                </a>
                <a href="./php/cerrar_sesion.php">
                    <img src="./inimgs/cerrar.png" alt="cerrar">
                </a>
            </div>

            <!--Cuadro de notificaciones-->
            <div id="notifications" class="notifications-dropdown">
                <ul>
                    <li><span>Tu itinerario está pendiente.</span></li>
                    <li><span>¡Recuerda configurar tus preferencias!</span></li>
                </ul>
                <button class="btn-notif" onclick="window.location.href='notificaciones/notificaciones.html';">Ver todas</button>
            </div>

            <!-- Desplegable -->
            <div class="offcanvas offcanvas-start custom-offcanvas" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title">MENÚ</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="nav-list">
                        <li class="nav-item">
                            <a href="favoritos.html">
                                <img src="./inimgs/star.png" alt="Favoritos" class="icon"> 
                                <div class="text-container">
                                    <span class="item-title">Favoritos</span>
                                    <span class="item-subtitle">Revisa tus lugares favoritos</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./historial/historial.html">
                                <img src="./inimgs/clock.png" alt="Historial" class="icon"> 
                                <div class="text-container">
                                    <span class="item-title">Historial</span>
                                    <span class="item-subtitle">Historial de itinerarios creados</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./editarperfil/php/editarperfil.php">
                                <img src="./inimgs/edituser.png" alt="Editar cuenta" class="icon"> 
                                <div class="text-container">
                                    <span class="item-title">Editar cuenta</span>
                                    <span class="item-subtitle">Edita detalles de tu cuenta</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./formulario/html/Formulario.html">
                                <img src="./inimgs/add.png" alt="Crear itinerario" class="icon"> 
                                <div class="text-container">
                                    <span class="item-title">Crear itinerario</span>
                                    <span class="item-subtitle">Crea un nuevo itinerario</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="logout.html">
                                <img src="./inimgs/logout.png" alt="Cerrar sesión" class="icon"> 
                                <div class="text-container">
                                    <span class="item-title">Cerrar sesión</span>
                                    <span class="item-subtitle">Salir de la cuenta</span>
                                </div>
                            </a>
                        </li>                                
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <!-- Saludo al usuario -->
    <div class="saludo-usuario contenedor">
        <h2>¡Hola, <?php echo htmlspecialchars($nombre_usuario); ?>!</h2>
    </div>

    <section class="container-sm mt-4 imgviaje sombra w-75">
        <div class="contenidoViajeNuevo">
            <a class="btn btn-viaje" href="formulario/html/Formulario.html">Nuevo Viaje</a>
        </div>
    </section>
    <!-- Recomendados -->
    <section class="container-sm w-75">
        <h2>Recomendado</h2>
        <div class="recomendados container-sm w-100">
            <!-- Swiper -->
            <div class="swiper mySwiper justify-content-evenly">
                <div class="swiper-button-next col-sm-1"></div>
                <div class="swiper-button-prev col-sm-1"></div>
                <div class="swiper-wrapper col-sm-10">
                    <div class="swiper-slide">
                        <div class="review-card" onclick="location.href='itinerario/html/infolugar.html'">
                            <div class="stars">★★★★★</div>
                            <div class="hotel-name">Hotel CasaNova</div>
                            <div class="review-body">Review body</div>
                            <div class="reviewer-info">
                                <img src="https://via.placeholder.com/32" alt="Reviewer">
                                <div>
                                    <div class="reviewer-name">Reviewer name</div>
                                    <div class="review-date">Date</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="review-card" onclick="location.href='itinerario/html/infolugar.html'">
                            <div class="stars">★★★★★</div>
                            <div class="hotel-name">Hotel CasaNova</div>
                            <div class="review-body">Review body</div>
                            <div class="reviewer-info">
                                <img src="https://via.placeholder.com/32" alt="Reviewer">
                                <div>
                                    <div class="reviewer-name">Reviewer name</div>
                                    <div class="review-date">Date</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="review-card" onclick="location.href='itinerario/html/infolugar.html'">
                            <div class="stars">★★★★★</div>
                            <div class="hotel-name">Hotel CasaNova</div>
                            <div class="review-body">Review body</div>
                            <div class="reviewer-info">
                                <img src="https://via.placeholder.com/32" alt="Reviewer">
                                <div>
                                    <div class="reviewer-name">Reviewer name</div>
                                    <div class="review-date">Date</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="review-card" onclick="location.href='itinerario/html/infolugar.html'">
                            <div class="stars">★★★★★</div>
                            <div class="hotel-name">Hotel CasaNova</div>
                            <div class="review-body">Review body</div>
                            <div class="reviewer-info">
                                <img src="https://via.placeholder.com/32" alt="Reviewer">
                                <div>
                                    <div class="reviewer-name">Reviewer name</div>
                                    <div class="review-date">Date</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="review-card" onclick="location.href='itinerario/html/infolugar.html'">
                            <div class="stars">★★★★★</div>
                            <div class="hotel-name">Hotel CasaNova</div>
                            <div class="review-body">Review body</div>
                            <div class="reviewer-info">
                                <img src="https://via.placeholder.com/32" alt="Reviewer">
                                <div>
                                    <div class="reviewer-name">Reviewer name</div>
                                    <div class="review-date">Date</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="review-card" onclick="location.href='itinerario/html/infolugar.html'">
                            <div class="stars">★★★★★</div>
                            <div class="hotel-name">Hotel CasaNova</div>
                            <div class="review-body">Review body</div>
                            <div class="reviewer-info">
                                <img src="https://via.placeholder.com/32" alt="Reviewer">
                                <div>
                                    <div class="reviewer-name">Reviewer name</div>
                                    <div class="review-date">Date</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="review-card" onclick="location.href='itinerario/html/infolugar.html'">
                            <div class="stars">★★★★★</div>
                            <div class="hotel-name">Hotel CasaNova</div>
                            <div class="review-body">Review body</div>
                            <div class="reviewer-info">
                                <img src="https://via.placeholder.com/32" alt="Reviewer">
                                <div>
                                    <div class="reviewer-name">Reviewer name</div>
                                    <div class="review-date">Date</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="review-card" onclick="location.href='itinerario/html/infolugar.html'">
                            <div class="stars">★★★★★</div>
                            <div class="hotel-name">Hotel CasaNova</div>
                            <div class="review-body">Review body</div>
                            <div class="reviewer-info">
                                <img src="https://via.placeholder.com/32" alt="Reviewer">
                                <div>
                                    <div class="reviewer-name">Reviewer name</div>
                                    <div class="review-date">Date</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="review-card" onclick="location.href='itinerario/html/infolugar.html'">
                            <div class="stars">★★★★★</div>
                            <div class="hotel-name">Hotel CasaNova</div>
                            <div class="review-body">Review body</div>
                            <div class="reviewer-info">
                                <img src="https://via.placeholder.com/32" alt="Reviewer">
                                <div>
                                    <div class="reviewer-name">Reviewer name</div>
                                    <div class="review-date">Date</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    
    <section class="container mb-5 mt-4 w-75">
        <div>
            <h2>Historial de Itinerarios</h2>
            <p>Aquí están los planes de viajes creados anteriormente.</p>
        </div>
        <div class="container-fluid">
            <div class="d-flex row gap-4">
                <div class="col-lg-3 card">
                    <div class="contImagen">
                        <img src="./img/card1.jpg" class="card-img-top" alt="...">
                    </div>
                    
                    <div class="card-body">
                        <h5 class="card-title">Bares en Zacatenco</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="historial/itinerantes.html" class="btn  btnColor">Go somewhere</a>
                    </div>
                </div>
                <div class=" col-lg-3 card">
                    <div class="contImagen">
                        <img src="./img/card2.jpg" class="card-img-top" alt="...">
                    </div>
                    <div class="card-body">
                    <h5 class="card-title">Veracruz</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="historial/itinerantes.html" class="btn  btnColor">Go somewhere</a>
                    </div>
                </div>
                <div class="col-lg-3 card">
                    <div class="contImagen">
                        <img src="./img/card4.jpg" class="card-img-top" alt="...">
                    </div>
                    <div class="card-body">
                    <h5 class="card-title">Museos en CDMX</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="historial/itinerantes.html" class="btn  btnColor">Go somewhere</a>
                    </div>
                </div>
                <div class="col-lg-2 align-content-center">
                    <a class="boton-historial" href="historial/historial.html">Ver todo</a>
                </div>
            </div>
        </div>
        
    </section>

    <footer class="footer">
    <!-- Redes Sociales -->
    <div class="footer-social">
        <a href="#"><img src="./inimgs/ig.png" alt="Instagram"></a>
        <a href="#"><img src="./inimgs/fb.png" alt="Facebook"></a>
        <a href="#"><img src="./inimgs/x.png" alt="X"></a>
    </div>

    <!-- Sección de Enlaces -->
    <div class="footer-content">
        <div class="footer-column">
            <p>Correo: admin404@turismo.com</p>
            <p>Teléfono: +52 5512345674</p>
        </div>
        <div class="footer-column">
            <img src="./inimgs/logo.png" alt="Logo" class="footer-logo">
        </div>
        <div class="footer-column">
            <a href="faq.html">Preguntas frecuentes</a>
            <a href="itinerarios.html">Mis itinerarios</a>
        </div>
    </div>

    <!-- Hasta abajo -->
    <div class="footer-copyright">
        <p>&copy; Copyright: Turismo404</p>
    </div>
    </footer>

    <script src="./js/bootstrap.bundle.min.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="./navbar/js/navbar.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
