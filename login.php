<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema | Programación Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #0d6efd;
            --accent-color:  #f8fafc;
            --bg-dark: #0f172a;
        }

        body { 
            background: radial-gradient(circle at top right, #1e293b, #0f172a);
            font-family: 'DM Sans', sans-serif; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            height: 100vh; 
            margin: 0;
            color: #f8fafc;
        }

        .login-card { 
            background: rgba(30, 41, 59, 0.7); 
            backdrop-filter: blur(12px);
            padding: 45px; 
            border-radius: 24px; 
            width: 100%; 
            max-width: 420px; 
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); 
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center; 
        }

        .brand-logo {
            width: 60px;
            height: 60px;
            background: var(--primary-color);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            font-size: 24px;
            margin-bottom: 20px;
            box-shadow: 0 0 20px rgba(13, 110, 253, 0.4);
        }

        .form-control {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            padding: 12px 15px;
            border-radius: 12px;
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
        }

        .btn-primary { 
            background: var(--primary-color); 
            border: none; 
            padding: 14px; 
            border-radius: 12px; 
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(13, 110, 253, 0.5);
            background: #0b5ed7;
        }

        .footer-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .footer-link a:hover {
            text-decoration: underline;
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

<div class="login-card">
    <div class="brand-logo">
        <i class="bi bi-shield-lock-fill"></i>
    </div>

    <?php if(isset($_GET['status']) && $_GET['status'] == 'loggedout'): ?>
    <div class="alert alert-info py-2" style="font-size: 0.8rem; border-radius: 10px; background: rgba(13, 202, 240, 0.1); color: #0dcaf0; border: 1px solid rgba(13, 202, 240, 0.2);">
        <i class="bi bi-info-circle me-2"></i> Sesión cerrada correctamente
    </div>
<?php endif; ?>
    
    <h2 class="fw-bold mb-1">Bienvenido</h2>
    <p class="text-muted-custom mb-4">Ingresa tus credenciales para acceder a <strong>Programación Web</strong></p>

    <form action="validar_login.php" method="POST">
        <div class="input-group mb-3">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input type="email" name="correo" class="form-control" placeholder="Correo electrónico" required>
        </div>
 
        <div class="input-group mb-4">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-3">Iniciar Sesión</button>
    </form>

    <div class="footer-link mt-2">
        <span class="text-muted-custom">¿No tienes cuenta?</span> <br>
        <a href="registro.php">Crear una cuenta nueva</a>
    </div>
</div>

</body>
</html>