<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>404 - Pagina non trovata</title>
  <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
    html, body { height: 100%; }
    body {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
      background: linear-gradient(179deg, #ffffff 0%, #1a473b 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      color: #e0e0e0;
      line-height: 1.6;
    }
    .container {
      text-align: center;
      padding: 2rem;
      max-width: 600px;
    }
    .error-code {
      font-size: 8rem;
      font-weight: 700;
      background: linear-gradient(135deg, #042917, #031d01);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      line-height: 1;
      letter-spacing: -4px;
    }
    .divider {
      width: 60px;
      height: 3px;
      background: #e94560;
      margin: 1.5rem auto;
      border-radius: 2px;
    }
    h1 {
      font-size: 1.5rem;
      font-weight: 600;
      color: #ffffff;
      margin-bottom: 0.75rem;
    }
    p {
      font-size: 1rem;
      color: #f8f8f8;
      margin-bottom: 2rem;
    }
    .btn-home {
      display: inline-block;
      padding: 0.75rem 2rem;
      background: #316643;
      color: #ffffff;
      text-decoration: none;
      border-radius: 6px;
      font-weight: 500;
      transition: background 0.2s, transform 0.15s;
      border: none;
      cursor: pointer;
    }
    .btn-home:hover {
      background: #072926;
      transform: translateY(-1px);
    }
    .btn-home:active {
      transform: translateY(0);
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="error-code">404</div>
    <div class="divider"></div>
    <h1>Pagina non trovata</h1>
    <p>La pagina che stai cercando potrebbe essere stata rimossa,<br>rinominata o temporaneamente non disponibile.</p>
    <a href="<?=resolveUrl('/home') ?>" class="btn-home">Torna alla Home</a>
  </div>
</body>
</html>
