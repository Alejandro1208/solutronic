<!DOCTYPE html>
<html>
<head>
    <title>Nuevo mensaje de contacto</title>
</head>
<body>
    <h2 style="color: #333; font-size: 24px;">Nuevo mensaje de contacto desde {{ $nombre }}</h2>
    <p style="margin-bottom: 10px;"><strong>Nombre:</strong> {{ $nombre }}</p>
    <p style="margin-bottom: 10px;"><strong>Teléfono:</strong> {{ $telefono }}</p>
    <p style="margin-bottom: 10px;"><strong>Email:</strong> {{ $email }}</p>
    <p style="margin-bottom: 10px;"><strong>Mensaje:</strong> {{ $mensaje }}</p>
</body>
</html>