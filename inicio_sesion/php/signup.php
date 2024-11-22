<?php
session_start(); // Iniciar la sesión al comienzo del archivo
header('Content-Type: application/json');

include "../../BasedeDatos/php/Conexion_base_datos.php"; // Verifica que la ruta sea correcta
require_once '../../sendgrid-php/sendgrid-php.php'; //carpeta con los archivos necesarios para la api
use SendGrid\Mail\Mail;
use SendGrid\Mail\Attachment;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $pais = $_POST['country'];
    $num_cel = $_POST['phone'];
    $fecha_nacimiento = $_POST['birthdate'];
    $genero = $_POST['gender'];
    $biografia = ' ';

    // Generar el token de verificación
    $token = bin2hex(random_bytes(16));

    // Consulta para insertar al nuevo usuario
    $sql_insert = "INSERT INTO usuario (Nombre, Apellidos, email, password, Biografia, Pais, NumCel, Nacimiento, Genero, fec_creac, token, verificado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, 0)";

    if ($conn && ($stmt_insert = $conn->prepare($sql_insert))) {
        $stmt_insert->bind_param('ssssssssss', $nombre, $apellido, $email, $password, $biografia, $pais, $num_cel, $fecha_nacimiento, $genero, $token);

        if ($stmt_insert->execute()) {
            $_SESSION['email'] = $email;

            // Enviar correo de verificación
            $verificationUrl = "http://localhost/ADS_Turismo404/inicio_sesion/php/verificar.php?token=$token";
            $mail = new Mail();
            $mail->setFrom("t_notion@protonmail.com", "viajeros404");
            $mail->setSubject("Verificación de cuenta - Viajeros404");
            $mail->addTo($email, "$nombre $apellido");

            // Cargar las imágenes en Base64
            $headerImage = base64_encode(file_get_contents("C:/xampp/htdocs/ADS_Turismo404/inimgs/encabezadocorreo.png"));
            $footerImage = base64_encode(file_get_contents("C:/xampp/htdocs/ADS_Turismo404/inimgs/piecorreo.png"));

            // Añadir contenido HTML con imágenes embebidas
            $mail->addContent(
                "text/html",
                "
                <div style='text-align: center; font-family: Arial, sans-serif;'>
                    <img src='cid:headerImage' alt='Encabezado' style='width: 100%; max-width: 100%; height: auto;' />
                    <p style='font-size: 16px; color: #333; margin: 20px 0;'>
                        <strong>Gracias por registrarte en nuestra plataforma. Para completar el proceso de verificación de tu cuenta, haz clic en el siguiente enlace:</strong>
                    </p>
                    <a href='$verificationUrl' 
                       style='display: inline-block; padding: 10px 20px; font-size: 16px; color: #fff; background-color: #a13c64; text-decoration: none; border-radius: 5px;'>
                        Verificar cuenta
                    </a>
                    
                    <p style='font-size: 16px; color: #333; margin: 20px 0;'>Si no realizaste esta solicitud, puedes ignorar este mensaje. Si necesitas ayuda, no dudes en contactarnos.</p>
                <p style='font-size: 16px; color: #333; margin: 20px 0;'> Atentamente,<br><strong>El equipo de soporte de ADS Turismo404</strong></p>
                    <br><br>
                    <img src='cid:footerImage' alt='Pie de correo' style='width: 100%; max-width: 100%; height: auto;' />
                </div>
                "
            );
            

            // Adjuntar imágenes con CID
            $mail->addAttachment(
                $headerImage,
                "image/png",
                "encabezadocorreo.png",
                "inline",
                "headerImage"
            );

            $mail->addAttachment(
                $footerImage,
                "image/png",
                "piecorreo.png",
                "inline",
                "footerImage"
            );

            $sendgrid = new \SendGrid('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');
            try {
                $response = $sendgrid->send($mail);
                echo json_encode(["success" => true, "message" => "Usuario registrado correctamente. Verifica tu correo para activar la cuenta."]);
            } catch (Exception $e) {
                echo json_encode(["error" => "Error al enviar el correo de verificación: " . $e->getMessage()]);
            }

            exit();
        } else {
            echo json_encode(["error" => "Error al registrar usuario, por favor, verifique los datos ingresados."]);
        }
        
        $stmt_insert->close();
    } else {
        echo json_encode(["error" => "Ocurrió un error inesperado. Inténtelo de nuevo más tarde."]);
    }

    $conn->close();
}
?>
