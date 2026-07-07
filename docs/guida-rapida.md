# Guida rapida Banquet

Questa guida mostra un flusso completo, passo per passo, per avviare un progetto Banquet, configurare il database e generare i componenti.

## 1. Crea progetto

Crea un nuovo banquet progetto:

```bash
composer create-project mssalvo/banquet my-app
cd my-app
```


## 2. Configura il database

Apri il file:

```text
.env
```

Imposta i valori di connessione come ad esempio:

```php

DB_HOSTNAME=localhost
DB_PORT=3306
DB_USERNAME=root
DB_PASSWORD=root
DB_DATABASE=framework
#driver gestiti sono: mysql / pgsql / sqlite / sqlsrv 
DB_DRIVER=mysql
DB_PATH_DATABASE_SQLITE=

```

Se usi PostgreSQL, imposta:

```php

DB_HOSTNAME=localhost
DB_PORT=5432
DB_USERNAME=postgres
DB_PASSWORD=postgres
DB_DATABASE=mydatabase
#driver gestiti sono: mysql / pgsql / sqlite / sqlsrv 
DB_DRIVER=pgsql
DB_PATH_DATABASE_SQLITE=


```

## 3. Verifica la connessione

Esegui il comando:

```bash
php banquet --help
```

Se appare il menu del generatore, la configurazione è corretta.

## 4. Esegui il generator

Genera tutto per tutte le tabelle:

```bash
php banquet make:map all
```

Genera solo una tabella:

```bash
php banquet make:map utenti
```

## 5. Genera una Action completa

Esempio:

```bash
php banquet make:action Corsi
```

Questo genera:

- Action (con attributo `#[Route]`)
- View

### Nuove opzioni del generatore Action

- `php banquet make:action Corsi --not-view` → genera solo la Action con la Route (attributo `#[Route]`).
- `php banquet make:action Corsi --not-route` → genera la Action e la View, senza attributo Route.
- `php banquet make:action Corsi --action-service=Corsi` → inietta il service `CorsiService` nel costruttore dell'Action.
- `php banquet make:action ListaCorsi --with-api` → genera l'Action, la View, la Route e abilita l'API REST associata.

## 6. Genera anche l'API REST

Se vuoi generare solo l'API REST per una risorsa:

```bash
php banquet make:api corsi
```

Se hai già una classe Service e vuoi usarla:

```bash
php banquet make:api corsi --action-service=Corsi
```

Se la tabella ha un prefisso nel database:

```bash
php banquet make:api corsi --prefix=tbl_
```

Questo genera:

- API REST
- route API

## 7. Autenticazione REST JWT

Banquet supporta l'autenticazione REST con token JWT tramite gli endpoint `/api/login` e `/api/logout`.

### 7.1 Configura la chiave JWT

Nel file `.env` imposta:

```text
JWT_SECRET=una_chiave_segreta_lunga_e_random
```

### 7.2 Richiedi un token

```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"username":"banquet","password":"banquet"}'
```

Risposta tipica:

```json
{
  "access_token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
  "token_type": "Bearer",
  "expires_in": 3600
}
```

### 7.3 Usa il token per chiamare l'API protetta

```bash
curl -X POST http://localhost:8000/api/corsi \
  -H "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..." \
  -H "Content-Type: application/json" \
  -d '{"nome":"Corso base","durata":"10h"}'
```

### 7.3.1 Disabilitare la validazione token

Se desideri un'API libera, rimuovi `$this->validateAuthToken();` dai metodi `POST`, `PUT`, `DELETE` (o da qualsiasi metodo). La chiamata non verrà più bloccata da Bearer o Basic Auth.

### 7.4 Logout e revoca del token

```bash
curl -X POST http://localhost:8000/api/logout \
  -H "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
```

## 8. Avvia il progetto

Avvia il server PHP integrato:

```bash
php -S localhost:8000
```

Apri nel browser:

```text
http://localhost:8000/home
```

## 8. Esempio pratico: creare una nuova pagina

### Step 1: genera l'Action

```bash
php banquet make:action Prodotti
```

### Step 2: verifica la route generata

Il generatore aggiunge l'attributo `#[Route]` direttamente sul metodo `send()` della Action:

```php
use Banquet\Ms\Core\Attribute\Route;

#[Route('/prodotti', 'GET')]
public function send() {
    // ...
}
```

La route viene rilevata automaticamente dallo scanner riflessivo, senza bisogno di file `web.php`.

### Step 3: apri la view generata

Il file sarà in:

```text
app/src/view/pages/prodotti.php
```

### Step 4: personalizza il contenuto

Aggiungi il markup HTML che desideri.

## 9. Esempio di API REST

Per una tabella chiamata `iscrizione`:

```bash
php banquet make:api Iscrizione
```

Verranno generati i metodi con attributi `#[Route]`:

```php
#[Route('/api/iscrizione', 'GET')]
public function getAll(): void { }

#[Route('/api/iscrizione/{id}', 'GET')]
public function getById($id = null): void { }

#[Route('/api/iscrizione', 'POST')]
public function getInsert(): void { }

#[Route('/api/iscrizione', 'PUT')]
public function getUpdate(): void { }

#[Route('/api/iscrizione/{id}', 'DELETE')]
public function getDelete($id = null): void { }
```

Endpoint disponibili:

```text
GET/POST/PUT  /api/iscrizione
GET/DELETE   /api/iscrizione/{id}
```

## 10. Consigli utili

- Usa sempre nomi chiari per tabelle e classi.
- Controlla i file generati prima di personalizzarli.
- Usa `--prefix` se le tabelle hanno prefissi come `tbl_`.
- Per debug, controlla il file:

```text
app/log.txt
```

##  Risoluzione problemi comuni

### Il generator non si connette al database

- verifica DSN, user e password;
- verifica che il database esista;
- verifica il driver scelto.

### La pagina non si apre

- verifica che il server sia avviato;
- usa l'URL corretto, ad esempio `/home`;
- controlla i log in `app/log.txt`.
