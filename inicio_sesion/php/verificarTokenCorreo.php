<?php
date_default_timezone_set('America/Mexico_City'); // Ajustar la zona horaria
// Configuración de la base de datos
include "../../BasedeDatos/php/Conexion_base_datos.php";
session_start();

header("Content-Type: application/json"); // Configura el encabezado para JSON

// Verificación del token en la solicitud GET
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Validar que el token no esté vacío y tenga una longitud esperada
    if (empty($token)) { // Ejemplo: si esperas un token de 32 caracteres
        echo json_encode(["error" => "Token inválido."]);
        exit;
    }

    // Consulta para buscar el token
    $sql = "SELECT idUsuario FROM usuario WHERE Token = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo json_encode(["error" => "Error en la preparación de la consulta: " . $conn->error]);
        exit;
    }

    // Vincular el parámetro y ejecutar la consulta
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    // Verificar si el token existe
    if ($stmt->num_rows > 0) {
        // Obtener el idUsuario
        $stmt->bind_result($idUsuario);
        $stmt->fetch();

        // Actualizar el valor de Valido a 1
        $update_sql = "UPDATE usuario SET Valido = 1 WHERE idUsuario = ?";
        $update_stmt = $conn->prepare($update_sql);

        if ($update_stmt === false) {
            echo json_encode(["error" => "Error al preparar la actualización: " . $conn->error]);
            exit;
        }

        $update_stmt->bind_param("i", $idUsuario);

        if ($update_stmt->execute()) {
            echo json_encode(["message" => "Verificación correcta. Ya puedes iniciar sesión."]);
        } else {
            echo json_encode(["error" => "Error al actualizar la verificación: " . $update_stmt->error]);
        }

        // Cerrar el statement de actualización
        $update_stmt->close();
    } else {
        // Token inválido
        echo json_encode(["error" => "Token inválido. Por favor, vuelve a registrarte."]);
    }

    // Cerrar el statement de selección
    $stmt->close();
} else {
    echo json_encode(["error" => "Token no proporcionado."]);
}

// Cerrar la conexión
$conn->close();
?>
