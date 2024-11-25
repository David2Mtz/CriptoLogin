<?php
session_start();
include "../../BasedeDatos/php/Conexion_base_datos.php";

header("Content-Type: application/json"); // Configura el encabezado para JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT Password,Correo FROM usuario WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($stored_password,$email);
        $stmt->fetch();

        // Verificar la contraseña
        if ($password == $stored_password) {
            
            //Verificar que el usuario haya concretado la verificacion con su correo.
            $stmt = $conn->prepare("SELECT Valido FROM usuario WHERE usuario= ?");
            $stmt->bind_param("s", $usuario);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($verificacion);
            $stmt->fetch();
            if($verificacion){
                $_SESSION['email'] = $email;
                echo json_encode(["success" => true]); // Indica éxito
            }
            else{
                echo json_encode(["error" => "Parece ser que aun no has validado tu cuenta.Por favor revisa tu correo."]);
            }
            
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
