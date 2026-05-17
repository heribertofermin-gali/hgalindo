<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visor Pro | TESVG 2026</title>

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

        /* ── NAVBAR ── */
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

        /* ── LAYOUT ── */
        .main-wrapper { display: flex; padding-top: var(--navbar-h); min-height: 100vh; }

        /* ── SIDEBAR ── */
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

        /* ── CONTENT ── */
        #content-area {
            margin-left: var(--sidebar-w); flex: 1;
            padding: 28px 28px 56px;
            min-height: calc(100vh - var(--navbar-h));
        }

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex; align-items: flex-start;
            justify-content: space-between; margin-bottom: 24px;
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

        .btn-custom-primary {
            background: var(--accent); color: #fff; border: none;
            padding: 8px 20px; border-radius: 999px; font-size: 13px; font-weight: 500;
            cursor: pointer; font-family: 'DM Sans', sans-serif;
            display: inline-flex; align-items: center; gap: 7px;
            text-decoration: none; transition: background .15s; flex-shrink: 0;
        }
        .btn-custom-primary:hover { background: var(--accent-h); color: #fff; }

        /* ── MONITOR ── */
        .monitor-wrap {
            background: var(--card-bg); border: 1px solid var(--card-border);
            border-radius: 16px; overflow: hidden;
            margin-bottom: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .monitor-topbar {
            background: var(--navy); height: 36px;
            display: flex; align-items: center; padding: 0 14px; gap: 7px;
        }
        .monitor-dot { width: 10px; height: 10px; border-radius: 50%; }
        .monitor-title { margin-left: auto; font-size: 11px; color: rgba(255,255,255,0.3); }

        .slider-stage {
            background: radial-gradient(ellipse at center, #1e293b 0%, #0f172a 100%);
            height: 460px; display: flex; align-items: center; justify-content: center;
            position: relative; overflow: hidden;
        }

        .slider-stage img {
            max-width: 100%; max-height: 440px;
            object-fit: contain; border-radius: 4px; display: block;
        }

        .nav-arrow {
            position: absolute; top: 50%; transform: translateY(-50%);
            width: 44px; height: 44px; border-radius: 50%;
            background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.1);
            color: #fff; display: flex; align-items: center; justify-content: center;
            cursor: pointer; font-size: 18px; transition: all .2s;
            z-index: 10; backdrop-filter: blur(4px);
        }
        .nav-arrow:hover { background: rgba(255,255,255,0.18); border-color: rgba(255,255,255,0.25); }
        .nav-arrow.left  { left: 16px; }
        .nav-arrow.right { right: 16px; }

        .empty-slide {
            display: flex; flex-direction: column; align-items: center;
            justify-content: center; color: rgba(255,255,255,0.25); gap: 12px;
        }
        .empty-slide i { font-size: 52px; }
        .empty-slide p { font-size: 13px; }

        .dot-indicators {
            position: absolute; bottom: 14px; left: 50%; transform: translateX(-50%);
            display: flex; gap: 6px;
        }
        .dot {
            width: 6px; height: 6px; border-radius: 50%;
            background: rgba(255,255,255,0.25); transition: all .2s; cursor: pointer;
        }
        .dot.active { background: #fff; width: 18px; border-radius: 3px; }

        /* ── META BAR ── */
        .meta-bar {
            background: var(--card-bg); border: 1px solid var(--card-border);
            border-radius: 12px; padding: 14px 18px;
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 16px; gap: 12px;
        }
        .meta-left { display: flex; align-items: center; gap: 14px; }

        .live-indicator {
            display: flex; align-items: center; gap: 6px;
            font-size: 11px; font-weight: 600; color: var(--success);
            text-transform: uppercase; letter-spacing: .06em;
        }
        .live-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: var(--success); animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; box-shadow: 0 0 0 0 rgba(34,197,94,0.4); }
            50%       { opacity: .7; box-shadow: 0 0 0 6px rgba(34,197,94,0); }
        }

        .meta-divider { width: 1px; height: 28px; background: var(--light); }
        .meta-name { font-size: 14px; font-weight: 600; color: var(--text); }
        .meta-counter {
            font-size: 11px; color: var(--muted);
            text-transform: uppercase; font-weight: 600;
            letter-spacing: .06em; margin-top: 1px;
        }

        .meta-actions { display: flex; gap: 8px; }

        .btn-edit-outline {
            background: transparent; color: var(--accent);
            border: 1px solid rgba(59,130,246,0.3);
            padding: 7px 18px; border-radius: 999px;
            font-size: 13px; font-weight: 500; cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            display: inline-flex; align-items: center; gap: 7px; transition: all .15s;
        }
        .btn-edit-outline:hover { background: var(--accent-soft); border-color: var(--accent); }

        .btn-danger-outline {
            background: transparent; color: var(--danger);
            border: 1px solid rgba(239,68,68,0.3);
            padding: 7px 18px; border-radius: 999px;
            font-size: 13px; font-weight: 500; cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            display: inline-flex; align-items: center; gap: 7px; transition: all .15s;
        }
        .btn-danger-outline:hover { background: rgba(239,68,68,0.06); border-color: var(--danger); }

        /* ── EDIT BOX ── */
        .edit-name-box {
            background: #eff6ff; border: 1px solid rgba(59,130,246,0.2);
            border-left: 4px solid var(--accent); border-radius: 12px;
            padding: 16px 20px; display: none; margin-bottom: 16px;
        }
        .box-inner {
            display: flex; align-items: center; justify-content: space-between; gap: 16px;
        }
        .box-left { display: flex; align-items: center; gap: 14px; flex: 1; }
        .box-icon { font-size: 26px; color: var(--accent); flex-shrink: 0; }
        .box-left > div { flex: 1; }
        .box-left h6 { font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 6px; }

        .edit-input {
            width: 100%; padding: 9px 14px;
            border: 1px solid var(--light); border-radius: 8px;
            font-size: 13px; font-family: 'DM Sans', sans-serif;
            color: var(--text); background: #fff; outline: none; transition: border-color .15s;
        }
        .edit-input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }

        .box-actions { display: flex; gap: 8px; flex-shrink: 0; }

        .btn-cancel {
            background: #fff; color: var(--text); border: 1px solid var(--light);
            padding: 6px 16px; border-radius: 999px; font-size: 12px; font-weight: 500;
            cursor: pointer; font-family: 'DM Sans', sans-serif; transition: all .15s;
        }
        .btn-cancel:hover { border-color: #aaa; }

        .btn-confirm-edit {
            background: var(--accent); color: #fff; border: none;
            padding: 6px 16px; border-radius: 999px; font-size: 12px; font-weight: 500;
            cursor: pointer; font-family: 'DM Sans', sans-serif;
            display: inline-flex; align-items: center; gap: 5px; transition: background .15s;
        }
        .btn-confirm-edit:hover { background: var(--accent-h); }

        /* ── DELETE CONFIRM BOX ── */
        .delete-confirm-box {
            background: #fff7ed; border: 1px solid rgba(249,115,22,0.2);
            border-left: 4px solid #f97316; border-radius: 12px;
            padding: 16px 20px; display: none; margin-bottom: 16px;
        }
        .dc-inner { display: flex; align-items: center; justify-content: space-between; gap: 16px; }
        .dc-left  { display: flex; align-items: center; gap: 14px; }
        .warn-icon { font-size: 26px; color: #f97316; flex-shrink: 0; }
        .delete-confirm-box h6 { font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 2px; }
        .delete-confirm-box p  { font-size: 12px; color: var(--muted); margin: 0; }
        .dc-actions { display: flex; gap: 8px; flex-shrink: 0; }

        .btn-confirm-del {
            background: var(--danger); color: #fff; border: none;
            padding: 6px 16px; border-radius: 999px; font-size: 12px; font-weight: 500;
            cursor: pointer; font-family: 'DM Sans', sans-serif; transition: background .15s;
        }
        .btn-confirm-del:hover { background: #dc2626; }

        /* ── TOAST ── */
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

        /* ── STATUS BAR ── */
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

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            :root { --sidebar-w: 0px; }
            #sidebar    { display: none; }
            .status-bar { left: 0; }
            .meta-bar   { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="top-navbar">
    <a href="index.php" class="navbar-brand-text">Programacion Web</a>
    <ul class="top-nav-links">
        <li><a href="index.php">Inicio</a></li>
        <li><a href="visor.php" class="active">Visor</a></li>
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
        <a href="index.php" class="sidebar-item">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>
        <a href="visor.php" class="sidebar-item active">
            <i class="bi bi-display-fill"></i> Visor
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
                <p class="page-eyebrow">Monitor en Tiempo Real</p>
                <h1 class="page-title">Visor Multimedia</h1>
                <p class="page-subtitle">DBProgWeb &middot; 2026</p>
            </div>
            <a href="index.php" class="btn-custom-primary">
                <i class="bi bi-plus-circle-fill"></i> Subir Imágenes
            </a>
        </div>

        <!-- MONITOR -->
        <div class="monitor-wrap">
            <div class="monitor-topbar">
                <span class="monitor-dot" style="background:#ef4444;"></span>
                <span class="monitor-dot" style="background:#f59e0b;"></span>
                <span class="monitor-dot" style="background:#22c55e;"></span>
                <span class="monitor-title" id="monitor-title-label">Sin archivo seleccionado</span>
            </div>

            <div class="slider-stage" id="contenido-imagen">
                <div class="nav-arrow left" onclick="changeImage(-1)">
                    <i class="bi bi-chevron-left"></i>
                </div>

                <div class="empty-slide">
                    <i class="bi bi-camera-video-off"></i>
                    <p>Cargando repositorio...</p>
                </div>

                <div class="nav-arrow right" onclick="changeImage(1)">
                    <i class="bi bi-chevron-right"></i>
                </div>

                <div class="dot-indicators" id="dot-indicators"></div>
            </div>
        </div>

        <!-- META BAR -->
        <div class="meta-bar">
            <div class="meta-left">
                <div class="live-indicator">
                    <div class="live-dot"></div>
                    En vivo
                </div>
                <div class="meta-divider"></div>
                <div>
                    <div class="meta-name" id="img-name">Cargando...</div>
                    <div class="meta-counter" id="img-counter">0 / 0</div>
                </div>
            </div>
            <div class="meta-actions">
                <button class="btn-edit-outline" id="btn-editar" onclick="abrirEdicion()">
                    <i class="bi bi-pencil-fill"></i> Editar Nombre
                </button>
                <button class="btn-danger-outline" id="btn-borrar" onclick="eliminarImagenActual()">
                    <i class="bi bi-trash3-fill"></i> Eliminar Imagen
                </button>
            </div>
        </div>

        <!-- EDIT NAME BOX -->
        <div class="edit-name-box" id="edit-name-box">
            <div class="box-inner">
                <div class="box-left">
                    <i class="bi bi-pencil-square box-icon"></i>
                    <div>
                        <h6>Editar nombre del archivo</h6>
                        <input type="text" id="edit-nombre-input" class="edit-input" placeholder="Nuevo nombre...">
                    </div>
                </div>
                <div class="box-actions">
                    <button class="btn-cancel" onclick="cerrarEdicion()">Cancelar</button>
                    <button class="btn-confirm-edit" id="btn-confirmar-editar" onclick="confirmarEdicion()">
                        <i class="bi bi-check-lg"></i> Guardar
                    </button>
                </div>
            </div>
        </div>

        <!-- CONFIRM DELETE -->
        <div class="delete-confirm-box" id="delete-confirm">
            <div class="dc-inner">
                <div class="dc-left">
                    <i class="bi bi-exclamation-octagon-fill warn-icon"></i>
                    <div>
                        <h6>¿Confirmar eliminación permanente?</h6>
                        <p id="delete-confirm-name"></p>
                    </div>
                </div>
                <div class="dc-actions">
                    <button class="btn-cancel" onclick="cancelarBorrado()">Cancelar</button>
                    <button class="btn-confirm-del" id="btn-confirmar-borrar">Confirmar</button>
                </div>
            </div>
        </div>

    </div><!-- /content-area -->
</div><!-- /main-wrapper -->

<!-- STATUS BAR -->
<div class="status-bar">
    <div class="status-dot"></div>
    <span class="status-text">
        DBProgWeb conectada &middot; TESVG 2026 &middot; <?php echo htmlspecialchars($_SESSION['usuario']); ?>@tesvg.edu.mx
    </span>
</div>

<!-- TOAST -->
<div id="toast-msg">
    <i class="bi bi-check-circle-fill"></i>
    <span id="toast-text">Listo</span>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
let current = 0;
let fotos   = [];

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

/* DOTS */
function renderDots() {
    const wrap = $('#dot-indicators');
    wrap.empty();
    fotos.forEach(function(_, i) {
        wrap.append(`<div class="dot ${i === current ? 'active' : ''}" onclick="jumpTo(${i})"></div>`);
    });
}

function jumpTo(idx) { current = idx; actualizarVista(); }

/* CARGAR */
function cargarFotos() {
    $.ajax({
        url: 'obtener_todas.php', type: 'GET',
        success: function(res) {
            try { fotos = typeof res === 'string' ? JSON.parse(res) : res; }
            catch(e) { fotos = []; }

            if (fotos.length > 0) {
                let params = new URLSearchParams(window.location.search);
                let idx = parseInt(params.get('idx'));
                if (!isNaN(idx) && idx >= 0 && idx < fotos.length) current = idx;
                actualizarVista();
            } else {
                mostrarVacio();
            }
        },
        error: function() { mostrarVacio('Error al conectar con el servidor'); }
    });
}

function mostrarVacio(msg = 'Sin capturas en el repositorio') {
    const stage = $('#contenido-imagen');
    stage.find('.slide, .empty-slide').remove();
    stage.prepend(`<div class="empty-slide" style="position:relative;z-index:1;">
        <i class="bi bi-camera-video-off"></i><p>${msg}</p></div>`);
    $('#img-name').text('Sin archivos');
    $('#img-counter').text('0 / 0');
    $('#monitor-title-label').text('Sin archivo seleccionado');
    $('#dot-indicators').empty();
}

/* ACTUALIZAR */
function actualizarVista() {
    if (fotos.length === 0) { mostrarVacio(); return; }
    const foto  = fotos[current];
    const stage = $('#contenido-imagen');
    stage.find('.slide, .empty-slide').fadeOut(150, function() {
        $(this).remove();
        const slide = $(`<div class="slide" style="display:none;position:relative;z-index:1;">
            <img src="${foto.ruta}" alt="${foto.nombre}"></div>`);
        stage.prepend(slide);
        slide.fadeIn(200);
    });
    $('#img-name').text(foto.nombre);
    $('#img-counter').text((current + 1) + ' / ' + fotos.length);
    $('#monitor-title-label').text(foto.nombre);
    renderDots();
}

/* NAVEGACIÓN */
function changeImage(dir) {
    if (fotos.length <= 1) return;
    current = (current + dir + fotos.length) % fotos.length;
    actualizarVista();
    showToast('Sincronizado · ' + fotos[current].nombre);
}

$(document).on('keydown', function(e) {
    if (e.key === 'ArrowLeft')  changeImage(-1);
    if (e.key === 'ArrowRight') changeImage(1);
});

/* EDITAR */
function abrirEdicion() {
    if (fotos.length === 0) return;
    $('#edit-nombre-input').val(fotos[current].nombre);
    $('#edit-name-box').slideDown(200);
    $('#btn-editar').prop('disabled', true).css('opacity', '.5');
    $('#delete-confirm').slideUp(100);
    setTimeout(() => $('#edit-nombre-input').focus(), 250);
}

function cerrarEdicion() {
    $('#edit-name-box').slideUp(200);
    $('#btn-editar').prop('disabled', false).css('opacity', '1');
}

function confirmarEdicion() {
    const nuevoNombre = $('#edit-nombre-input').val().trim();
    if (!nuevoNombre) { showToast('El nombre no puede estar vacío.', 'error'); return; }
    if (nuevoNombre === fotos[current].nombre) { cerrarEdicion(); return; }

    $('#btn-confirmar-editar').html('<i class="bi bi-arrow-repeat"></i> Guardando...').prop('disabled', true);
    $.ajax({
        url: 'editar_nombre.php', type: 'POST',
        data: { id: fotos[current].id, nombre: nuevoNombre },
        success: function(res) {
            $('#btn-confirmar-editar').html('<i class="bi bi-check-lg"></i> Guardar').prop('disabled', false);
            if (res.trim().toLowerCase() === 'success' || res.trim() === '1') {
                fotos[current].nombre = nuevoNombre;
                $('#img-name').text(nuevoNombre);
                $('#monitor-title-label').text(nuevoNombre);
                cerrarEdicion();
                showToast('Nombre actualizado correctamente.');
            } else {
                showToast('Error: ' + res, 'error');
            }
        },
        error: function() {
            $('#btn-confirmar-editar').html('<i class="bi bi-check-lg"></i> Guardar').prop('disabled', false);
            showToast('Error de conexión.', 'error');
        }
    });
}

/* ELIMINAR */
function eliminarImagenActual() {
    if (fotos.length === 0) return;
    $('#delete-confirm-name').text('Se eliminará: "' + fotos[current].nombre + '"');
    $('#delete-confirm').slideDown(200);
    $('#btn-borrar').prop('disabled', true).css('opacity', '.5');
    cerrarEdicion();
    $('#btn-confirmar-borrar').off().on('click', function() {
        confirmarBorrado(fotos[current].id, fotos[current].ruta);
    });
}

function cancelarBorrado() {
    $('#delete-confirm').slideUp(200);
    $('#btn-borrar').prop('disabled', false).css('opacity', '1');
    $('#btn-editar').prop('disabled', false).css('opacity', '1');
}

function confirmarBorrado(id, ruta) {
    $('#btn-confirmar-borrar').text('Eliminando...').prop('disabled', true);
    $.ajax({
        url: 'eliminar_foto.php', type: 'POST',
        data: { id: id, ruta: ruta },
        success: function(res) {
            if (res.trim() === 'success') {
                showToast('Registro eliminado correctamente.');
                cancelarBorrado();
                fotos.splice(current, 1);
                if (current >= fotos.length) current = Math.max(0, fotos.length - 1);
                fotos.length === 0 ? mostrarVacio() : actualizarVista();
            } else {
                showToast('Error al eliminar: ' + res, 'error');
                $('#btn-confirmar-borrar').text('Confirmar').prop('disabled', false);
            }
        },
        error: function() {
            showToast('Error de conexión.', 'error');
            $('#btn-confirmar-borrar').text('Confirmar').prop('disabled', false);
        }
    });
}

/* INIT */
$(document).ready(cargarFotos);
</script>

</body>
</html>
