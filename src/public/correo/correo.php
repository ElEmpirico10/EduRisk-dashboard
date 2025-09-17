<?php
// Importa las clases de PHPMailer al espacio global
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/autoload.php';

/**
 * Envía un correo para recuperar contraseña
 *
 * @param string $correo  Correo del destinatario
 * @param string $nombre  Nombre del destinatario
 * @param string $token   Código o enlace
 * @return bool|string    true si se envió, o mensaje de error
 */
function recuperarPassword(string $correo, string $nombre, string $token)
{
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        //$mail->Username   = 'jcano2620k@gmail.com';     // <-- pon tu usuario
        //$mail->Password   = 'ynmf lwwt nwlq wczk';       // <-- pon tu contraseña de aplicación
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Remitente y destinatario
        $mail->setFrom('jcano2620k@gmail.com', 'Edurisk');
        $mail->addAddress($correo, $nombre);

        // Plantilla HTML
        $plantilla = file_get_contents(__DIR__ . '/plantilla.html');
        $plantilla = str_replace('{{NOMBRE_USUARIO}}', $nombre, $plantilla);
        $plantilla = str_replace('{{CLAVE_GENERICA}}', $token, $plantilla);
        $plantilla = str_replace('{{CORREO_USUARIO}}', $correo, $plantilla);


        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Asignacion de contraseña';
        $mail->Body    = $plantilla;
        $mail->AltBody = "Hola $nombre, para ingresar tu contraseña visita:\nhttp://localhost:8080/login";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Error al enviar: {$mail->ErrorInfo}";
    }
}
