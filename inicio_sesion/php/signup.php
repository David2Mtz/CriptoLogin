<?php
require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';
// Configuración de la base de datos
include "../../BasedeDatos/php/Conexion_base_datos.php";

session_start(); // Iniciar la sesión al comienzo del archivo
header('Content-Type: application/json');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    

    // Generar el token de verificación
    $token = bin2hex(random_bytes(16));

    // Consulta para insertar al nuevo usuario
    $sql_insert = "INSERT INTO usuario (Usuario,Correo, Password, Fec_Creac, Token, Valido) VALUES (?, ?, ?, NOW(), ?, 0)";

   
    if ($stmt_insert = $conn->prepare($sql_insert)) {
        $stmt_insert->bind_param('ssss', $usuario, $email, $password, $token);
        
        if ($stmt_insert->execute()) {
            $_SESSION['email'] = $email;
            $_SESSION['usuario'] = $usuario;
            // Enviar correo de verificación
            // Crear una instancia de PHPMailer
            $mail = new PHPMailer(true);

            try {
                // Configuración del servidor SMTP
                $mail->CharSet = 'UTF-8';
                $mail->SMTPDebug = 0; // Desactivar la salida de depuración
                $mail->isSMTP(); // Enviar usando SMTP
                $mail->Host = 'smtp.gmail.com'; // Servidor SMTP
                $mail->SMTPAuth = true; // Activar autenticación SMTP
                $mail->Username = 'Turismo404.adm@gmail.com'; // Nombre de usuario SMTP
                $mail->Password = 'owsi bxzy nomp dgrp'; // Contraseña específica de aplicación
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Habilitar encriptación TLS implícita
                $mail->Port = 465; // Puerto TCP para conectar

                // Destinatarios
                $mail->setFrom('Tusimo404.adm@gmail.com', 'Administrador');
                $mail->addAddress($email, 'Turista'); // Destinatario

                // Contenido del correo
                $mail->isHTML(true); // Formato HTML
                $mail->Subject = 'Verificacion de correo';
                
                // Ruta de las imágenes
                $imageHeaderPath = '../../inimgs/encabezadocorreo.png';
                $imageFooterPath = '../../inimgs/piecorreo.png';

                // Adjuntar las imágenes al correo
                $mail->addEmbeddedImage($imageHeaderPath, 'encabezado_cid');
                $mail->addEmbeddedImage($imageFooterPath, 'pie_cid');

                // Cuerpo del correo
                $mail->Body = '
                <div style="font-family: Arial, sans-serif; font-size: 16px; line-height: 1.6; color: #333; text-align: center; margin: 0; padding: 0;">
                <!-- Imagen del encabezado -->
                <div style="margin-bottom: 20px;">
                <img src="cid:encabezado_cid" alt="Encabezado del correo" style="width: 100%; max-width: 100%; height: auto; display: block;">
                </div>
        
                <!-- Texto del correo -->
                <p>Estimado/a usuario/a,</p>
                <p>Hemos recibido una solicitud para concluir el proceso de registro a la pagina Turismo404  te invitamos a hacer clic en el siguiente enlace:</p>
                <p style="margin: 20px 0;">
                <a href="http://localhost/CriptoLogin/inicio_sesion/html/CorreoVerificado.php?token=' . $token . '" 
                style="display: inline-block; padding: 10px 20px; color: #fff; background-color: #a13c64; text-decoration: none; border-radius: 5px; font-weight: bold;">
                VerificarCorreo
                </a>
                </p>
                <p>Si no has realizado esta solicitud, puedes ignorar este mensaje. La seguridad de tu cuenta es nuestra prioridad, por lo que te recomendamos no compartir este enlace con nadie.</p>
                <p>Atentamente,<br><strong>El equipo de soporte de ADS Turismo404</strong></p>
        
                <!-- Imagen del pie -->
                <div style="margin-top: 20px;">
                <img src="cid:pie_cid" alt="Pie del correo" style="width: 100%; max-width: 100%; height: auto; display: block;">
                </div>
                </div>';

                $mail->AltBody = 'Este es el cuerpo del correo en texto plano para clientes que no soportan HTML';

                $mail->send();
                echo json_encode(["message" => "Hemos enviado un correo a la dirección proporcionada. Por favor, revisa los pasos a seguir."]);
            } catch (Exception $e) {
                echo json_encode(["error" => "El correo no pudo ser enviado. Error: " . $mail->ErrorInfo]);
            }
        } else {
            echo json_encode(["error" => "Error al registrar usuario, por favor, verifique los datos ingresados."]);
        }
        
        $stmt_insert->close();
    } else {
        echo json_encode(["error" => "Ocurrió un error inesperado. Inténtelo de nuevo más tarde." ]);
    }

    $conn->close();
}
?>
