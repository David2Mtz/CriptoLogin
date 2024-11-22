<?php
#Incluimos el archivo de conexion a la base deatos
include "../../BasedeDatos/php/Conexion_base_datos.php";

// Inicia la sesión
session_start();
// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['email'])) {
    // Si no está iniciada la sesión, redirige a la página de inicio de sesión
    header("Location: ../../inicio_sesion/html/login.html");
    exit();
}

//recibir los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $presupuesto = $_POST['presupuesto'] ?? 0.0;
    $origen = $_POST['origen'] ?? '';
    $destino = $_POST['destino'] ?? '';
    $fechaini = $_POST['fecha-inicio'] ?? '';
    $fechafin = $_POST['fecha-fin'] ?? '';
    $acompanantes = $_POST['acompanantes'] ?? 1;


    // Convertir a los tipos correctos para evitar errores de bind_param
    $presupuesto = floatval($presupuesto);
    $acompanantes = intval($acompanantes);
    $origen = strval($origen);
    $destino = strval($destino);
    $fechaini = strval($fechaini);
    $fechafin = strval($fechafin);

    //obtener el id del usuario que esta llenando el formulario
    $email=$_SESSION['email'];
    $sql_insert = "SELECT idUsuario FROM usuario WHERE email = ?";
    $stmtUser = $conn->prepare($sql_insert);
    $stmtUser->bind_param("s", $email);
    $stmtUser->execute();
    $stmtUser->store_result();
    if($stmtUser->num_rows > 0){
        $stmtUser->bind_result($idUsuario);
        $stmtUser->fetch();
        //preparar la consulta para insertar los datos
        $sql_insert = "INSERT INTO formulario (idUsuario, NoViajeros, lugarOrigen, lugarDestino, presupuesto, FechaFin, FechaIni) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bind_param("iissdss", $idUsuario, $acompanantes, $origen, $destino, $presupuesto, $fechafin, $fechaini);
        if ($stmt->execute()) {
            $idFormulario = $conn->insert_id;
            $respAX= array("status" => "success", "idFormulario" => $idFormulario);
        } else {
            $respAX= array("status" => "Error", "idFormulario" => null);
        }
    }else{
        $respAX="Error al actualizar los datos: " . $stmt->error;
    }

    $stmt->close();
}   
echo json_encode($respAX);
$conn->close();
?>
