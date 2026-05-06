<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $ebook->title }} - Perpus Sandikta Reader</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:#0f172a; overflow:hidden; height:100vh;
            -webkit-user-select:none; -moz-user-select:none; -ms-user-select:none; user-select:none; }
        .reader-topbar {
            height:56px; background:rgba(15,23,42,0.95); backdrop-filter:blur(20px);
            border-bottom:1px solid rgba(255,255,255,0.08);
            display:flex; align-items:center; justify-content:space-between;
            padding:0 20px; position:fixed; top:0; left:0; right:0; z-index:100;
        }
        .reader-topbar .title { color:#fff; font-weight:600; font-size:14px; }
        .reader-topbar .subtitle { color:rgba(255,255,255,0.4); font-size:11px; }
        .reader-topbar .btn-back {
            display:flex; align-items:center; gap:8px;
            color:rgba(255,255,255,0.7); text-decoration:none; font-size:14px; font-weight:500;
            padding:8px 16px; border-radius:10px; border:1px solid rgba(255,255,255,0.1);
            transition:all .3s;
        }
        .reader-topbar .btn-back:hover { background:rgba(255,255,255,0.1); color:#fff; }
        .pdf-container {
            position:fixed; top:56px; left:0; right:0; bottom:0;
            overflow: auto;
            -webkit-overflow-scrolling: touch;
        }
        .pdf-container iframe {
            width:100%; height:100%; border:none;
        }
        /* Watermark overlay with beautiful repeating pattern */
        .watermark-overlay {
            position: fixed;
            top: 56px;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            z-index: 50;
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='240' height='160'><text x='30' y='100' fill='%233b82f6' font-family='Inter, sans-serif' font-size='22' font-weight='800' transform='rotate(-30, 30, 100)' opacity='0.06'>Sandikta</text></svg>");
            background-repeat: repeat;
        }
        /* Prevent context menu overlay */
        .no-context {
            position:fixed; top:56px; left:0; right:0; bottom:0; z-index:40;
            pointer-events:none;
        }
    </style>
</head>
<body oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
    <div class="reader-topbar">
                <div class="d-flex align-items-center gap-3" style="display:flex;align-items:center;gap:12px;overflow:hidden">
            <a href="{{ route('ebooks.show', $ebook) }}" class="btn-back">
                <i class="bi bi-arrow-left"></i> <span class="d-none d-sm-inline">Kembali</span>
            </a>
            <div style="overflow:hidden">
                <div class="title" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $ebook->title }}</div>
                <div class="subtitle d-none d-md-block">{{ $ebook->author }}</div>
            </div>
        </div>
        <div style="color:rgba(255,255,255,0.3);font-size:11px">
            <i class="bi bi-shield-lock me-1"></i>Protected Reader
        </div>
    </div>

    <div class="pdf-container">
        <iframe src="{{ route('pdf.stream', $ebook) }}?token={{ $token }}#toolbar=0&navpanes=0&scrollbar=1&view=FitH" 
                loading="eager"></iframe>
    </div>

    <!-- Watermark -->
    <div class="watermark-overlay"></div>

    <script>
    // Disable keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl+S, Ctrl+P, Ctrl+Shift+I, Ctrl+U, F12
        if ((e.ctrlKey && (e.key === 's' || e.key === 'p' || e.key === 'u')) ||
            (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'i' || e.key === 'J' || e.key === 'j' || e.key === 'C' || e.key === 'c')) ||
            e.key === 'F12') {
            e.preventDefault();
            e.stopPropagation();
            return false;
        }
    });

    // Disable right-click
    document.addEventListener('contextmenu', e => e.preventDefault());

    // Disable drag
    document.addEventListener('dragstart', e => e.preventDefault());

    // Detect print screen (basic)
    document.addEventListener('keyup', function(e) {
        if (e.key === 'PrintScreen') {
            document.body.style.filter = 'blur(30px)';
            setTimeout(() => { document.body.style.filter = ''; }, 2000);
        }
    });

    // Detect dev tools (basic)
    let devtools = { open: false };
    setInterval(function() {
        let threshold = 160;
        if (window.outerWidth - window.innerWidth > threshold || window.outerHeight - window.innerHeight > threshold) {
            if (!devtools.open) {
                devtools.open = true;
                document.body.innerHTML = '<div style="display:flex;align-items:center;justify-content:center;height:100vh;color:#fff;font-size:20px;text-align:center;padding:20px"><div><i class="bi bi-shield-exclamation" style="font-size:64px;color:#ef4444;display:block;margin-bottom:20px"></i>Akses Ditolak<br><small style="font-size:14px;color:#94a3b8">Developer tools terdeteksi. Halaman ini telah ditutup.</small></div></div>';
            }
        }
    }, 1000);

    // Visibility change - blur when tab not focused
    document.addEventListener('visibilitychange', function() {
        const container = document.querySelector('.pdf-container');
        if (document.hidden) {
            container.style.filter = 'blur(10px)';
        } else {
            container.style.filter = '';
        }
    });
    </script>
</body>
</html>
