<p align="center">
  <img src="./app/brand/banquet-logo.png" alt="Banquet" width="200">
</p>

<h1 align="center">Banquet</h1>

<p align="center">
  <strong>Banquet MVC Tool PHP + code generator. Da tabella DB a API funzionante in pochi secondi.</strong>
  <strong><br>Accelera lo sviluppo generando automaticamente il layer applicativo (Entity, DAO, Model, Service, API e Route), lasciando al developer la libertà di costruire il resto come preferisce
  </strong>
  <br>
  MVC · DI Container · Routing · Generatore automatico · API REST
</p>

<p align="center">
    <img src="https://img.shields.io/badge/PHP-%3E%3D%207.4-777BB4?style=flat-square&logo=php">
  <img src="https://img.shields.io/packagist/v/mssalvo/banquet">
<img src="https://img.shields.io/badge/license-MIT-green?style=flat-square">
</p>

---

## Installazione

```bash
composer create-project mssalvo/banquet my-app
cd my-app
php -S localhost:8000
```

## Inizio rapido

```bash
# 1. Avvia il server
php -S localhost:8000

# 2. Genera Entity, DAO, Model, Service, API e Route dalla tabella "corsi"
php banquet make:map corsi full-action

# 3. Aggiorna autoload
composer dump-autoload

# 4. Visita
#    http://localhost:8000/corsi       ← Lista corsi (HTML)
#    http://localhost:8000/api/corsi   ← Lista corsi (JSON)

```

Hai già:
| Metodo | Endpoint | Descrizione |
|--------|----------|-------------|
| GET | `/corsi` | Lista HTML |
| GET | `/api/corsi` | Lista JSON |
| GET | `/api/corsi/{id}` | Singolo record |
| POST | `/api/corsi` | Inserimento |
| PUT | `/api/corsi` | Modifica |
| DELETE | `/api/corsi/{id}` | Eliminazione |

---

👉 [Guida rapida](https://github.com/mssalvo/banquet/blob/main/docs/guida-rapida.md)
👉 [Documentazione](https://github.com/mssalvo/banquet/blob/main/docs/documentazione.md)

---


## API REST con JWT

```bash
# Ottieni token
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"username":"banquet","password":"banquet"}'

# Chiamata protetta
curl -X POST http://localhost:8000/api/corsi \
  -H "Authorization: Bearer <TOKEN>" \
  -H "Content-Type: application/json" \
  -d '{"nome":"Corso base"}'
```

Per API pubbliche, elimina `$this->validateAuthToken();` dai metodi che vuoi rendere accessibili.

## Comandi

| Comando | Cosa genera |
|---------|-------------|
| `php banquet make:map all` | Entity, DAO, Model, Service per tutte le tabelle |
| `php banquet make:map corsi` | Idem per una tabella specifica |
| `php banquet make:map corsi full-action` | Come sopra + Action, View, Route, API REST |
| `php banquet make:action clienti` | Action + View + Route |
| `php banquet make:api corsi` | API REST + Route |
| `php banquet make:api corsi --with-swagger` | API REST + Route + OpenAPI |
| `php banquet make:action myaction --action-service=User` | Action con service diverso |


## OpenAPI / Swagger

Genera annotation OpenAPI su Entity e classi REST, ed esporta il file `openapi.yaml` per visualizzare la documentazione con Swagger UI.

```bash
# 1. Installa la libreria per le annotation
composer require zircote/swagger-php

# 2. Genera Entity e API con annotation OpenAPI
php banquet make:api corsi --with-swagger

# 3. Esporta il file openapi.yaml
./vendor/bin/openapi app -o openapi.yaml
```

Il file `OpenApiConfig.php` (con le info globali: server, security, tag) viene creato automaticamente una sola volta nella directory `app/src/Actions/Api/`.



## Routing

```php
$router->get('/articoli/{slug}', \Banquet\Actions\Articolo::class);
$router->get('/articoli/{id:\d+}', \Banquet\Actions\Articolo::class);
$router->post('/articoli', \Banquet\Actions\Articolo::class)->middleware('auth');
$router->get('/api/corsi', \Banquet\Actions\Api\CorsiRest::class)->rest('getAll');
$router->delete('/api/corsi/{id}', \Banquet\Actions\Api\CorsiRest::class)->rest('getDelete');
```

## DI Container

Il container risolve le dipendenze automaticamente via Reflection:

```php
class Articoli extends SenderAction {
    public function __construct(
        ArticoliService $service,    // Risolto automaticamente
        Logger $log
    ) { }
}
```

## Template Composite

```php
public function send() {
    $this->setTemplateName("pages/home");
    $this->setTemplateChildren([
        \Banquet\Actions\Header\Header::class,
        \Banquet\Actions\Menu\Menu::class,
        \Banquet\Actions\Footer\Footer::class
    ]);
    return $this->getTemplate("default");
}
```

```html
<body>
    <?= $Header ?? '' ?>
    <?= $Menu ?? '' ?>
    <main><?= $default ?? '' ?></main>
    <?= $Footer ?? '' ?>
</body>
```

## Database supportati

| Driver | `DB_DRIVER` |
|--------|-------------|
| MySQL | `mysql` |
| PostgreSQL | `pgsql` |
| SQLite | `sqlite` |
| SQL Server | `sqlsrv` |

## Struttura

```
banquet/
├── index.php                 # Front controller
├── bin/
│   └── generate              # Generatore automatico
├── app/
│   ├── src/
│   │   ├── Core/             # Nucleo framework
│   │   ├── Actions/          # Controller
│   │   ├── Model/            # Model layer
│   │   ├── Dao/              # Data Access Object
│   │   ├── Service/          # Business logic
│   │   ├── Entity/           # Entity (una per tabella)
│   │   ├── routes/web.php    # Route
│   │   └── view/             # Template
│   ├── brand/
│   └── setting/
└── vendor/
```

## Requisiti

- PHP >= 7.4
- Composer
- PDO extension per il driver scelto

---

<p align="center">
  <sub>Built with PHP for simplicity and productivity.</sub>
</p>
