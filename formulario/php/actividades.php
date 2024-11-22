<?php
#Incluimos el archivo de conexion a la base deatos
include "../../BasedeDatos/php/Conexion_base_datos.php";
/*
// Inicia la sesión
session_start();
// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['email'])) {
    // Si no está iniciada la sesión, redirige a la página de inicio de sesión
    header("Location: ../../inicio_sesion/html/login.html");
    exit();
}
*/
//recibir los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prioridadActividades = $_POST['prioridadActividades'] ?? 0;
    $presupuestoActividades = $_POST['presupuestoActividades'] ?? 0.0;
    $tipoPagoActividades = $_POST['actividades'] ?? 0.0;
    $interes = $_POST['interes'] ?? [];
    $idFormulario=$_POST['idFormulario'] ?? 0;
    
    // Convertir a los tipos correctos para evitar errores de bind_param
    $presupuestoActividades = floatval($presupuestoActividades);
    $prioridadActividades = intval($prioridadActividades);
    $tipoPagoActividades = intval($tipoPagoActividades);
    $idFormulario = intval($idFormulario);
    // Recorrer el arreglo de establecimientos de comida y convertir cada valor a un entero
    foreach ($interes as $key => $value) {
        // Convertir el valor a entero y guardarlo de nuevo en el arreglo
        $interes[$key] = intval($value);
    }
    $numIntereses=count($interes);
    $numComp=0;
    //preparar la consulta para insertar los datos de hospedaje
    $sql_insert = "UPDATE formulario SET prioridadActividades=?, presupuestoActividades=?, tipoPagoActividades=? WHERE idFormulario=?";

    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("idii", $prioridadActividades, $presupuestoActividades, $tipoPagoActividades, $idFormulario);
    //preparar la consulta para insertar los datos de preferencias de actividades de un formulario
    foreach ($interes as $tipo) {
        $sql_insert = "INSERT INTO PreferenciaTipoActividades (idFormulario, idTipoActividades) VALUES (?, ?)";
        $stmt2 = $conn->prepare($sql_insert);
        $stmt2->bind_param("ii", $idFormulario, $tipo); 
        if($stmt2->execute()){
            $numComp++;
        }
    }
    if ($stmt->execute() && $numComp==$numIntereses) {
        $respAX= array("status" => "success");
    } else {
        $respAX= array("status" => "error".$stmt->error);
    }
    $stmt->close();
}   
echo json_encode($respAX);
$conn->close();
?>
