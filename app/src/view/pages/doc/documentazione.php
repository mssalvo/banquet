<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Documentazione Tools Banquet</title>
  <style>
    :root {
      --bg: #2c4d50;
      --panel: #2c4d50;
      --panel-2: #2c4d50;
      --text: #11211b;
      --muted: #11211b;
      --accent: #38bdf8;
      --accent-2: #8b5cf6;
      --border: #334155;
      --code-bg:  #2c4d50;;
    }

    * { box-sizing: border-box; }
    body {
    margin: 0;
    font-family: "Segoe UI", Arial, sans-serif;
    /*background: linear-gradient(359deg, var(--bg), #2c4d50 60%, #2c4d50);*/
    color: var(--text);
    line-height: 1.7;
    }

    a { color: var(--accent); }
    code, pre {
      font-family: Consolas, Monaco, monospace;
    }

    .wrap {
      max-width: 1100px;
      margin: 0 auto;
      padding: 32px 20px 60px;
    }

    .hero {
      background: #d1d7d7;
    border: 0px solid var(--border);
    border-radius: 6px;
    padding: 28px;
    /*box-shadow: 0 20px 60px #43888e;*/
    margin-bottom: 24px;
    }

    .hero h1 {
      margin: 0 0 10px;
      font-size: 2rem;
    }

    .hero p { color: var(--muted); margin: 0; }

    nav {
    background: #578a8e;
    border: 0px solid var(--border);
    border-radius: 3px;
    padding: 16px 20px;
    position: sticky;
    top: 12px;
    z-index: 10;
    backdrop-filter: blur(8px);
    margin-bottom: 24px;
    }

    nav ul {
      display: flex;
      flex-wrap: wrap;
      gap: 10px 16px;
      list-style: none;
      padding: 0;
      margin: 0;
    }

    nav a {
      text-decoration: none;
      color: var(--text);
      font-size: 0.95rem;
    }

    section {
    background: #dfdfdf;
    border: 0px solid var(--border);
    border-radius: 6px;
    padding: 22px 24px;
    margin-bottom: 20px;
    /*box-shadow: 0 10px 30px #365f63;*/
    }

    h2, h3, h4 {
    margin-top: 10px;
    color: #1c4237;
    margin-bottom: 10px;
    }

    ul, ol { padding-left: 20px; }
    li { margin-bottom: 6px; }

    pre {
      /*background: var(--code-bg);*/
    color: #0f231f;
    padding: 16px;
    border-radius: 12px;
    overflow-x: auto;
      border: 0px solid var(--border);
    }

    code {
      background: rgba(255,255,255,0.06);
      padding: 2px 6px;
      border-radius: 6px;
      color: #11211b;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 16px;
      margin-top: 30px;
    }

    .card {
      /*background: var(--panel-2);*/
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 16px;
    }

    .muted { color: var(--muted); }

    @media (max-width: 720px) {
      .hero h1 { font-size: 1.6rem; }
      nav { position: static; }
    }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="hero">
      <h1>Banquet MVC Documentazione</h1>
      <p>Banquet è uno strumento PHP che accelera lo sviluppo generando automaticamente il layer applicativo (Entity, DAO, Model, Service, API e Route) a partire dal database.</p>
      <p class="muted">In questa documentazione trovi anche le linee guida per le API REST, l'autenticazione JWT e il generatore di classi.</p>
    </div>

    <nav>
      <ul>
        <li><a href="#struttura">Struttura</a></li>
        <li><a href="#request">Entry point</a></li>
        <li><a href="#routing">Routing</a></li>
        <li><a href="#actions">Actions</a></li>
        <li><a href="#factory">Factory</a></li>
        <li><a href="#middleware">Middleware</a></li>
        <li><a href="#generator">Generatore</a></li>
      </ul>
    </nav>

    <section id="struttura">
      <h2>1. Struttura delle directory</h2>
      <pre>banquet/
├── index.php
├── composer.json
├── app/
│   ├── log.txt
│   ├── brand/
│   ├── setting/
│   │   ├── config.php
│   │   ├── startup.php
│   │   └── prop/
│   └── src/
│       ├── Core/
│       ├── Actions/
│       ├── Service/
│       ├── Model/
│       ├── Dao/
│       ├── Entity/
│       ├── Driver/
│       └── view/
└── bin/
     </pre>
    </section>

    <section id="request">
      <h2>2. Entry point e flusso di richiesta</h2>
      <p>Il front controller è <code>index.php</code>. Esegue il caricamento di Composer, crea il container, imposta la response e invoca <code>Factory::output(Action::getAction())</code>.</p>
      <ol>
        <li><code>RouterClass</code> scandisce <code>app/src/Actions/</code> e raccoglie i metodi annotati con <code>#[Route]</code>.</li>
        <li>Il router valuta l'URI e restituisce la classe Action.</li>
        <li><code>Factory::output()</code> risolve l'Action dal container.</li>
        <li>L'Action esegue <code>send()</code>.</li>
        <li>Il template viene renderizzato e inviato al browser.</li>
      </ol>

      <h3>Quickstart</h3>
      <pre>php banquet make:map all
php banquet make:map corsi
php banquet make:action Corsi
php banquet make:api Corsi  
php banquet --class-dao
php banquet --help
</pre>
    </section>

    <section id="routing">
      <h2>3. Routing</h2>
      <p>Il router supporta GET, POST, PUT, DELETE e usa pattern come <code>{id}</code>, <code>{id:\d+}</code> e <code>{slug}-{id}</code>.</p>
      <pre>use Banquet\Ms\Core\Attribute\Route;

class Home extends SenderAction {
    #[Route('/', 'GET')]
    #[Route('/home', 'GET')]
    public function send() { }
}

class Login extends SenderAction {
    #[Route('/login', 'GET')]
    #[Route('/login', 'POST')]
    public function send() { }
}

class CorsiRest extends SenderAction {
    #[Route('/api/corsi', 'GET')]
    public function getAll(): void { }

    #[Route('/api/corsi/{id}', 'GET')]
    public function getById($id = null): void { }

    #[Route('/api/corsi', 'POST')]
    public function getInsert(): void { }

    #[Route('/api/corsi', 'PUT')]
    public function getUpdate(): void { }

    #[Route('/api/corsi/{id}', 'DELETE')]
    public function getDelete($id = null): void { }
}</pre>
    </section>

    <section id="actions">
      <h2>4. Actions (Controller)</h2>
      <p>Le Action estendono <code>Banquet\Core\SenderAction</code> e implementano <code>send()</code>.</p>
      <pre>&lt;?php
namespace Banquet\Actions;

use Banquet\Core\SenderAction;

class MiaAction extends SenderAction
{
    public function send()
    {
        $this->setTemplateName('pages/mia-pagina');
        $this->varAdd('titolo', 'Mia pagina');
        return $this->getTemplate('default');
    }
}</pre>
      <div class="grid">
        <div class="card">
          <h3>Metodi utili</h3>
          <ul>
            <li><code>setTemplateName()</code></li>
            <li><code>setTemplateChildren()</code></li>
            <li><code>varAdd()</code></li>
            <li><code>route()</code></li>
            <li><code>logInfo()</code> / <code>logError()</code></li>
          </ul>
        </div>
        <div class="card">
          <h3>Children</h3>
          <p>I children sono Action secondarie che vengono incluse nel master template e resi disponibili come variabili.</p>
        </div>
      </div>
    </section>

    <section id="factory">
      <h2>5. Factory e rendering</h2>
      <p><code>Banquet\Core\Factory</code> risolve le Action, esegue il rendering dei template e invia l'output tramite la response.</p>
      <ul>
        <li><code>Factory::output($actionClass)</code> risolve l'Action.</li>
        <li><code>Factory::getOutput()</code> chiama <code>send()</code>.</li>
        <li><code>Factory::getTemplate()</code> carica i template.</li>
      </ul>
    </section>

    <section id="middleware">
      <h2>6. Middleware</h2>
      <p>Nel router basato su attributi <code>#[Route]</code> la protezione va gestita direttamente nei metodi Action.</p>
      <pre>public function send() {
    if (!isset($_SESSION['user_id'])) {
        $this->redirect('/login');
        return;
    }
    // ...
}</pre>
    </section>

    <section id="generator">
      <h2>7. Generatore automatico</h2>
      <p>Il comando CLI <code>banquet generate</code> crea classi e file base per Entity, DAO, Model, Service, Action, View e API REST.</p>
      <h3>Opzioni principali</h3>
      <ul>
        <li><code>--dsn</code></li>
        <li><code>--user</code></li>
        <li><code>--pass</code></li>
        <li><code>--prefix</code></li>
        <li><code>--class-dao</code></li>
      </ul>
      <h3>Esempi</h3>
      <pre>php banquet make:map all
php banquet make:map corsi
php banquet make:action Corsi 
php banquet make:api Corsi </pre>
    </section>
  </div>
</body>
</html>
