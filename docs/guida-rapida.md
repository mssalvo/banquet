# Guida rapida Banquet

Questa guida mostra un flusso completo, passo per passo, per avviare un progetto Banquet, configurare il database e generare i componenti.

## 1. Scarica il progetto

Clona il repository o scarica la cartella del progetto:

```bash
git clone <url-del-repo>
cd banquet
```

## 2. Installa le dipendenze

Esegui Composer per installare le dipendenze:

```bash
composer install
```

## 3. Configura il database

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

## 4. Verifica la connessione

Esegui il comando:

```bash
php generator/generate.php --help
```

Se appare il menu del generatore, la configurazione è corretta.

## 5. Esegui il generator

Genera tutto per tutte le tabelle:

```bash
php generator/generate.php
```

Genera solo una tabella:

```bash
php generator/generate.php --table=utenti
```

## 6. Genera una Action completa

Esempio:

```bash
php generator/generate.php --action=Corsi --with-view --with-route
```

Questo genera:

- Action
- View
- Route

## 7. Genera anche l'API REST

```bash
php generator/generate.php --action=Corsi --with-view --with-route --with-api
```

Questo genera anche:

- API REST
- route API

## 8. Avvia il progetto

Avvia il server PHP integrato:

```bash
php -S localhost:8000
```

Apri nel browser:

```text
http://localhost:8000/home
```

## 9. Esempio pratico: creare una nuova pagina

### Step 1: genera l'Action

```bash
php generator/generate.php --action=Prodotti --with-view --with-route
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

## 10. Esempio di API REST

Per una tabella chiamata `iscrizione`:

```bash
php generator/generate.php --action=Iscrizione --with-api
```

Le route saranno disponibili come:

```text
/api/iscrizione
/api/iscrizione/{id}
```

## 11. Consigli utili

- Usa sempre nomi chiari per tabelle e classi.
- Controlla i file generati prima di personalizzarli.
- Usa `--prefix` se le tabelle hanno prefissi come `tbl_`.
- Per debug, controlla il file:

```text
app/log.txt
```

## 12. Risoluzione problemi comuni

### Il generator non si connette al database

- verifica DSN, user e password;
- verifica che il database esista;
- verifica il driver scelto.

### La pagina non si apre

- verifica che il server sia avviato;
- usa l'URL corretto, ad esempio `/home`;
- controlla i log in `app/log.txt`.
