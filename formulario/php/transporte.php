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
    $prioridadTransporte = $_POST['prioridadTransporte'] ?? 0.0;
    $presupuestoTransporte = $_POST['presupuestoTransporte'] ?? 0.0;
    $tipoTransporte = $_POST['tipoTransporte'] ?? '';
    $tipoCarretera = $_POST['tipoCarretera'] ?? '';
    $idFormulario=$_POST['idFormulario'] ?? 0;
    // Convertir a los tipos correctos para evitar errores de bind_param
    $presupuestoTransporte = floatval($presupuestoTransporte);
    $prioridadTransporte = intval($prioridadTransporte);
    $idFormulario = intval($idFormulario);
    $tipoTransporte = strval($tipoTransporte);
    $tipoCarretera = strval($tipoCarretera);
    //preparar la consulta para insertar los datos
    $sql_insert = "UPDATE formulario SET prioridadTranporte=?, presupuestoTranporte=?, tipoTransporte=?, tipoCarretera=? WHERE idFormulario=?";

    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("idssi", $prioridadTransporte, $presupuestoTransporte, $tipoTransporte, $tipoCarretera, $idFormulario);
    if ($stmt->execute()) {
        $respAX= array("status" => "success");
    } else {
        $respAX= array("status" => "error".$stmt->error);
    }
    $stmt->close();
}   
echo json_encode($respAX);
$conn->close();
?>
