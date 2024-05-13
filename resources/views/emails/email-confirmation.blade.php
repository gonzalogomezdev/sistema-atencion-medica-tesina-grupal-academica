<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Correo Electrónico</title>
</head>
<body>
    <p>Hola</p>
    <p>Gracias por registrarte en nuestro sistema. Por favor, confirma tu correo electrónico haciendo clic en el siguiente enlace:</p>
    <a href="{{ route('confirmar.email', ['token' => $token]) }}">Confirmar Email</a>
</body>
</html>
