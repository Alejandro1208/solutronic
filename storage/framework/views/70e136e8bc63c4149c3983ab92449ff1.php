<!DOCTYPE html>
<html>
<head>
    <title>Nuevo mensaje de contacto desde su web</title>
</head>
<body>
    <h2 style="color: #333; font-size: 24px;">Nuevo mensaje del formulario de Solutronic.com.ar</h2>
    <p style="margin-bottom: 10px;"><strong>Nombre:</strong> <?php echo e($nombre); ?></p>
    <p style="margin-bottom: 10px;"><strong>Teléfono:</strong> <?php echo e($telefono); ?></p>
    <p style="margin-bottom: 10px;"><strong>Email:</strong> <?php echo e($email); ?></p>
    <p style="margin-bottom: 10px;"><strong>Mensaje:</strong> <?php echo e($mensaje); ?></p>
</body>
</html><?php /**PATH /home/u984597834/domains/solutronic.com.ar/resources/views/emails.blade.php ENDPATH**/ ?>