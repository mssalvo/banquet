<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Guida rapida Banquet</title>
  <style>
    :root {
      --bg: #07111f;
      --panel: #0f172a;
      --panel-2: #111c33;
      --text: #e2e8f0;
      --muted: #94a3b8;
      --accent: #38bdf8;
      --accent-2: #8b5cf6;
      --border: #243449;
      --code: #020617;
    }
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: "Segoe UI", Arial, sans-serif;
      background: linear-gradient(135deg, var(--bg), #0f172a 55%, #111827);
      color: var(--text);
      line-height: 1.7;
    }
    .wrap { max-width: 1100px; margin: 0 auto; padding: 28px 20px 60px; }
    .hero {
      background: var(--panel);
      border: 1px solid var(--border);
      border-radius: 18px;
      padding: 24px 26px;
      margin-bottom: 20px;
      box-shadow: 0 18px 45px rgba(0,0,0,.25);
    }
    h1, h2, h3 { color: #f8fafc; }
    h1 { margin-top: 0; font-size: 2rem; }
    p, li { color: var(--text); }
    .muted { color: var(--muted); }
    .card {
      background: var(--panel-2);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 18px 20px;
      margin-bottom: 16px;
    }
    pre {
      background: var(--code);
      color: #e2e8f0;
      padding: 16px;
      border-radius: 12px;
      overflow-x: auto;
      border: 1px solid var(--border);
    }
    code {
      background: rgba(255,255,255,.06);
      padding: 2px 6px;
      border-radius: 6px;
      color: #f8fafc;
    }
    ol, ul { padding-left: 20px; }
    .step { display: flex; gap: 12px; align-items: flex-start; }
    .step-number {
      flex: 0 0 34px;
      height: 34px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--accent), var(--accent-2));
      color: white;
      display: grid;
      place-items: center;
      font-weight: 700;
    }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="hero">
      <h1>Guida rapida Banquet</h1>
      <p>Questa pagina mostra un flusso step-by-step per avviare un progetto Banquet, configurare il database e generare i componenti.</p>
    </div>

    <div class="card">
      <div class="step">
        <div class="step-number">1</div>
        <div>
          <h3>Scarica il progetto</h3>
          <pre>git clone &lt;url-del-repo&gt;
cd banquet</pre>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="step">
        <div class="step-number">2</div>
        <div>
          <h3>Installa le dipendenze</h3>
          <pre>composer install</pre>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="step">
        <div class="step-number">3</div>
        <div>
          <h3>Configura il database</h3>
          <pre>define('DB_DRIVER', 'mysql');
define('DB_HOSTNAME', 'localhost');
define('DB_PORT', '3306');
define('DB_DATABASE', 'nome_db');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');</pre>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="step">
        <div class="step-number">4</div>
        <div>
          <h3>Esegui il generator</h3>
          <pre>php banquet generate</pre>
          <p class="muted">Puoi anche generare una singola tabella con <code>php banquet make:map nome-tabella</code>.</p>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="step">
        <div class="step-number">5</div>
        <div>
          <h3>Genera una Action completa</h3>
          <pre>php banquet make:action corsi</pre>
          <p class="muted">Questo genera Action, View e rotta.</p>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="step">
        <div class="step-number">6</div>
        <div>
          <h3>Genera l'API REST</h3>
          <pre>php banquet make:api Corsi </pre>
          <p class="muted">Verranno create anche le route API.</p>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="step">
        <div class="step-number">7</div>
        <div>
          <h3>Avvia il progetto</h3>
          <pre>php -S localhost:8000</pre>
          <p class="muted">Poi apri <code>http://localhost:8000/home</code>.</p>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="step">
        <div class="step-number">8</div>
        <div>
          <h3>Esempio pratico</h3>
          <pre>php banquet make:action prodotti</pre>
          <p class="muted">La nuova pagina sarà raggiungibile su <code>/prodotti</code>.</p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
