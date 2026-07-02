# Documentazione Banquet Tool

Banquet è uno strumento PHP che accelera lo sviluppo generando automaticamente il layer applicativo (Entity, DAO, Model, Service, API e Route) a partire dal database.<br>

- **Namespace root**: `Banquet\` (PSR-4 → `app/src/`)
- **PHP**: >= 7.4
- **Autoload**: Composer
- **Pattern**: Front Controller, DI Container, Router con parametri, Action/Service/DAO/Entity generator

---

## Indice

1. [Struttura delle directory](#1-struttura-delle-directory)
2. [Entry point e flusso di richiesta](#2-entry-point-e-flusso-di-richiesta)
3. [Routing](#3-routing)
4. [Actions (Controller)](#4-actions-controller)
5. [Factory e rendering](#5-factory-e-rendering)
6. [Middleware](#6-middleware)
7. [Generatore automatico](#7-generatore-automatico)
8. [Esempi pratici di Action](#8-esempi-pratici-di-action)
9. [Configurazione](#9-configurazione)

---

## 1. Struttura delle directory

```
banquet/
├── index.php
├── composer.json
├── app/
│   ├── log.txt
│   ├── brand/
│   │   ├── css/
│   │   ├── fonts/
│   │   ├── images/
│   │   └── js/
│   ├── setting/
│   │   ├── config.php
│   │   ├── startup.php
│   │   └── prop/
│   │       └── action-name.php
│   └── src/
│       ├── Core/
│       │   ├── Action.php
│       │   ├── Container.php
│       │   ├── Encryption.php
│       │   ├── Factory.php
│       │   ├── Load.php
│       │   ├── Log.php
│       │   ├── Mail.php
│       │   ├── Response.php
│       │   ├── Router.php
│       │   └── SenderAction.php
│       ├── Actions/
│       │   ├── Home.php
│       │   ├── Login.php
│       │   ├── Logout.php
│       │   ├── Abbonamenti.php
│       │   ├── Doc.php
│       │   ├── Rest.php
│       │   ├── Api/
│       │   ├── Header/
│       │   ├── Footer/
│       │   ├── Menu/
│       │   └── Notfound/
│       ├── Service/
│       ├── Model/
│       ├── Dao/
│       ├── Entity/
│       ├── Driver/
│       ├── routes/
│       └── view/
└── bin/
│  
│      
└── banquet     
```

---

## 2. Entry point e flusso di richiesta

### `index.php`

Il front controller è `index.php`.

Esegue:

- `require __DIR__ . '/vendor/autoload.php'`
- crea `\Banquet\Core\Response`
- crea `\Banquet\Core\Container`
- registra il container in `Factory`
- avvia la sessione PHP
- chiama `Factory::output(Action::getAction())`

### Flusso

1. `Action::getAction()` carica `app/src/routes/web.php`
2. Il `Router` valuta l'URI e restituisce la classe Action
3. `Factory::output()` risolve l'Action dal container
4. L'Action esegue `send()`
5. Il template viene renderizzato e inviato

---

## Quickstart
```bash
# creo un progetto
1. composer create-project mssalvo/banquet my-app
# configuro il database (nel file .env)
2. Configura il database e imposta JWT_SECRET
# genero l'api rest per la tabella corsi
3. php banquet make:api corsi
# avvio il server ed accedo all'url
4. php -S localhost:8000
# ottengo un token JWT
5. curl -X POST http://localhost:8000/api/login -H "Content-Type: application/json" -d '{"username":"banquet","password":"banquet"}'
# chiamo l'endpoint protetto con il token
6. curl -X POST http://localhost:8000/api/corsi -H "Authorization: Bearer <token>" -H "Content-Type: application/json" -d '{"nome":"Corso base"}'
```

### Comandi principali

```bash
php banquet --help
php banquet make:map all               # genera Entity/DAO/Model/Service per tutte le tabelle
php banquet make:map all --prefix=tbl_ # genera Entity/DAO/Model/Service per tutte le tabelle elimina il prefisso
php banquet make:map corsi    # genera solo per la tabella specificata
php banquet make:map corsi full-action  # genera Entity/DAO/Model/Service + Action + view + route + Api
php banquet make:action corsi       # Action + view + route se presente il service corsi verrà iniettato nel costruttore altrimenti genera action senza dipendenza
php banquet make:action <nome-action> --action-service=<nome-service> # Action associa il Service + view + route. Verrà iniettato nel costruttore lo specifico service <nome-service>
php banquet make:action <nome-action> --table=<nome-action> # se non esiste il service recupera dal database la tabella e ricrea la struttura Entity,Dao,Model,Service
php banquet make:action <nome-action> --not-view # genera solo Action e Route, senza View
php banquet make:action <nome-action> --not-route # genera solo Action e View, senza Route
php banquet make:action <nome-action> --with-api # genera Action, View, Route e chiama l'API REST generata per la stessa risorsa
php banquet make:api corsi   # genera API REST per Corsi
php banquet make:api <nome-api> --action-service=<service> # genera API REST per nome-api ed inietta il service specificato
php banquet make:api <nome-api> --prefix=tbl_ # genera API REST per una tabella con prefisso
php banquet generate --class-dao  # genera la classe astratta Dao / se si cancella per errore
```

### Percorsi utili

- Rotte: `app/src/routes/web.php`
- Action: `app/src/Actions/`
- View: `app/src/view/pages/`
- API REST: `app/src/Actions/Api/`

---

## 3. Routing

### `app/src/routes/web.php`

Il router supporta i metodi HTTP **GET**, **POST**, **PUT**, **DELETE**.

Esempio attuale:

```php
$router = new \Banquet\Core\Router();

$router->get('/', \Banquet\Actions\Home::class);
$router->get('/home', \Banquet\Actions\Home::class);
$router->get('/doc/{tipo}/{id}', \Banquet\Actions\Doc::class);
$router->get('/doc', \Banquet\Actions\Doc::class);
$router->get('/rest', \Banquet\Actions\Rest::class);
$router->get('/rest/{id}', \Banquet\Actions\Rest::class);
$router->get('/rest/{slug}-{id}', \Banquet\Actions\Rest::class);
$router->get('/rest/{id}/{code}', \Banquet\Actions\Rest::class)->middleware('auth');
$router->get('/utente/{id}', \Banquet\Actions\Home::class)->middleware('auth');
$router->get('/login', \Banquet\Actions\Login::class);
$router->post('/login', \Banquet\Actions\Login::class);

return $router;
```

### Pattern supportati

- `{id}` → parametro dinamico
- `{id:\d+}` → parametro con regex custom
- `{slug}-{id}` → parametri combinati con separatore

### Parametri di route

Nell'Action si leggono con:

```php
$id = $this->route('id');
$slug = $this->route('slug');
$params = $this->route();
```

I parametri sono salvati in `$_REQUEST['_route_params']`.

---

## 4. Actions (Controller)

Le Action estendono `Banquet\Core\SenderAction` e implementano `send()`.

### Struttura base

```php
<?php

namespace Banquet\Actions;

use Banquet\Core\SenderAction;

class MiaAction extends SenderAction
{
    public function __construct() {
        // dipendenze iniettate automaticamente
    }

    public function send()
    {
        $this->setTemplateName('pages/mia-pagina');
        $this->setTemplateChildren([
            \Banquet\Actions\Header\Header::class,
            \Banquet\Actions\Menu\Menu::class,
            \Banquet\Actions\Footer\Footer::class,
        ]);

        $this->varAdd('titolo', 'Mia pagina');
        $this->varAdd('contenuto', 'Contenuto dinamico.');

        return $this->getTemplate('default');
    }
}
```

### Metodi utili in `SenderAction`

- `setTitle($title)`
- `setDescription($description)`
- `setKeywords($keywords)`
- `setTemplateName($template)`
- `setTemplateChildren($children)`
- `getTemplate($masterTemplate)`
- `varAdd($key, $value)`
- `addLink($href, $rel)`
- `addStyle($href, $rel, $media)`
- `addScript($script)`
- `route($key)`
- `getParameter($param)`
- `getRequestMethod()`
- `getPost($param)`
- `getGet($param)`
- `getSession($key)` / `setSession($key, $value)`
- `getCookie($key)` / `setCookie(...)`
- `redirect($uri, $method, $code)`
- `load($path)`
- `loadLanguage()`
- `getLangName()` / `setLangName($lang)`
- `logInfo($msg)` / `logError($msg)`
- `getResponse()`

### Children

I children sono Action secondarie incluse nel master template:

```php
$this->setTemplateChildren([
    \Banquet\Actions\Header\Header::class,
    \Banquet\Actions\Header\Carousel::class,
    \Banquet\Actions\Menu\Menu::class,
    \Banquet\Actions\Footer\Footer::class,
]);
```

I dati renderizzati diventano variabili come `$Header`, `$Menu`, `$Footer`, `$Carousel`.

---

## 5. Factory e rendering

`Banquet\Core\Factory` risolve le Action e produce l'output.

- `Factory::output($actionClass)` risolve l'Action dal container.
- `Factory::getOutput($actionClass)` chiama il metodo `send()`.
- `Factory::getTemplate($data, $template, $children, $masterTemplate)` carica il template.
- Se è impostato un master template, viene usato quello; altrimenti si usa il master basato sulla Action.
- L'output finale viene inviato da `Response`.

---

## 6. Middleware

Il router supporta middleware con `->middleware('auth')` e `->middleware('guest')`.

Esempi:

```php
$router->get('/rest/{id}/{code}', \Banquet\Actions\Rest::class)->middleware('auth');
$router->get('/login', \Banquet\Actions\Login::class)->middleware('guest');
```

Comportamento attuale:

- `auth`: se `$_SESSION['user_id']` non esiste, reindirizza a `/login`
- `guest`: se `$_SESSION['user_id']` esiste, reindirizza a `/`

Puoi estendere `runMiddleware()` in `app/src/Core/Router.php` per altri middleware.

---

## 6.1 Autenticazione API REST con JWT

Banquet supporta l'autenticazione REST basata su token JWT e fornisce un fallback Basic Auth per test rapidi.

### Endpoint di autenticazione

- `POST /api/login` → genera il token JWT.
- `POST /api/logout` → revoca il token (blacklist opzionale).

> Attenzione: per l'integrità del sistema di autenticazione non rimuovere le rotte `api/login` e `api/logout` da `app/src/routes/web.php`.

### Configurazione

Nel file `.env` imposta la chiave segreta:

```text
JWT_SECRET=una_chiave_segreta_lunga_e_random
```

### Flusso di autenticazione

1. Il client invia username e password a `/api/login`.
2. Il server risponde con `access_token`, `token_type` e `expires_in`.
3. Il client invia il token nelle richieste protette con l'header:

```http
Authorization: Bearer <token>
```

4. Nei metodi REST protetti viene chiamato `validateAuthToken()`.

### Come funziona `validateAuthToken()`

La classe `Banquet\Core\ActionRestAuthorization` esegue i seguenti controlli:

- Legge l'header `Authorization` in modo cross-platform.
- Se trova `Bearer <token>`, valida il JWT con `JwtService::validate()`.
- Se trova `Basic <base64>`, decodifica le credenziali e le verifica (esempio `banquet:banquet`).
- Se il controllo fallisce, risponde con 401 Unauthorized.

### `JwtService`

Il servizio JWT offre:

- `JwtService::generate(array $payload, int $expirySeconds = 3600)` → genera un token JWT.
- `JwtService::validate(string $jwt)` → valida firma, scadenza e blacklist opzionale.

### Esempio di login

```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"username":"banquet","password":"banquet"}'
```

Risposta:

```json
{
  "access_token": "eyJ...",
  "token_type": "Bearer",
  "expires_in": 3600
}
```

### Esempio di chiamata protetta

```bash
curl -X POST http://localhost:8000/api/corsi \
  -H "Authorization: Bearer eyJ..." \
  -H "Content-Type: application/json" \
  -d '{"nome":"Corso base","durata":"10h"}'
```

### API aperta / senza autenticazione

Se non desideri la validazione, elimina semplicemente la chiamata a `$this->validateAuthToken();` dai metodi REST protetti. In questo modo l'endpoint diventa un'API libera, accessibile senza token.

### Esempio di logout

```bash
curl -X POST http://localhost:8000/api/logout \
  -H "Authorization: Bearer eyJ..."
```

### Validazioni dei metodi REST nell'esempio `CorsiRest`

La classe `app/src/Actions/Api/CorsiRest.php` utilizza `validateAuthToken()` sui metodi:

- `POST` → crea un nuovo corso.
- `PUT` → aggiorna un corso.
- `DELETE` → elimina un corso.

Il metodo `GET` è lasciato pubblico nell'esempio, ma puoi aggiungere l'autenticazione anche per le letture.

### Come estendere

Se vuoi proteggere anche `GET`, aggiungi `validateAuthToken()` all'interno del `case 'GET'`.

### Nota sulla blacklist

`JwtService::isBlacklisted()` è già presente come helper. Se vuoi revocare i token dopo il logout:

- crea una tabella `jwt_blacklist` con `jti` e `scade_il`
- salva il `jti` del token a logout
- decommenta il controllo in `JwtService::validate()`.

---

## 7. Generatore automatico

Lo script `banquet make:map` crea classi e file base per il progetto.

### Opzioni principali

- `--dsn=DSN`
- `--user=USER`
- `--pass=PASS`
- `--table=TABELLA`
- `--action-service=SERVICE`
- `--prefix=PREFIX`
- `--not-view`
- `--not-route`
- `--class-dao`
- `--help`

### Cosa genera

- Senza `--not-view`: `Action`, `View`, `Route`
- Con `--not-view`: `Action`,  `Route`
- Senza `--not-route`: `Action`, `View`, `Route`
- Con `--not-route`: `Action`, `View`

### Parametri utili per `make:api`

| Opzione | Descrizione | Esempio |
|---|---|---|
| `--action-service=<service>` | Inietta il `Service` specificato nell'API REST generata. Utile quando vuoi riutilizzare la business logic esistente. | `php banquet make:api corsi --action-service=Corsi` |
| `--prefix=<prefisso>` | Usa il prefisso della tabella nel database se le tue tabelle iniziano con `tbl_`, `app_`, ecc. | `php banquet make:api corsi --prefix=tbl_` |
| `--table=<nome-tabella>` | Indica la tabella reale del database quando il nome dell'API è diverso dal nome della tabella. | `php banquet make:api corsi --table=tbl_corsi` |
| `--dsn=<dsn> --user=<user> --pass=<pass>` | Fornisce una connessione DB esplicita al comando quando vuoi generare da un database specifico. | `php banquet make:api corsi --dsn="mysql:host=localhost;dbname=framework" --user=root --pass=root` |

### Esempi di comando

```bash
php banquet make:map all
php banquet make:map corsi
php banquet make:map corsi full-action
php banquet make:action corsi  
php banquet make:action corsi  --table=corsi
php banquet make:action CorsiUtenti  --action-service=utenti
php banquet make:action CorsiUtenti  --action-service=utenti --table=utenti
php banquet make:action CorsiUtenti  # se il service non esiste non ci sarà injecton 
php banquet make:api corsi  
php banquet make:api corsiSicurezza --action-service=utenti
php banquet --class-dao
php banquet --help
```

### Esempio di Action generata

```php
<?php

namespace Banquet\Actions;

use Banquet\Core\SenderAction;
use Banquet\Service\CorsiService;

class Corsi extends SenderAction
{
    private $service;

    public function __construct(CorsiService $service) {
        $this->service = $service;
    }

    public function send() {
        $this->setTemplateName('pages/corsi');
        $this->varAdd('corsi', $this->service->getAllCorsi());
        return $this->getTemplate('default');
    }
}
```

### Esempio di view generata

```php
<a href="/corsi/create">Nuovo</a>

<ul>
<?php foreach ($corsi as $corsiItem): ?>
    <li>
        <?= $corsiItem->id ?>
        <a href="/corsi/edit/<?= $corsiItem->id ?>">Edit</a>
        <a href="/corsi/delete/<?= $corsiItem->id ?>">Delete</a>
    </li>
<?php endforeach; ?>
</ul>
```

### Esempio di API REST generata

```php
<?php

namespace Banquet\Actions\Api;

use Banquet\Core\SenderAction;
use Banquet\Service\CorsiService;

class CorsiRest extends SenderAction
{
    private $service;

    public function __construct(CorsiService $service) {
        $this->service = $service;
    }

    public function send() {
        $this->setTemplateName('pages/json');

        if ($this->route('id') != null) {
            $result = $this->service->getCorsiById($this->route('id'));
        } else {
            $result = $this->service->getAllCorsi();
        }

        $this->varAdd('json', json_encode($result));
        $this->getResponse()->addHeader('Content-Type: application/json');

        return $this->getTemplate('empty');
    }
}
```

### Rotte generate automaticamente

- `make:action` aggiunge `GET /corsi` in `app/src/routes/web.php`
- `make:api` aggiunge `GET/POST/PUT  /api/corsi` e `GET/DELETE  /api/corsi/{id}`

---

## 8. Esempi pratici di Action

### Login

```php
<?php

namespace Banquet\Actions;

use Banquet\Core\SenderAction;

class Login extends SenderAction
{
    public function send()
    {
        if ($this->getPost('username') && $this->getPost('password')) {
            $this->setSession('user_id', 123);
            $this->redirect('/home');
        }

        $this->setTemplateName('pages/login');
        $this->setTemplateChildren([
            \Banquet\Actions\Header\Header::class,
            \Banquet\Actions\Footer\Footer::class,
        ]);

        return $this->getTemplate('default');
    }
}
```

### Route con parametri

```php
<?php

namespace Banquet\Actions;

use Banquet\Core\SenderAction;

class Rest extends SenderAction
{
    public function send()
    {
        $id = $this->route('id');
        $slug = $this->route('slug');

        $this->varAdd('id', $id);
        $this->varAdd('slug', $slug);
        $this->setTemplateName('pages/rest');

        return $this->getTemplate('default');
    }
}
```

---

## 9. Configurazione

- Le configurazione principali sono in `app/setting/config.php`
- `Banquet ` legge il file `.env` per la connessione al DB se non viene passato `--dsn`
- La lingua corrente è gestita in sessione tramite `KEY_LANG`
- `Factory` espone `set()` e `get()` per dati globali

---

## 10. Note rapide

- Usa Composer per l'autoload PSR-4
- Le Action possono avere dipendenze iniettate automaticamente dal container
- Il generatore aiuta a creare Action, Entity, DAO, Model e Service in modo veloce
- Il router supporta `GET`, `POST`, `PUT`, `DELETE`,`OPTIONS`,`HEAD`,`PATCH` e middleware base
