<?php
#Incluimos el archivo de conexion a la base deatos
include "../../BasedeDatos/php/Conexion_base_datos.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inicia la sesión
session_start();
// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['email'])) {
    // Si no está iniciada la sesión, redirige a la página de inicio de sesión
    header("Location: ../../inicio_sesion/html/login.php");
    exit();
}

// Inicializar la variable para los datos del usuario
$usuario = [];

// Obtener el email del usuario desde la sesión
$email = $_SESSION['email'];

// Preparar y ejecutar la consulta para obtener los datos del usuario
$stmt = $conn->prepare("SELECT idUsuario, Nombre, Apellidos, NumCel, Pais, Biografia, Nacimiento, Genero FROM usuario WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($idUsuario, $nombre, $apellidos, $celular, $pais, $biografia, $nacimiento, $genero);
$stmt->fetch();
$stmt->close();
/* Para David*/
// Convertir la fecha de nacimiento a formato adecuado para el campo de entrada
$nacimiento_formateado = date("Y-m-d", strtotime($nacimiento));

// Comprobar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Recibimos los datos del formulario
    $NOMBRE = $_POST["nombre"];
    $APELLIDOS = $_POST["apellido"];
    //$CELULAR = $_POST["telefono"];
    $CELULAR = $_POST["phone"];
    $NACIMIENTO = $_POST["fecha_nacimiento"];
    $PAIS = $_POST["selectPais"];
    $GENERO = $_POST["genero"];
    $BIOGRAFIA = $_POST["biografia"];
    $ID        = $_POST["user_id"];

    // Convertir la fecha a AAAA-MM-DD para la base de datos
    $FECHA = date("Y-m-d", strtotime(str_replace('/', '-', $NACIMIENTO)));
    //Verificar que se estan llegando  los datos
    //print($NOMBRE);

    // Actualizar el registro en la base de datos
    $sql = "UPDATE usuario SET Nombre = ?, Apellidos = ?, NumCel = ?,Pais = ?,Biografia = ?, Nacimiento = ?, Genero = ?  WHERE idUsuario = ?";

    $stmt = $conn->prepare($sql);

    // Verificar si la consulta fue preparada correctamente
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }
    $stmt->bind_param("sssssssi", $NOMBRE, $APELLIDOS, $CELULAR, $PAIS, $BIOGRAFIA, $FECHA, $GENERO, $ID);

    if ($stmt->execute()) {
        echo "Datos actualizados correctamente.";
    } else {
        echo "Error al actualizar los datos: " . $stmt->error;
    }

    // Cerrar la conexión
    $stmt->close();
    $conexion->close();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Open+Sans:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../navbar/css/navbar.css">
    <link rel="icon" href="../../inimgs/pest.png" type="image/x-icon">
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/editarPerfil.css">
    <link rel="stylesheet" href="../../css/error.css">
</head>

<body>
    <header>
        <!-- Barra de menú -->
        <div class="menu conta">
            <div class="sub-izq">
                <!--Botón de hamburguesa-->
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                    <img src="../../inimgs/menu.png" alt="Menú">
                </button>
                <a href="../../index.php" class="logo">
                    <img src="../../inimgs/logo.png" class="menu-icono" alt="Logo">
                </a>
                <h1>Turismo 404</h1>
            </div>

            <!-- Barra de búsqueda-->
            <div class="input-group busqueda">
                <input class="form-control" type="search" placeholder="Búsqueda" aria-label="Search">
                <button class="btn btn-light" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                        <path d="M21 21l-6 -6" />
                    </svg>
                </button>
            </div>

            <!-- Iconos -->
            <div class="submenu">
                <img src="../../inimgs/notif.png" alt="Notificaciones" class="notif-icon" onclick="toggleNotifications()">
                <a href="clima.html">
                    <img src="../../inimgs/clima.png" alt="Clima">
                </a>
                <a href="../../editarperfil/php/editarperfil.php">
                    <img src="../../inimgs/user.png" alt="Usuario" class="menu-iconoUs">
                </a>
                <a href="../../php/cerrar_sesion.php">
                    <img src="../../inimgs/cerrar.png" alt="cerrar">
                </a>
            </div>

            <!--Cuadro de notificaciones-->
            <div id="notifications" class="notifications-dropdown">
                <ul>
                    <li><span>Recordatorio: Tu itinerario está pendiente.</span></li>
                </ul>
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
                                <img src="../../inimgs/star.png" alt="Favoritos" class="icon">
                                <div class="text-container">
                                    <span class="item-title">Favoritos</span>
                                    <span class="item-subtitle">Revisa tus lugares favoritos</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="historial.html">
                                <img src="../../inimgs/clock.png" alt="Historial" class="icon">
                                <div class="text-container">
                                    <span class="item-title">Historial</span>
                                    <span class="item-subtitle">Historial de itinerarios creados</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../../editarperfil/php/editarperfil.php">
                                <img src="../../inimgs/edituser.png" alt="Editar cuenta" class="icon">
                                <div class="text-container">
                                    <span class="item-title">Editar cuenta</span>
                                    <span class="item-subtitle">Edita detalles de tu cuenta</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../../formulario/html/Formulario.html">
                                <img src="../../inimgs/add.png" alt="Crear itinerario" class="icon">
                                <div class="text-container">
                                    <span class="item-title">Crear itinerario</span>
                                    <span class="item-subtitle">Crea un nuevo itinerario</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../../php/cerrar_sesion.php">
                                <img src="../../inimgs/logout.png" alt="Cerrar sesión" class="icon">
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

    <main>
        <div class="contenedor">
            <div class="pink-background">
                <a class="button back-button" href="../../index.php">
                    <i class="bi bi-arrow-left-circle-fill"></i>
                </a>
            </div>

            <div class="edit-profile">
                <div class="profile-info">
                    <div class="profile-image-container">
                        <img src="../images/user.png" alt="Usuario" class="profile-image-large">
                        <button class="edit-photo-button" id="editPhotoButton">✏️</button>
                    </div>
                    <h2 class="profile-name"><?php echo htmlspecialchars($nombre) ?> <?php echo htmlspecialchars($apellidos) ?></h2>
                    <h3 class="profile-name">Turista</h3>
                    <div class="info-line">
                        <div class="info-icon"><img src="../images/birthday-icon.png" alt="Cumpleaños"></div>
                        <div class="info-text"> <?php echo htmlspecialchars($nacimiento_formateado) ?><span></span></div>
                    </div>
                    <div class="info-line">
                        <div class="info-icon"><img src="../images/email-icon.png" alt="Correo"></div>
                        <div class="info-text"> <?php echo htmlspecialchars($email) ?><span></span></div>
                    </div>
                    <div class="info-line">
                        <div class="info-icon"><img src="../images/phone-icon.png" alt="Teléfono"></div>
                        <div class="info-text"><?php echo htmlspecialchars($celular) ?></div>
                        <div class="info-text"><span></span></div>
                    </div>
                    <div class="info-line">
                        <div class="info-icon"><img src="../images/location-icon.png" alt="Correo"></div>
                        <div class="info-text"> <?php echo htmlspecialchars($pais) ?><span></span></div>
                    </div>
                    <div class="info-line">
                        <div class="info-icon"><img src="../images/location-icon.png" alt="Género"></div>
                        <div class="info-text"> <?php echo htmlspecialchars($genero) ?><span></span></div>
                    </div>
                </div>
                <div class="form-section">
                    <b class="titulo">Editar perfil</b><br>
                    <br>
                    <form id="Editar_Usuario" method="POST" action="editarperfil.php" autocomplete="off" novalidate="novalidate">
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($idUsuario); ?>">
                        <div class="input-grid">
                            <div class="input-grupo">
                                <label for="nombre" class="form-label">Nombre(s):</label>
                                <input type="text" id="nombre" name="nombre" class="form-input form-control" placeholder="Nombre(s)" value="<?php echo htmlspecialchars($nombre) ?>" required>
                                <small id="nombreError" class="form-label text-danger" style="display: none;"></small>
                            </div>
                            <div class="input-grupo">
                                <label for="apellido" class="form-label">Apellido(s):</label>
                                <input type="text" id="apellidos" name="apellido" class="form-input form-control" placeholder="Apellido(s)" value="<?php echo htmlspecialchars($apellidos) ?>" required>
                                <small id="apellidoError" class="form-label text-danger" style="display: none;"></small>
                            </div>
                            <div class="input-grupo">
                                <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento:</label>
                                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-input form-control" value="<?php echo htmlspecialchars($nacimiento_formateado) ?>">
                                <small id="birthdateError" class="form-label text-danger" style="display: none;"></small>
                            </div>
                            <div class="input-grupo">
                                <label for="genero" class="form-label">Género:</label>
                                <select id="genero" name="genero" class="form-input form-control">
                                    <option selected><?php echo htmlspecialchars($genero) ?></option>
                                    <option value="Masculino" <?php if ($genero == "Masculino") echo 'selected'; ?>>Masculino</option>
                                    <option value="Femenino" <?php if ($genero == "Femenino") echo 'selected'; ?>>Femenino</option>
                                    <option value="Otro" <?php if ($genero == "Otro") echo 'selected'; ?>>Otro</option>
                                </select>
                                <small id="generoError" class="form-label text-danger" style="display: none;"></small>
                            </div>
                            <div class="input-grupo">
                                <label for="password" class="form-label">Nueva contraseña:</label>
                                <input type="password" name="password" id="password" class="form-input form-control" placeholder="Ingresa tu contraseña" required>
                                <small id="passwordError" class="form-label text-danger" style="display: none;"></small>
                            </div>
                            <div class="input-grupo">
                                <label for="confirm_password" class="form-label">Confirmar contraseña:</label>
                                <input type="password" id="confirm_password" class="form-input form-control" placeholder="Ingresa tu contraseña otra vez" required>
                                <small id="confirmPasswordError" class="form-label text-danger" style="display: none;"></small>
                            </div>
                            <div class="input-grupo">
                                <label for="selectPais" class="form-label">País:</label>
                                <div class="d-flex align-items-center">
                                    <img id="flagIcon" src="" alt="Bandera" style="width: 25px; height: 18px; margin-right: 5px; display: none;">
                                    <select id="selectPais" name="selectPais" class="form-input form-control" value="<?php echo htmlspecialchars($pais) ?>" required></select>
                                    <small id="paisError" class="form-label text-danger" style="display: none;"></small>
                                </div>
                            </div><br>
                            <div class="input-grupo">
                                <label for="lada" class="form-label">Código de marcación:</label>
                                <input type="text" id="lada" name="lada" class="form-input form-control" value="<?php echo htmlspecialchars($pais) ?>" placeholder="Código lada" readonly>
                            </div>
                            <div class="input-grupo">
                                <label for="phone" class="form-label">Número telefónico:</label>
                                <input type="tel" id="phone" name="phone" class="form-input form-control" value="<?php echo htmlspecialchars($celular) ?>" placeholder="Ingresa el número telefónico" pattern="\d{10}" maxlength="10" required>
                                <small id="phoneError" class="form-label text-danger" style="display: none;">Número de teléfono no válido</small>
                            </div>
                        </div>
                        <br>
                        <div class="input-grupo">
                            <label for="biografia" class="form-label">Biografía:</label>
                            <textarea id="biografia" name="biografia" class="form-input form-control" placeholder="Escribe algo sobre ti..." value=""><?php echo htmlspecialchars($biografia) ?></textarea>
                            <small id="biografiaError" class="form-label text-danger" style="display: none;"></small>
                        </div>
                        <div class="button-group">
                            <button type="submit" class="save-button">Guardar</button>
                            <button type="button" class="delete-account-button">Desactivar cuenta</button>
                            <button type="button" class="edit-preferences-button" id="editPreferencesButton">Preferencias</button>
                        </div>
                    </form>
                </div>

    </main>
    <div id="preferencesModal" class="modalA">
        <div class="modal-contentA">
            <span class="close-button">&times;</span>
            <b class="titulo">Selecciona tus preferencias:</b><br>

            <!-- 1. Cultura y Patrimonio -->
            <div class="category">
                <h4><img src="../images/categoryimg/cultural.png" alt="Cultura Icon" class="category-icon"> Cultura y Patrimonio
                    <input type="checkbox" onclick="toggleSubcategories('cultura')">
                </h4>
                <div id="cultura" class="subcategory hidden">
                    <label><input type="checkbox" onclick="toggleSubcategories('museos')"> Museos</label>
                    <div id="museos" class="sub-subcategory hidden">
                        <label><input type="checkbox"> Arte</label>
                        <label><input type="checkbox"> Historia</label>
                        <label><input type="checkbox"> Arqueológico</label>
                        <label><input type="checkbox"> Ciencia y tecnología</label>
                        <label><input type="checkbox"> Infantil</label>
                        <label><input type="checkbox"> Fotografía y diseño</label>
                    </div>
                    <label><input type="checkbox"> Monumentos y Edificios Históricos</label>
                    <label><input type="checkbox"> Zonas Arqueológicas</label>
                    <label><input type="checkbox"> Bibliotecas y Centros Culturales</label>
                    <label><input type="checkbox"> Rutas Históricas</label>
                </div>
            </div>

            <!-- 2. Religioso -->
            <div class="category">
                <h4><img src="../images/categoryimg/religioso.png" alt="Religioso Icon" class="category-icon"> Religioso
                    <input type="checkbox" onclick="toggleSubcategories('religioso')">
                </h4>
                <div id="religioso" class="subcategory hidden">
                    <label><input type="checkbox"> Iglesias y Catedrales</label>
                    <label><input type="checkbox"> Procesiones y Peregrinaciones</label>
                    <label><input type="checkbox"> Museos y Espacios Religiosos</label>
                    <label><input type="checkbox"> Fiestas patronales</label>
                </div>
            </div>

            <!-- 3. Entretenimiento y Vida Nocturna -->
            <div class="category">
                <h4><img src="../images/categoryimg/entretenimiento.png" alt="Entretenimiento Icon" class="category-icon"> Entretenimiento y Vida Nocturna
                    <input type="checkbox" onclick="toggleSubcategories('entretenimiento')">
                </h4>
                <div id="entretenimiento" class="subcategory hidden">
                    <label><input type="checkbox"> Parques de Diversión</label>
                    <label><input type="checkbox" onclick="toggleSubcategories('eventos')"> Eventos Deportivos</label>
                    <div id="eventos" class="sub-subcategory hidden">
                        <label><input type="checkbox"> Fútbol</label>
                        <label><input type="checkbox"> Béisbol</label>
                        <label><input type="checkbox"> Lucha Libre en la Arena México</label>
                    </div>
                    <label><input type="checkbox"> Conciertos y Festivales de Música</label>
                    <label><input type="checkbox" onclick="toggleSubcategories('vidaNocturna')"> Vida Nocturna</label>
                    <div id="vidaNocturna" class="sub-subcategory hidden">
                        <label><input type="checkbox"> Bares y cantinas tradicionales</label>
                        <label><input type="checkbox"> Antros y discotecas</label>
                        <label><input type="checkbox"> Terrazas</label>
                        <label><input type="checkbox"> Rooftops y lounges en hoteles</label>
                    </div>
                    <label><input type="checkbox"> Cine y Autocinemas</label>
                </div>
            </div>

            <!-- 4. Naturaleza y Aire Libre -->
            <div class="category">
                <h4><img src="../images/categoryimg/naturaleza.png" alt="Naturaleza Icon" class="category-icon"> Naturaleza y Aire Libre
                    <input type="checkbox" onclick="toggleSubcategories('naturaleza')">
                </h4>
                <div id="naturaleza" class="subcategory hidden">
                    <label><input type="checkbox"> Parques y Bosques</label>
                    <label><input type="checkbox"> Áreas Naturales Protegidas</label>
                    <label><input type="checkbox"> Excursionismo y Senderismo</label>
                    <label><input type="checkbox"> Jardines y Áreas Verdes</label>
                    <label><input type="checkbox"> Actividades Acuáticas</label>
                </div>
            </div>

            <!-- 5. Gastronomía y Experiencias Culinarias -->
            <div class="category">
                <h4><img src="../images/categoryimg/gastronomia.png" alt="Gastronomía Icon" class="category-icon"> Gastronomía y Experiencias Culinarias
                    <input type="checkbox" onclick="toggleSubcategories('gastronomia')">
                </h4>
                <div id="gastronomia" class="subcategory hidden">
                    <label><input type="checkbox"> Mercados Tradicionales</label>
                    <label><input type="checkbox"> Rutas Gastronómicas</label>
                    <label><input type="checkbox"> Restaurantes de Comida Mexicana</label>
                    <label><input type="checkbox"> Cafeterías y Chocolaterías</label>
                </div>
            </div>

            <!-- 6. Compras y Artesanías -->
            <div class="category">
                <h4><img src="../images/categoryimg/compras.png" alt="Compras Icon" class="category-icon"> Compras y Artesanías
                    <input type="checkbox" onclick="toggleSubcategories('compras')">
                </h4>
                <div id="compras" class="subcategory hidden">
                    <label><input type="checkbox"> Centros Comerciales</label>
                    <label><input type="checkbox"> Tianguis y Mercados de Artesanías</label>
                    <label><input type="checkbox"> Tianguis Culturales</label>
                    <label><input type="checkbox"> Zonas Comerciales</label>
                </div>
            </div>

            <!-- 7. Bienestar y Relax -->
            <div class="category">
                <h4><img src="../images/categoryimg/relax.png" alt="Relax Icon" class="category-icon"> Bienestar y Relax
                    <input type="checkbox" onclick="toggleSubcategories('bienestar')">
                </h4>
                <div id="bienestar" class="subcategory hidden">
                    <label><input type="checkbox"> Spas y Centros de Bienestar</label>
                    <label><input type="checkbox"> Balnearios y Parques Acuáticos</label>
                    <label><input type="checkbox"> Centros de Yoga y Meditación</label>
                    <label><input type="checkbox"> Jardines para la Relajación</label>
                </div>
            </div>

            <!-- 8. Actividades Familiares y para Niños -->
            <div class="category">
                <h4><img src="../images/categoryimg/aquarium.png" alt="Familiares Icon" class="category-icon"> Actividades Familiares y para Niños
                    <input type="checkbox" onclick="toggleSubcategories('familiares')">
                </h4>
                <div id="familiares" class="subcategory hidden">
                    <label><input type="checkbox"> Zoológicos y Acuarios</label>
                    <label><input type="checkbox"> Museos Interactivos para Niños</label>
                    <label><input type="checkbox"> Parques de Juegos y Áreas Recreativas</label>
                    <label><input type="checkbox"> Talleres y Actividades Educativas</label>
                </div>
            </div>

            <!-- 9. Turismo Alternativo y Urbano -->
            <div class="category">
                <h4><img src="../images/categoryimg/ciclismo.png" alt="Turismo Icon" class="category-icon"> Turismo Alternativo y Urbano
                    <input type="checkbox" onclick="toggleSubcategories('turismo')">
                </h4>
                <div id="turismo" class="subcategory hidden">
                    <label><input type="checkbox"> Arte Urbano y Grafiti</label>
                    <label><input type="checkbox"> Tours Fotográficos</label>
                    <label><input type="checkbox"> Ciclismo Urbano</label>
                    <label><input type="checkbox"> Rutas de Historia y Leyendas</label>
                </div>
            </div>

            <!-- 10. Aventura y Deportes Extremos -->
            <div class="category">
                <h4><img src="../images/categoryimg/deportes.png" alt="Aventura Icon" class="category-icon"> Aventura y Deportes Extremos
                    <input type="checkbox" onclick="toggleSubcategories('aventura')">
                </h4>
                <div id="aventura" class="subcategory hidden">
                    <label><input type="checkbox"> Escalada y Rappel</label>
                    <label><input type="checkbox"> Deportes de Aventura</label>
                    <label><input type="checkbox"> Paracaidismo</label>
                    <label><input type="checkbox"> Vuelo en Globo</label>
                </div>
            </div>

            <button class="save-button2">Guardar Preferencias</button>
        </div>
    </div>

    <footer class="footer">
        <!-- Redes Sociales -->
        <div class="footer-social">
            <a href="#"><img src="../../inimgs/ig.png" alt="Instagram"></a>
            <a href="#"><img src="../../inimgs/fb.png" alt="Facebook"></a>
            <a href="#"><img src="../../inimgs/x.png" alt="X"></a>
        </div>

        <!-- Sección de Enlaces -->
        <div class="footer-content">
            <div class="footer-column">
                <p>Correo: admin404@turismo.com</p>
                <p>Teléfono: +52 5512345674</p>
            </div>
            <div class="footer-column">
                <img src="../../inimgs/logo.png" alt="Logo" class="footer-logo">
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
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="confirmationModalLabel">¡Cambio Exitoso!</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-8 d-lg-flex align-items-center">
                    <p>Cambios guardados exitosamente.</p>
                </div>
                <div class="col-lg-4 ms-auto contSuccesImg">
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

    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script src="../js/editarperfil.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const selectPais = document.getElementById("selectPais");
        const ladaInput = document.getElementById("lada");
        const flagIcon = document.getElementById("flagIcon");

        // Función para actualizar LADA y bandera
        function updateLadaAndFlag(selectedOption) {
            ladaInput.value = selectedOption.dataset.lada || "";
            flagIcon.src = selectedOption.dataset.flag || "";
            flagIcon.style.display = selectedOption.dataset.flag ? "inline" : "none";
        }

        // Cargar los países desde la API
        fetch("https://restcountries.com/v3.1/all")
            .then(response => response.json())
            .then(data => {
                // Ordena los países alfabéticamente
                data.sort((a, b) => a.name.common.localeCompare(b.name.common));

                // Genera las opciones del select
                data.forEach(country => {
                    const option = document.createElement("option");
                    option.value = country.name.common;
                    option.textContent = country.name.common;
                    option.dataset.lada = country.idd.root + (country.idd.suffixes ? country.idd.suffixes[0] : "");
                    option.dataset.flag = country.flags.svg;
                    selectPais.appendChild(option);
                });

                // Si ya hay un país seleccionado, establece el valor en el select y actualiza la LADA y la bandera
                const paisSeleccionado = "<?php echo htmlspecialchars($pais); ?>";
                if (paisSeleccionado) {
                    selectPais.value = paisSeleccionado;
                    updateLadaAndFlag(selectPais.options[selectPais.selectedIndex]);
                }
            })
            .catch(error => console.error("Error al cargar los países:", error));

        // Actualizar LADA y bandera al seleccionar un país
        selectPais.addEventListener("change", function () {
            updateLadaAndFlag(selectPais.options[selectPais.selectedIndex]);
        });
    });
    </script>

</body>

</html>