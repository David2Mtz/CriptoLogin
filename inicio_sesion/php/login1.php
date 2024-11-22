<?php
session_start();
include "../../BasedeDatos/php/Conexion_base_datos.php";

header("Content-Type: application/json"); // Configura el encabezado para JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT password FROM usuario WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($stored_password);
        $stmt->fetch();

        // Verificar la contraseña
        if (password_verify($password, $stored_password)) {
            $_SESSION['email'] = $email;
            echo json_encode(["success" => true]); // Indica éxito
        } else {
            echo json_encode(["error" => "Usuario/contraseña incorrecta, por favor, verifique los datos ingresados."]);
        }
    } else {
        echo json_encode(["error" => "Usuario/contraseña incorrecta, por favor, verifique los datos ingresados."]);
    }

    $stmt->close();
}

$conn->close();
?>
