<?php
date_default_timezone_set('America/Mexico_City'); // Ajustar la zona horaria
// Configuración de la base de datos
include "../../BasedeDatos/php/Conexion_base_datos.php";
session_start();
header("Content-Type: application/json"); // Configura el encabezado para JSON


// Verificar si se ha enviado el formulario para actualizar la contraseña
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $password = $_POST['password'];

        

        // Actualizar la contraseña en la base de datos
        $sql = "UPDATE usuario SET Password = ?, Token_Password = NULL, Token_Password_Expiracion = NULL WHERE idUsuario = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            echo json_encode(["error" => "Error en la preparación de la consulta para actualizar: " . $conn->error]);
            exit;
        }

        $stmt->bind_param("si", $password, $user_id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Contraseña actualizada correctamente."]);
            unset($_SESSION['user_id']);
        } else {
            echo json_encode(["error" => "Error al actualizar la contraseña."]);
        }
    } else {
        echo json_encode(["error" => "Sesión expirada o no válida. Vuelve a solicitar el enlace de recuperación."]);
    }
}

// Cerrar la conexión
$conn->close();

?>

