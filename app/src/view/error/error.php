<?php
$errorMessage = isset($error) ? $error : 'Si è verificato un errore imprevisto.';
$errorMessage = is_array($errorMessage) ? json_encode($errorMessage, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : $errorMessage;
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Errore</title>
    <style>
        :root {
            --bg: #0f172a;
            --panel: #1a473b;
            --border: #1a473b;
            --text: #e5e7eb;
            --muted: #bbd6d4;
            --accent: #ef4444;
            --accent-soft: #1a473b;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(179deg, #ffffff 0%, #1a473b 100%);
            color: var(--text);
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 24px;
        }

        .error-card {
            width: min(100%, 640px);
            background: var(--panel);
            border: 0px solid var(--border);
            border-radius: 8px;
            /*box-shadow: 0 20px 60px rgba(0, 0, 0, 0.35);*/
            overflow: hidden;
        }

        .error-header {
            padding: 24px 28px 18px;
            border-bottom: 1px solid var(--border);
            background: var(--accent-soft);
        }

        .error-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 12px;
            background: rgba(47, 88, 79, 0.81);
            border: 0px solid rgba(1, 66, 47, 0.77);
            border-radius: 999px;
            color: #dbfdff;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .error-title {
            margin: 14px 0 6px;
            font-size: 28px;
            font-weight: 700;
        }

        .error-subtitle {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
        }

        .error-body {
            padding: 24px 28px 28px;
        }

        .error-label {
            display: inline-block;
            margin-bottom: 10px;
            font-size: 12px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-weight: 700;
        }

        .error-box {
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--border);
            border-left: 4px solid var(--accent);
            border-radius: 6px;
            padding: 16px 18px;
            font-size: 14px;
            line-height: 1.7;
            color: #f8fafc;
            white-space: pre-wrap;
            word-break: break-word;
            font-family: Consolas, Monaco, monospace;
        }

        .error-foot {
            margin-top: 16px;
            font-size: 12px;
            color: var(--muted);
        }

        .btn-home {
            display: inline-block;
            margin-top: 16px;
            padding: 10px 14px;
            border-radius: 8px;
            background: #013a33;
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.2s ease;
        }

        .btn-home:hover {
            background: #01221f;
        }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="error-header">
            <div class="error-badge">⚠ Errore di sistema</div>
            <h1 class="error-title">Si è verificato un problema</h1>
            <p class="error-subtitle">Di seguito trovi la descrizione dettagliata del messaggio di errore.</p>
        </div>
        <div class="error-body">
            <span class="error-label">Dettaglio errore</span>
            <div class="error-box"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></div>
            <div class="error-foot">Se il problema persiste, contatta l’amministratore del sistema.</div>
            <a href="<?=resolveUrl('/home') ?>" class="btn-home">Torna alla home</a>
        </div>
    </div>
</body>
</html>