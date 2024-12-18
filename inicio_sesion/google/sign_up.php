<?php
require_once '../../vendor/autoload.php';
require_once 'config_google.php';

$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Título Aquí</title>
    <link rel="stylesheet" href="../css/signup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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
                        <p class="registrate-password">¿Ya tienes cuenta?</p>
                        <a href="./login.html" class="registrate-link">Inicia Sesión</a>
                    </div>
                    <h2 class="welcome-message">¡Sé parte de la mejor experiencia!</h2>
                    <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/d79709c8da7177657615c71b425971a94b1de76f25bb80e01dd93736c4c7ed9a?placeholderIfAbsent=true&apiKey=6e7bc380e91e466e8c33b15a363aec18" alt="Welcome illustration" class="welcome-image">
                </div>
            </div>

            <div class="login-form-column">
                
                <form class="login-form" action="signup_correo.php" method="POST"> <!-- Asegúrate de que el action sea correcto -->
                    <div class="iniciarseesion"> Regístrate </div>
                    
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-input" placeholder="Ingresa tu nombre" required>

                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" name="apellido" id="apellido" class="form-input" placeholder="Ingresa tu apellido" required>

                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" name="email" id="email" class="form-input" placeholder="Ingresa tu correo" required>

                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-input" placeholder="Ingresa tu contraseña" required>

                    <!-- Fila para país, código LADA, y número de teléfono -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="country" class="form-label">País</label>
                            <select name="country" id="country" class="form-input" required>
                                <option value="">Selecciona tu país</option>
                                <option value="MX">México</option>
                                <option value="US">Estados Unidos</option>
                                <option value="CA">Canadá</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="lada" class="form-label">Código LADA</label>
                            <select name="lada" id="lada" class="form-input" required>
                                <option value="">LADA</option>
                                <option value="+52">+52</option>
                                <option value="+1">+1</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="phone" class="form-label">Número de Teléfono</label>
                            <input type="tel" name="phone" id="phone" class="form-input" placeholder="Número" required>
                        </div>
                    </div>

                    <!-- Fila para fecha de nacimiento y género -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="birthdate" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" name="birthdate" id="birthdate" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label for="gender" class="form-label">Género</label>
                            <select name="gender" id="gender" class="form-input" required>
                                <option value="">Selecciona tu género</option>
                                <option value="femenino">Femenino</option>
                                <option value="masculino">Masculino</option>
                                <option value="no-binario">No Binario</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="login-button">Entrar</button>
                    
                    <div class="or-divider">- OR -</div>
                    
                    <?php echo "<a href='" . $client->createAuthUrl() . "' class='google-login-button'>"; ?>
                        <i class="fa-brands fa-google" style="color: #A13C64; font-size: 30px;"></i>
                    </a>
                    
                </form>
            </div>
        </section>
    </main>

    <footer>
        <!-- Pie de página con información adicional, enlaces o derechos de autor -->
    </footer>
</body>
</html>
