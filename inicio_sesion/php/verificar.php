<?php
// Incluir la conexión a la base de datos
include '../../BasedeDatos/php/Conexion_base_datos.php';  

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Buscar al usuario en la base de datos con el token proporcionado
    $sql = "SELECT idUsuario, email, verificado FROM usuario WHERE token = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('s', $token);  // Bind del token
        $stmt->execute();
        $stmt->store_result();
        
        // Verificar si el token existe y si el usuario aún no está verificado
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($idUsuario, $email, $verificado);
            $stmt->fetch();
            
            if ($verificado == 0) {
                // Si el usuario no está verificado, marcarlo como verificado
                $update_sql = "UPDATE usuario SET verificado = 1 WHERE idUsuario = ?";
                if ($update_stmt = $conn->prepare($update_sql)) {
                    $update_stmt->bind_param('i', $idUsuario);
                    if ($update_stmt->execute()) {
                        echo "¡Cuenta verificada con éxito! Puedes iniciar sesión ahora.";
                    } else {
                        echo "Error al verificar la cuenta. Inténtalo nuevamente.";
                    }
                }
            } else {
                echo "Esta cuenta ya ha sido verificada.";
            }
        } else {
            echo "Token inválido o expirado.";
        }
        $stmt->close();
    } else {
        echo "Error en la consulta de verificación.";
    }
} else {
    echo "No se recibió el token.";
}

$conn->close();
?>
