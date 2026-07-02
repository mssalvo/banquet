<p align="center">
  <img src="./app/brand/banquet-logo.png" alt="Banquet" width="200">
</p>

<h1 align="center">Banquet</h1>

<p align="center">
  <strong>Banquet è uno strumento PHP che accelera lo sviluppo generando automaticamente il layer applicativo (Entity, DAO, Model, Service, API e Route) a partire dal database, lasciando al developer la libertà di costruire il resto come preferisce.</strong>
  <br>
  Banquet: genera Entity, DAO, Model, Service, API e Route, Action(opzionale), View(opzionale) .<br>
  MVC · Front Controller · DI Container · Composite View · Routing avanzato · Generatore automatico di classi
  <br><br>
  <img src="https://img.shields.io/badge/PHP-%3E%3D%207.4-777BB4?style=flat-square&logo=php">
<img src="https://img.shields.io/badge/PostgreSQL-%20%7C%20?style=flat-square">
<img src="https://img.shields.io/badge/MySQL-%20%7C%20?style=flat-square">
<img src="https://img.shields.io/badge/Server-4479A1?style=flat-square">
<img src="https://img.shields.io/badge/SQLite-%20%7C%20SQL%20Server-4479A1?style=flat-square">
  <img src="https://img.shields.io/packagist/v/mssalvo/banquet">
<img src="https://img.shields.io/packagist/dt/mssalvo/banquet">
<img src="https://img.shields.io/badge/license-MIT-green?style=flat-square">
</p>
 
---


### 💙 Banquet

> Meno configurazione > Nessuna dipendenza > Più libertà > Più PHP




## 🚀 Installazione


```bash
composer create-project mssalvo/banquet my-app
cd my-app
php -S localhost:8000
```

---
 
### 👉 Come creare una REST API in meno di un minuto con Banquet:

```md
1. Crea una tabella DB corsi
2. php banquet make:api corsi
3. API pronta

```

```md
#    Hai già:
#    GET    /api/corsi      → lista (JSON)
#    GET    /api/corsi/5    → corso #5 (JSON)
#    POST   /api/corsi      → corso (Insert)
#    PUT    /api/corsi      → corso (Update)
#    DELETE /api/corsi/5    → corso #5 (Delete)

Banquet: ha generato -> Entity, DAO, Model, Service, API e Route

```

### Esempio REST con validazione token

1. Imposta il segreto JWT in `.env`:

```ini
JWT_SECRET=una_chiave_segreta_lunga_e_random
```

2. Richiedi il token:

```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"username":"banquet","password":"banquet"}'
```

3. Usa il token per chiamate protette:

```bash
curl -X POST http://localhost:8000/api/corsi \
  -H "Authorization: Bearer <TOKEN>" \
  -H "Content-Type: application/json" \
  -d '{"nome":"Corso base","durata":"10h"}'
```

### API libera

Se vuoi rendere l'endpoint pubblico, elimina `$this->validateAuthToken();` dai metodi che non vuoi proteggere. Così la tua API REST funzionerà senza richiedere token.



## 🚀 Cos'è Banquet

Banquet è un micro-framework + code generator che permette di creare rapidamente:

- Entity
- DAO
- Model
- Service
- API REST
- View (opzionale)
- Routing automatico

Tutto partendo direttamente dalle tabelle del database.

---

# ⚡ Perché utilizzare Banquet?

**Banquet** nasce con un obiettivo semplice: permetterti di sviluppare applicazioni Web e API REST in modo rapido, pulito e senza vincoli.

A differenza di molti framework moderni, **Banquet è scritto in PHP puro** e **non dipende da librerie esterne per il proprio funzionamento**. Nessun ecosistema complesso da imparare, nessuna dipendenza invasiva, nessun obbligo architetturale imposto. Tu hai il controllo totale del tuo progetto.

## 🚀 Libertà totale

Con Banquet non devi adattare il tuo codice al framework.

È il framework che si mette al servizio del tuo codice.

Hai a disposizione una base solida e già strutturata:

* Routing avanzato
* Dependency Injection
* MVC
* API REST
* Generazione automatica di Entity
* DAO
* Model
* Service
* CRUD automatico
* Logging integrato

Ma da quel momento in poi sei completamente libero di costruire ciò che desideri.

## ⚙️ Sviluppa più velocemente

Partendo dalle tabelle del database, Banquet può generare automaticamente:

* Entity
* DAO
* Model
* Service
* Endpoint REST
* Route
* View opzionali

In pochi secondi hai a disposizione una struttura completa e funzionante che ti permette di concentrarti sulla parte più importante del progetto:

**la logica di business.**

## 🔓 Nessun legame, nessuna limitazione

Con Banquet non esistono vincoli tecnologici.

Vuoi usare una libreria esterna?

Perfetto.

Vuoi utilizzare solo PHP puro?

Perfetto.

Vuoi integrare Composer, package esterni o componenti personalizzati?

Perfetto.

Banquet non ti obbliga a seguire una sola strada. Ti fornisce gli strumenti e lascia a te la libertà di scegliere come utilizzarli.

## 🎨 La sola cosa che ti serve è la fantasia

Banquet non cerca di decidere al posto tuo.

Ti offre una base robusta, semplice e produttiva sulla quale costruire qualsiasi cosa:

* Applicazioni aziendali
* API REST
* Microservizi
* Progetti personali

Il limite non è il framework.

**Il limite è soltanto la tua immaginazione.**

## 💙 Banquet è dalla tua parte

Banquet non vuole complicarti la vita con configurazioni infinite, pattern obbligatori o dipendenze nascoste.

Vuole fare esattamente il contrario:

✅ farti risparmiare tempo  
✅ lasciarti il controllo completo  
✅ permetterti di sviluppare velocemente  
✅ aiutarti a trasformare idee in applicazioni reali

**Se hai la voglia di creare e la fantasia di immaginare, Banquet ti fornisce tutto il resto.**



---

## ⚡ Obiettivo

Ridurre drasticamente il tempo di sviluppo:

👉 da database → a API funzionante in pochi secondi.

---

## ✨ Features

- 🧠 Generazione automatica da database
- 📦 CRUD completo out-of-the-box
- 🔌 API REST auto-create
- 🔁 Routing automatico
- 🧱 Architettura MVC
- ⚙️ Dependency Injection Container
- 🔐 Utility di sicurezza disponibili:
  - CSRF protection
  - password hashing
  - session management
- 📜 Supporto metodi HTTP:
  - GET, POST, PUT, DELETE, PATCH, OPTIONS, HEAD
- 🧾 DAO con:
  - getAll()
  - getById()
  - insert / update / delete

---

## 🧩 Generazione automatica

A partire da una tabella database:

```sql
corsi (id, nome, descrizione)
```
```shell 
php banquet make:map corsi full-action
``` 

Banquet genera automaticamente:

- ✅ CorsoEntity
- ✅ CorsoDao
- ✅ CorsoModel
- ✅ CorsoService
- ✅ Endpoint REST
- ✅ Route
- ✅ View (opzionale)




🌐 Esempio API
Dopo generazione:
- GET    /corsi
- GET    /corsi/{id}
- POST   /corsi
- PUT    /corsi
- DELETE /corsi/{id}

▶️ Avvio
```shell
php -S localhost:8000
```
  
---

## 💙 Banquet

| | |
|---|---|
| **Leggero** | Nessuna dipendenza esterna. Solo PHP puro e Composer per l'autoload PSR-4. |
| **Veloce** | Front controller minimale, DI Container con auto-resolution via Reflection. Nessun overhead inutile. |
| **Completo** | MVC, Routing, Middleware, CRUD, API JSON, i18n, Template Composite, Logger, Mail, CSRF. |
| **Produttivo** | Generatore automatico che da una tabella DB produce Entity, DAO, Model, Service, Action, View, Route e REST Api in pochi secondi. |
| **Flessibile** | Supporta MySQL, PostgreSQL, SQLite e SQL Server con un unico driver PDO. |

---
🔐 Utility di Sicurezza

- password_hash / password_verify
- CSRF protection
- sanitizzazione output

---

👉 [Guida rapida](https://github.com/mssalvo/banquet/blob/main/docs/guida-rapida.md)
👉 [Documentazione](https://github.com/mssalvo/banquet/blob/main/docs/documentazione.md)

---

## Inizio Rapido

```bash
# 1. Avvia il server built-in PHP
php -S localhost:8000

# 2. Genera l'intero stack CRUD per la tabella "corsi" crea l'action, crea la view, crea servizio api rest GET/POST/UPDATE/DELETE ed inserisce le root
php banquet make:map corsi full-action

# 3 Aggiorna la dump composer per le nuove classi create
composer dump-autoload

# 4. Visita
#    http://localhost:8000/corsi       ← Lista corsi (HTML)
#    http://localhost:8000/api/corsi   ← Lista corsi (JSON)
```

**9 file generati con un solo comando.** Nessuna scrittura manuale.

---

## Punti di Forza

### 1. Generatore Automatico di Classi

Dimentica la scrittura boilerplate. Banquet legge lo schema del database e genera tutto:

```bash
# Dal database
php banquet make:map all                    # Tutte le tabelle
php banquet make:map clienti                # Una tabella specifica

# Dal Service (Action + View + Route)
php banquet make:action clienti 
# Service diverso (Action +  View + Route ) inietta nel costruttore il setvice OrdiniService (se presente)
php banquet make:action myclienti ordini  

# Dal Service (API + GET/POST/UPDATE/DELETE + Route )
php banquet make:api corsi

```

  Entity → DAO → Model → Service → Action (Web) → Action (REST) → View → Route → Route API

### 2. Routing Espressivo

Pattern matching avanzato con parametri, regex e middleware fluente:

```php
$router->get('/articoli/{slug}', \Banquet\Actions\Articolo::class);
$router->get('/articoli/{id:\d+}', \Banquet\Actions\Articolo::class);
$router->get('/blog/{slug}-{id}', \Banquet\Actions\Articolo::class);
$router->post('/articoli', \Banquet\Actions\Articolo::class)->middleware('auth');
```

### 3. DI Container con Auto-Resolution

Nessuna configurazione. Il container risolve le dipendenze automaticamente:

```php
class Articoli extends SenderAction {
    public function __construct(
        ArticoliService $service,    // Risolto automaticamente
        Logger $log                  // Anche questo
    ) {
        // Pronto all'uso
    }
}
```

### 4. API JSON in una riga

Trasforma qualsiasi Action in un endpoint REST:

```php
class ArticoliRest extends SenderAction {
    public function send() {
        $this->setTemplateName("pages/json");
        $data = $this->route('id')
            ? $this->service->getArticoloById($this->route('id'))
            : $this->service->getAllArticoli();
        $this->varAdd("json", json_encode($data));
        $this->getResponse()->addHeader('Content-Type: application/json');
        return $this->getTemplate('empty');
    }
}
```

### 5. Template Composite

Componi le pagine come blocchi (Header, Menu, Carousel, Footer...):

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

Nel master:

```html
<body>
    <?= $Header ?? '' ?>
    <?= $Menu ?? '' ?>
    <main><?= $default ?? '' ?></main>
    <?= $Footer ?? '' ?>
</body>
```

### 6. Multi-Database

Un unico driver PDO per tutti i database:

| Driver | Configurazione |
|--------|---------------|
| MySQL | `DB_DRIVER=mysql` |
| PostgreSQL | `DB_DRIVER=pgsql` |
| SQLite | `DB_DRIVER=sqlite` |
| SQL Server | `DB_DRIVER=sqlsrv` |

### 7. Middleware

Proteggi le route con middleware dichiarativo:

```php
$router->get('/admin', \Banquet\Actions\Admin\Dashboard::class)->middleware('auth');
$router->get('/login', \Banquet\Actions\Login::class)->middleware('guest');
```

---

## Esempi

### CRUD completo per "Clienti"

```bash
# 1. Crea la tabella MySQL
CREATE TABLE clienti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(100),
    telefono VARCHAR(20)
);

# 2. Genera tutto
php banquet make:map clienti full-action

# 3. Fatto. Hai già:
#    GET  /clienti          → lista (HTML) 
#    GET  /api/clienti      → lista (JSON)
#    GET  /api/clienti/5    → cliente #5 (JSON)
#    POST /api/clienti      → cliente (Insert)
#    PUT  /api/clienti      → cliente (Update)
#    DELETE /api/clienti/5 → cliente #5 (Delete)
```

### Endpoint REST custom

```php
use Banquet\Actions\Api\ClientiRest;

class ClientiRest extends SenderAction {
    private $service;

    public function __construct(ClientiService $service) {
        $this->service = $service;
    }

    public function send() {
        $this->setTemplateName("pages/json");

        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'GET':
                $data = $this->route('id')
                    ? $this->service->getClientiById($this->route('id'))
                    : $this->service->getAllClienti();
                break;
            case 'POST':
                $body = json_decode(file_get_contents('php://input'), true);
                $entity = new Clienti($body);
                $this->service->salva($entity);
                $data = ['success' => true, 'id' => $this->service->getLastId()];
                break;
            default:
                $data = ['error' => 'Method not allowed'];
        }

        $this->varAdd("json", json_encode($data));
        $this->getResponse()->addHeader('Content-Type: application/json');
        return $this->getTemplate('empty');
    }
}
```

---

## Struttura del Progetto

```
banquet/
├── index.php                 # Front controller
├── generator/
│   └── generate.php          # Generatore automatico di classi
├── app/
│   ├── src/
│   │   ├── Core/             # Nucleo del framework
│   │   ├── Actions/          # Controller
│   │   ├── Model/            # Model layer
│   │   ├── Dao/              # Data Access Object
│   │   ├── Service/          # Business logic
│   │   ├── Entity/           # Entity (una per tabella)
│   │   ├── routes/web.php    # Tutte le route
│   │   └── view/             # Template (master, pages, componenti)
│   ├── brand/                # Asset statici
│   └── setting/              # Configurazione
└── vendor/
```

---

## Requisiti

- PHP >= 7.4
- Composer
- PDO extension per il driver scelto (mysql, pgsql, sqlite, sqlsrv)

## Configura dsn

Configura il database nel file `.env` e via.

---

<p align="center">
  <sub>Built with ❤️ for PHP developers who value simplicity and productivity.</sub>
</p>

 
