<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta | DBProgWeb</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #0d6efd;
            --bg-dark: #0f172a;
        }

        body { 
            background: radial-gradient(circle at bottom left, #1e293b, #0f172a);
            font-family: 'DM Sans', sans-serif; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            height: 100vh; 
            margin: 0;
            color: #f8fafc;
        }

        .register-card { 
            background: rgba(30, 41, 59, 0.7); 
            backdrop-filter: blur(12px);
            padding: 40px; 
            border-radius: 24px; 
            width: 100%; 
            max-width: 420px; 
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); 
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center; 
        }

        .icon-box {
            width: 50px;
            height: 50px;
            background: rgba(13, 110, 253, 0.2);
            color: var(--primary-color);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 20px;
            margin-bottom: 15px;
        }

        .form-control {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            padding: 12px 15px;
            border-radius: 12px;
            border-left: none; /* Mantengo tu estilo original de bordes */
        }

        .form-control:focus {
            background: rgba(15, 23, 42, 0.8);
            border-color: var(--primary-color);
            color: white;
            box-shadow: none;
        }

        .input-group-text {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #94a3b8;
            border-radius: 12px;
            border-right: none;
        }

        .btn-primary { 
            background: var(--primary-color); 
            border: none; 
            padding: 14px; 
            border-radius: 12px; 
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(13, 110, 253, 0.5);
        }

        .footer-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .text-muted-custom {
            color: #94a3b8;
            font-size: 0.9rem;
        }

         /* Esto cambia el color del texto sugerido (placeholder) */
        .form-control::placeholder {
        color: #ffffff; /* Blanco puro para máximo contraste */
        opacity: 0.8;   /* Un poco de transparencia para que no distraiga demasiado */
        }
    </style>
</head>
<body>

<div class="register-card">
    <div class="icon-box">
        <i class="bi bi-person-plus-fill"></i>
    </div>
    
    <h2 class="fw-bold mb-1">Nueva Cuenta</h2>
    <p class="text-muted-custom mb-4">Únete a la plataforma del <strong>TESVG</strong></p>

    <form action="procesar_registro.php" method="POST">
        <div class="input-group mb-3">
            <span class="input-group-text"><i class="bi bi-person"></i></span>
            <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input type="email" name="correo" class="form-control" placeholder="Correo electrónico" required>
        </div>

        <div class="input-group mb-4">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" name="password" class="form-control" placeholder="Crea una contraseña" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Registrarme ahora</button>
    </form>

    <div class="footer-link mt-4">
        <span class="text-muted-custom">¿Ya eres miembro?</span> <br>
        <a href="login.php">Iniciar sesión</a>
    </div>
</div>

</body>
</html>