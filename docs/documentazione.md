# Documentazione Framework Banquet

Framework PHP leggero per applicazioni Web, API REST e generazione automatica di componenti.

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

### Comandi principali

```bash
php banquet make:map all               # genera Entity/DAO/Model/Service per tutte le tabelle
php banquet make:map all --prefix=tbl_ # genera Entity/DAO/Model/Service per tutte le tabelle elimina il prefisso
php banquet make:map corsi    # genera solo per la tabella specificata
php banquet make:map corsi full-action  # genera Entity/DAO/Model/Service + Action + view + route + Api
php banquet make:action corsi       # Action + view + route
php banquet make:action <nome-action> <nome-service> # Action associa il Service indicato + view + route
php banquet make:api corsi   # genera API REST per Corsi
php banquet generate --class-dao  # genera la classe astratta Dao
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

## 7. Generatore automatico

Lo script `banquet make:map` crea classi e file base per il progetto.

### Opzioni principali

- `--dsn=DSN`
- `--user=USER`
- `--pass=PASS`
- `--table=TABELLA`
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

### Esempi di comando

```bash
php banquet make:map all
php banquet make:map corsi
php banquet make:action Corsi  
php banquet make:api Corsi  
php banquet make:map Corsi full-action
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

- Le costanti di configurazione principali sono in `app/setting/config.php`
- `banquet generate` legge anche `app/src/ms/ms-config.php` se non viene passato `--dsn`
- La lingua corrente è gestita in sessione tramite `KEY_LANG`
- `Factory` espone `set()` e `get()` per dati globali

---

## 10. Note rapide

- Usa Composer per l'autoload PSR-4
- Le Action possono avere dipendenze iniettate automaticamente dal container
- Il generatore aiuta a creare Action, Entity, DAO, Model e Service in modo veloce
- Il router supporta `GET`, `POST`, `PUT`, `DELETE`,`OPTIONS`,`HEAD`,`PATCH` e middleware base
