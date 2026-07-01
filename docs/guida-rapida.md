# Guida rapida Banquet

Questa guida mostra un flusso completo, passo per passo, per avviare un progetto Banquet, configurare il database e generare i componenti.

## 1. Scarica il progetto

Clona il repository o scarica la cartella del progetto:

```bash
composer create-project mssalvo/banquet my-app
cd my-app
```


## 2. Configura il database

Apri il file:

```text
app/setting/config.php
```

Imposta i valori di connessione come ad esempio:

```php
define('DB_DRIVER', 'mysql');
define('DB_HOSTNAME', 'localhost');
define('DB_PORT', '3306');
define('DB_DATABASE', 'nome_db');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
```

Se usi PostgreSQL, imposta:

```php
define('DB_DRIVER', 'pgsql');
define('DB_HOSTNAME', 'localhost');
define('DB_PORT', '5432');
define('DB_DATABASE', 'nome_db');
define('DB_USERNAME', 'postgres');
define('DB_PASSWORD', 'password');
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

- Action
- View
- Route

## 6. Genera anche l'API REST

```bash
php banquet make:map corsi full-action
```

Questo genera anche:

- API REST
- route API

## 7. Avvia il progetto

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

### Step 2: apri la rotta generata

Il generatore aggiunge una rotta del tipo:

```php
$router->get('/prodotti', \Banquet\Actions\Prodotti::class);
```

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

Le route saranno disponibili come:

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
