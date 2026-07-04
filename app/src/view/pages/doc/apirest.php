<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Guida rapida Banquet</title>
  <style>
    :root {
      --bg: #dfdfdf;
      --panel: #dfdfdf;
      --panel-2: #dfdfdf;
      --text: #102629;
      --muted: #415d64;
      --accent: #38bdf8;
      --accent-2: #8b5cf6;
      --border: #243449;
      --code: #223c3e;
    }
    * { box-sizing: border-box; }
    body {
     margin: 0;
    font-family: "Segoe UI", Arial, sans-serif;
    /*background: linear-gradient(359deg, var(--bg), #2c4d50 60%, #2c4d50);*/
    color: var(--text);
    line-height: 1.7;
    }
    .wrap { max-width: 1100px; margin: 0 auto; padding: 28px 20px 60px; }
    .hero {
      background: #d1d7d7;
      border: 0px solid var(--border);
      border-radius: 6px;
      padding: 24px 26px;
      margin-bottom: 20px;
      /*box-shadow: 0px 19px 20px 0px #2a6368;*/
    }
    h1, h2, h3 { color: #1f3536; }
    h1 { margin-top: 0; font-size: 2rem; }
    p, li { color: var(--text); }
    .muted { color: var(--muted); }
    .card {
      /*background: var(--panel-2);*/
      border: 0px solid var(--border);
      border-radius: 6px;
      padding: 18px 20px;
      margin-bottom: 16px;
    }
    pre {
      /*background: var(--code);*/
      color: #1f3536;
      padding: 16px;
      border-radius: 6px;
      overflow-x: auto;
      border: 0px solid var(--border);
      font-size: 0.99rem;
    }
    code {
      background: #dfdfdf;
      padding: 2px 6px;
      border-radius: 6px;
      color: #1f3536;
    }
    ol, ul { padding-left: 20px; }
    .step { display: flex; gap: 12px; align-items: flex-start; }
    .step-number {
      flex: 0 0 34px;
      height: 34px;
      border-radius: 50%;
      background: #1f3536;
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
      <h1>Guida rapida creazione di un servizio RestApi</h1>
      <p>Questa pagina mostra un flusso step-by-step per generare le API REST con e senza utilizzo dell'autenticazione JWT tramite <code>/api/login</code> e <code>/api/logout</code>.</p>
    </div>

     <div class="card">
      <div class="step">
        <div class="step-number">1</div>
        <div>
          <h3>Genera l'API REST</h3>
          <pre><b>php banquet make:api Corsi </b></pre>
          <p class="muted">Verranno create anche le route API.</p>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="step">
        <div class="step-number">2</div>
        <div>
          <h3>Esempio chiamata REST protetta</h3>
          <pre>curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"username":"banquet","password":"banquet"}'</pre>
          <p class="muted">Richiedi un token JWT e poi usa <code>Authorization: Bearer &lt;TOKEN&gt;</code> per le chiamate protette.</p>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="step">
        <div class="step-number">3</div>
        <div>
          <h3>Avvia il progetto</h3>
          <pre>php -S localhost:8000</pre>
          <p class="muted">Poi apri <code>http://localhost:8000/home</code>.</p>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="step">
        <div class="step-number">4</div>
        <div>
          <h3>Esempio pratico</h3>
          <pre><b>php banquet make:api Corsi </b></pre>
          <p class="muted">Questo comando crea il servizio Corsi. "CorsiRest" e la sua implementazione. 
          oltre che alla struttura mvc, genera Entity, DAO, Model, Service e le route.   
          
        </p>
           
          <p class="muted">Le url prodotte sono raggiungibili sui seguenti endpoint generati: <br>
           
            <code>GET /api/corsi</code>.<br>
            <code>GET /api/corsi/{id}</code>.<br>
            <code>POST /api/corsi</code>.<br>
            <code>PUT /api/corsi</code>.<br>
            <code>DELETE /api/corsi/{id}</code>.
            </p>
      <p class="muted"><br>
      <b><br>Le chiamate Rest includono il metodo del controller da richiamare (solo per le api rest)</b><br>
      <h3>Route generate in (app/src/routes/web.php)</h3><br>
      <code>$router->get('/api/corsi', \Banquet\Actions\Api\CorsiRest::class)->rest('getAll');</code><br>
      <code>$router->get('/api/corsi/{id}', \Banquet\Actions\Api\CorsiRest::class)->rest('getById');</code><br>
      <code>$router->post('/api/corsi', \Banquet\Actions\Api\CorsiRest::class)->rest('getInsert');</code><br>
      <code>$router->put('/api/corsi', \Banquet\Actions\Api\CorsiRest::class)->rest('getUpdate');</code><br>
      <code>$router->delete('/api/corsi/{id}', \Banquet\Actions\Api\CorsiRest::class)->rest('getDelete');</code>


   </p>         
        </div>
      </div>
    </div>
 
    <div class="card">
      <div class="step">
        <div class="step-number">5</div>
        <div>
          <h3>Endpoint di autenticazione  (app/src/routes/web.php)</h3>
          <pre>
- POST /api/login → genera il token JWT.
- POST /api/logout → revoca il token (blacklist opzionale).
 </pre>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="step">
        <div class="step-number">6</div>
        <div>
          <h3>Attenzione:</h3>
          <pre>
Per l'integrità del sistema di autenticazione non rimuovere 
le rotte `api/login` e `api/logout` da `app/src/routes/web.php`.
 </pre>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="step">
        <div class="step-number">7</div>
        <div>
          <h3>API aperta / senza autenticazione</h3>
          <pre>
Se non desideri la validazione, elimina semplicemente la chiamata a <b>$this->validateAuthToken();</b> dai metodi REST protetti.
In questo modo l'endpoint diventa un'API libera, accessibile senza token.
 
</pre>
        </div>
      </div>
    </div>


    <div class="card">
      <div class="step">
        <div class="step-number">8</div>
        <div>
          <h3>Configura il database nel file (.env)</h3>
          <pre>
  DB_HOSTNAME=localhost
  DB_PORT=3306
  DB_USERNAME=root
  DB_PASSWORD=root
  DB_DATABASE=framework
  #driver gestiti sono: mysql / pgsql / sqlite / sqlsrv 
  DB_DRIVER=mysql
  DB_PATH_DATABASE_SQLITE= </pre>
        </div>
      </div>
    </div>



  </div>
</body>
</html>
