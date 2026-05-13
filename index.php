<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
include 'conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Imágenes | TESVG 2026</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy:        #0f1117;
            --navy2:       #171b26;
            --navy3:       #1e2433;
            --accent:      #3b82f6;
            --accent-h:    #2563eb;
            --accent-soft: rgba(59,130,246,0.12);
            --body-bg:     #f4f5f7;
            --card-bg:     #ffffff;
            --card-border: rgba(0,0,0,0.07);
            --text:        #1a1f2e;
            --muted:       #6b7280;
            --light:       #e5e7eb;
            --success:     #22c55e;
            --danger:      #ef4444;
            --sidebar-w:   240px;
            --navbar-h:    52px;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--body-bg);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* NAVBAR */
        .top-navbar {
            position: fixed; top: 0; left: 0; right: 0;
            height: var(--navbar-h);
            background: var(--navy);
            display: flex; align-items: center;
            padding: 0 1.25rem; gap: 10px;
            z-index: 1000;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .navbar-brand-text {
            font-family: 'Syne', sans-serif; font-weight: 800; font-size: 17px;
            color: #fff; letter-spacing: 0.06em; text-decoration: none; margin-right: 18px;
        }

        .top-nav-links { display: flex; gap: 2px; flex: 1; list-style: none; }

        .top-nav-links a {
            display: block; padding: 5px 14px; border-radius: 7px;
            font-size: 13px; color: rgba(255,255,255,0.5);
            text-decoration: none; transition: all .15s;
        }
        .top-nav-links a:hover  { color: #fff; background: rgba(255,255,255,0.07); }
        .top-nav-links a.active { color: #fff; background: var(--accent); font-weight: 500; }

        .navbar-right { display: flex; align-items: center; gap: 12px; margin-left: auto; }
        .navbar-right .user-label { font-size: 12px; color: rgba(255,255,255,0.35); }

        .avatar-circle {
            width: 30px; height: 30px; border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), #8b5cf6);
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 700; color: #fff;
        }

        /* LAYOUT */
        .main-wrapper { display: flex; padding-top: var(--navbar-h); min-height: 100vh; }

        /* SIDEBAR */
        #sidebar {
            width: var(--sidebar-w); background: var(--navy2);
            position: fixed; top: var(--navbar-h); left: 0; bottom: 0;
            display: flex; flex-direction: column;
            border-right: 1px solid rgba(255,255,255,0.04);
            z-index: 900; padding: 1rem 0; overflow-y: auto;
        }

        .sidebar-section-label {
            padding: 0 18px 4px; font-size: 9.5px; font-weight: 600;
            letter-spacing: .1em; text-transform: uppercase;
            color: rgba(255,255,255,0.22); margin: 16px 0 4px;
        }

        .sidebar-item {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 16px; margin: 0 8px; border-radius: 8px;
            color: rgba(255,255,255,0.45); font-size: 13px;
            text-decoration: none; transition: all .15s;
            border-left: 3px solid transparent;
        }
        .sidebar-item:hover  { color: #fff; background: rgba(255,255,255,0.06); text-decoration: none; }
        .sidebar-item.active {
            color: #fff; background: rgba(59,130,246,0.15);
            border-left-color: var(--accent); padding-left: 13px; font-weight: 500;
        }
        .sidebar-item i { font-size: 16px; flex-shrink: 0; width: 18px; text-align: center; }

        .sidebar-footer { margin-top: auto; padding: 14px 8px 8px; border-top: 1px solid rgba(255,255,255,0.05); }
        .sidebar-footer-copy { padding: 8px 18px 0; font-size: 10px; color: rgba(255,255,255,0.18); }

        /* CONTENT */
        #content-area {
            margin-left: var(--sidebar-w); flex: 1;
            padding: 28px 28px 56px;
            min-height: calc(100vh - var(--navbar-h));
            display: flex; flex-direction: column;
        }

        /* PAGE HEADER */
        .page-header {
            display: flex; align-items: flex-start;
            justify-content: space-between; margin-bottom: 28px;
        }
        .page-eyebrow {
            font-size: 10.5px; font-weight: 600; letter-spacing: .1em;
            text-transform: uppercase; color: var(--accent); margin-bottom: 4px;
        }
        .page-title {
            font-family: 'Syne', sans-serif; font-size: 24px;
            font-weight: 700; color: var(--text); margin-bottom: 2px;
        }
        .page-subtitle { font-size: 12px; color: var(--muted); }

        /* BOTONES */
        .btn-custom-primary {
            background: var(--accent); color: #fff; border: none;
            padding: 8px 20px; border-radius: 999px; font-size: 13px; font-weight: 500;
            cursor: pointer; font-family: 'DM Sans', sans-serif;
            display: inline-flex; align-items: center; gap: 7px;
            text-decoration: none; transition: background .15s; flex-shrink: 0;
        }
        .btn-custom-primary:hover { background: var(--accent-h); color: #fff; }

        .btn-custom-dark {
            width: 100%; padding: 12px; border-radius: 999px;
            background: var(--navy); color: #fff; font-size: 13px; font-weight: 500;
            border: none; cursor: pointer; font-family: 'DM Sans', sans-serif;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            transition: background .15s;
        }
        .btn-custom-dark:hover { background: var(--navy3); }

        .btn-custom-outline {
            background: transparent; color: var(--text); border: 1px solid var(--light);
            padding: 8px 20px; border-radius: 999px; font-size: 13px; font-weight: 500;
            cursor: pointer; font-family: 'DM Sans', sans-serif;
            display: inline-flex; align-items: center; gap: 7px; transition: all .15s;
        }
        .btn-custom-outline:hover { border-color: var(--accent); color: var(--accent); }

        /* UPLOAD CARD */
        .card-panel {
            background: var(--card-bg); border: 1px solid var(--card-border);
            border-radius: 14px; padding: 28px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
            max-width: 600px; width: 100%;
        }

        .panel-title {
            font-size: 13px; font-weight: 600; color: var(--text);
            display: flex; align-items: center; gap: 8px; margin-bottom: 20px;
        }
        .panel-title i { font-size: 16px; color: var(--accent); }

        /* FORM */
        .form-label-custom {
            display: block; font-size: 10px; font-weight: 600;
            letter-spacing: .08em; text-transform: uppercase;
            color: var(--muted); margin-bottom: 6px;
        }

        .form-control-custom {
            width: 100%; padding: 10px 14px;
            border: 1px solid var(--light); border-radius: 9px;
            font-size: 13px; font-family: 'DM Sans', sans-serif;
            color: var(--text); background: #f9fafb; outline: none;
            transition: border-color .15s, background .15s;
        }
        .form-control-custom:focus {
            border-color: var(--accent); background: #fff;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
        }

        .file-drop-zone {
            border: 1.5px dashed #d1d5db; border-radius: 12px; padding: 36px 16px;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            background: #f9fafb; text-align: center; cursor: pointer;
            transition: all .2s; margin-bottom: 16px;
        }
        .file-drop-zone:hover, .file-drop-zone.drag-over {
            border-color: var(--accent); background: var(--accent-soft); transform: scale(1.01);
        }

        .drop-icon-wrap {
            width: 48px; height: 48px; border-radius: 12px;
            background: var(--accent-soft);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 12px; font-size: 22px; color: var(--accent);
        }
        .drop-title { font-size: 13px; font-weight: 500; color: var(--text); }
        .drop-hint  { font-size: 11px; color: var(--muted); margin-top: 3px; }

        #upload-success { display: none; }

        /* STATUS BAR */
        .status-bar {
            position: fixed; bottom: 0; left: var(--sidebar-w); right: 0;
            height: 28px; background: var(--navy);
            display: flex; align-items: center; padding: 0 18px; gap: 14px;
            z-index: 800; border-top: 1px solid rgba(255,255,255,0.04);
        }
        .status-dot {
            width: 6px; height: 6px; border-radius: 50%;
            background: var(--success); flex-shrink: 0;
            box-shadow: 0 0 6px rgba(34,197,94,0.5);
        }
        .status-text { font-size: 10px; color: rgba(255,255,255,0.3); }

        /* TOAST */
        #toast-msg {
            position: fixed; bottom: 48px; right: 24px;
            background: var(--navy); color: #fff;
            padding: 12px 18px; border-radius: 10px; font-size: 13px;
            display: flex; align-items: center; gap: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            z-index: 2000; transform: translateY(20px); opacity: 0;
            transition: all .3s; pointer-events: none;
        }
        #toast-msg.show { transform: translateY(0); opacity: 1; }
        #toast-msg.success i { color: var(--success); }
        #toast-msg.error   i { color: var(--danger);  }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            :root { --sidebar-w: 0px; }
            #sidebar    { display: none; }
            .status-bar { left: 0; }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="top-navbar">
    <a href="index.php" class="navbar-brand-text">Programación Web</a>

    <ul class="top-nav-links">
        <li><a href="index.php" class="active">Inicio</a></li>
        <li><a href="visor.php">Visor</a></li>        
        <!-- <li><a href="visor.php" target="_blank">Visor</a></li> -->
    </ul>

    <div class="navbar-right">
        <span class="user-label"><?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
        <div class="avatar-circle">
            <?php echo strtoupper(substr($_SESSION['usuario'], 0, 2)); ?>
        </div>
    </div>
</nav>

<div class="main-wrapper">

    <!-- SIDEBAR -->
    <aside id="sidebar">
        <span class="sidebar-section-label">Navegación</span>

        <a href="index.php" class="sidebar-item active">
            <i class="bi bi-grid-1x2-fill"></i> Inicio
        </a>
        <a href="visor.php" class="sidebar-item">
            <i class="bi bi-display"></i> Visor
        </a>

        <div class="sidebar-footer">
            <a href="logout.php" class="sidebar-item" style="color: rgba(239,68,68,0.7);">
                <i class="bi bi-power"></i> Salir del Sistema
            </a>
            <div class="sidebar-footer-copy">Sistemas TESVG &copy; 2026</div>
        </div>
    </aside>

    <!-- CONTENT -->
    <div id="content-area">

        <!-- PAGE HEADER -->
        <div class="page-header">
            <div>
                <p class="page-eyebrow">PROGRAMACIÓN WEB</p>
                <h1 class="page-title">Gestión de Imágenes</h1>
                <p class="page-subtitle">Panel de Control &middot; 2026</p>
            </div>
            <a href="visor.php" class="btn-custom-primary">            
                <i class="bi bi-play-circle-fill"></i> Lanzar Visor
            </a>
        </div>

        <!-- UPLOAD CARD -->
        <div class="card-panel">
            <div class="panel-title">
                <i class="bi bi-cloud-arrow-up-fill"></i> Cargar Nueva Imagen
            </div>

            <div id="form-area">
                <div class="mb-3">
                    <label class="form-label-custom">Nombre del recurso</label>
                    <input type="text" id="inputNombre" class="form-control-custom"
                           placeholder="Ej. Portada Principal">
                </div>

                <div class="mb-3">
                    <label class="form-label-custom">Archivo multimedia</label>
                    <div class="file-drop-zone" id="dropZone">
                        <div class="drop-icon-wrap">
                            <i class="bi bi-image-fill" id="drop-bi-icon"></i>
                        </div>
                        <p class="drop-title" id="file-title">Arrastra o agrega aquí tu imagen</p>
                        <p class="drop-hint"  id="file-hint">JPG, PNG o WEBP &middot; máx. 10 MB</p>
                    </div>
                    <input type="file" id="fotoInput" accept="image/*" style="display:none;">
                </div>

                <button type="button" id="btn-subir" class="btn-custom-dark">
                    <i class="bi bi-send-fill" id="btn-subir-icon"></i>
                    <span id="btn-subir-text">Procesar y Guardar</span>
                </button>
            </div>

            <!-- Estado de éxito -->
            <div id="upload-success" class="text-center py-4">
                <i class="bi bi-check-circle-fill text-success" style="font-size:56px;"></i>
                <h5 class="mt-3 fw-bold">¡Subida exitosa!</h5>
                <p class="text-muted small" id="estado-nombre"></p>
                <button type="button" id="btn-otra" class="btn-custom-outline mt-2">
                    <i class="bi bi-plus-lg"></i> Añadir otra
                </button>
            </div>
        </div>

    </div><!-- /content-area -->
</div><!-- /main-wrapper -->

<!-- STATUS BAR -->
<div class="status-bar">
    <div class="status-dot"></div>
    <span class="status-text">DBProgWeb conectada &middot; TESVG 2026 &middot; <?php echo htmlspecialchars($_SESSION['usuario']); ?>@tesvg.edu.mx</span>
</div>

<!-- TOAST -->
<div id="toast-msg">
    <i class="bi bi-check-circle-fill"></i>
    <span id="toast-text">Listo</span>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
/* TOAST */
function showToast(msg, type = 'success') {
    const t = $('#toast-msg');
    $('#toast-text').text(msg);
    t.removeClass('success error').addClass(type);
    t.find('i').attr('class', type === 'success'
        ? 'bi bi-check-circle-fill'
        : 'bi bi-exclamation-circle-fill');
    t.addClass('show');
    setTimeout(() => t.removeClass('show'), 3000);
}

/* DROP ZONE */
const dropZone  = document.getElementById('dropZone');
const fotoInput = document.getElementById('fotoInput');

dropZone.addEventListener('click',    () => fotoInput.click());
dropZone.addEventListener('dragover',  e => { e.preventDefault(); dropZone.classList.add('drag-over'); });
dropZone.addEventListener('dragleave', () => dropZone.classList.remove('drag-over'));
dropZone.addEventListener('drop', e => {
    e.preventDefault();
    dropZone.classList.remove('drag-over');
    if (e.dataTransfer.files.length) {
        fotoInput.files = e.dataTransfer.files;
        actualizarDropUI(e.dataTransfer.files[0]);
    }
});
fotoInput.addEventListener('change', function() {
    if (this.files.length) actualizarDropUI(this.files[0]);
});

function actualizarDropUI(file) {
    if (!file.type.startsWith('image/')) {
        showToast('Solo se aceptan imágenes (JPG, PNG, WEBP)', 'error');
        return;
    }
    const reader = new FileReader();
    reader.onload = e => {
        dropZone.style.backgroundImage    = `url('${e.target.result}')`;
        dropZone.style.backgroundSize     = 'cover';
        dropZone.style.backgroundPosition = 'center';
        document.getElementById('drop-bi-icon').style.display = 'none';
    };
    reader.readAsDataURL(file);
    document.getElementById('file-title').textContent = file.name;
    document.getElementById('file-hint').textContent  = (file.size / 1024 / 1024).toFixed(2) + ' MB';
}

/* SUBIR */
$('#btn-subir').on('click', function() {
    const nombre = $('#inputNombre').val().trim();
    const foto   = $('#fotoInput')[0].files[0];

    if (!nombre) { showToast('Ingresa un nombre para el recurso.', 'error'); $('#inputNombre').focus(); return; }
    if (!foto)   { showToast('Selecciona o arrastra una imagen.', 'error'); return; }

    $('#btn-subir-icon').removeClass('bi-send-fill').addClass('bi-arrow-repeat');
    $('#btn-subir-text').text('Procesando...');
    $('#btn-subir').prop('disabled', true);

    const fd = new FormData();
    fd.append('nombre', nombre);
    fd.append('foto',   foto);

    $.ajax({
        url: 'subir.php', type: 'POST', data: fd,
        processData: false, contentType: false,
        success: function(res) {
            $('#btn-subir-icon').removeClass('bi-arrow-repeat').addClass('bi-send-fill');
            $('#btn-subir-text').text('Procesar y Guardar');
            $('#btn-subir').prop('disabled', false);

            let data;
            try { data = JSON.parse(res); } catch(e) { data = { ok: false }; }

            const resTrim = res.trim().toLowerCase();
            const esExito = data.ok || resTrim === 'success' || resTrim === '1' || resTrim.includes('exitoso');

            if (esExito) {
                $('#form-area').hide();
                $('#upload-success').show();
                $('#estado-nombre').text('"' + nombre + '" añadido al repositorio.');
                showToast('Imagen subida correctamente.');
            } else {
                showToast('Error al subir: ' + (data.msg || res), 'error');
            }
        },
        error: function() {
            $('#btn-subir-icon').removeClass('bi-arrow-repeat').addClass('bi-send-fill');
            $('#btn-subir-text').text('Procesar y Guardar');
            $('#btn-subir').prop('disabled', false);
            showToast('Error de conexión con el servidor.', 'error');
        }
    });
});

/* OTRA IMAGEN */
$('#btn-otra').on('click', function() {
    $('#upload-success').hide();
    $('#form-area').show();
    $('#inputNombre').val('');
    $('#fotoInput').val('');
    dropZone.style.backgroundImage = '';
    dropZone.style.backgroundSize  = '';
    document.getElementById('drop-bi-icon').style.display = '';
    document.getElementById('file-title').textContent = 'Arrastra aquí tu imagen';
    document.getElementById('file-hint').textContent  = 'JPG, PNG o WEBP · máx. 10 MB';
});
</script>

</body>
</html>
