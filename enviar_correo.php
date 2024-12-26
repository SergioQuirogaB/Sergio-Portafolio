<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Si usas Composer, esta línea es necesaria

// Inicializar las variables de estado y mensaje
$response = [
    'status' => 'error',
    'message' => 'Hubo un error al enviar el mensaje.'
];

// Verificar que se recibieron los datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $nombre = $_POST['name'];
    $email = $_POST['email'];
    $mensaje = $_POST['message'];

    // Configuración de PHPMailer
    $mail = new PHPMailer(true); // Habilitar excepciones

    try {
        // Configurar el servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Servidor SMTP de Gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'pruebassoftaware@gmail.com';  // Tu correo de Gmail
        $mail->Password = 'uhpa jrxb rdwd hrep'; // Contraseña de tu cuenta o contraseña de la aplicación (si usas verificación en 2 pasos)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Remitente
        $mail->setFrom($email, $nombre);
        $mail->addAddress('pruebassoftaware@gmail.com', 'Portafolio'); // Dirección de destino

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Nuevo mensaje desde el formulario de contacto';
        $mail->Body    = "Nombre: $nombre<br>Correo: $email<br><br>Mensaje:<br>$mensaje";
        $mail->AltBody = "Nombre: $nombre\nCorreo: $email\n\nMensaje:\n$mensaje";

        // Intentar enviar el correo
        if ($mail->send()) {
            // Si el correo se envió correctamente
            $response['status'] = 'exito';
            $response['message'] = '¡Mensaje enviado con éxito!  :)';
        }
    } catch (Exception $e) {
        // Si hubo un error
        $response['status'] = 'error';
        $response['message'] = "Error al enviar el mensaje. Correo Inválido {$mail->ErrorInfo}  :(";
    }
}

// Retornar respuesta en formato JSON
echo json_encode($response);
?>
