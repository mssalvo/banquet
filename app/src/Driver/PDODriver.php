<?php

namespace Banquet\Driver;

use PDO;


 
class PDODriver {
 
    private static $instance = null;
    private $pdo = null;
    private $lastInsertId = null;

 
    
    public function __construct() {
        // Configurazione per driver
        //$pdo = new PDO('pgsql:host=localhost;port=5432;dbname=testdb', 'username', 'password');
        //$pdo = new PDO('mysql:host=localhost;dbname=testdb', 'username', 'password');
        //$pdo = new PDO('sqlsrv:Server=localhost;Database=testdb', 'username', 'password');
        //$pdo = new PDO('sqlite:/path/to/database.sqlite');
        $driver = getenv('DB_DRIVER'); // Cambia in 'pgsql', 'sqlite', ecc.
        $host = getenv('DB_HOSTNAME');
        $port = getenv('DB_PORT');
        $dbname = getenv('DB_DATABASE');
        $user = getenv('DB_USERNAME');
        $password = getenv('DB_PASSWORD');
        $pathDbSqllite = getenv('DB_PATH_DATABASE_SQLITE');
        $charset = 'utf8mb4';
        $dsn = '';
        if ($driver === 'mysql') {
            $dsn = "{$driver}:host={$host};dbname={$dbname};charset={$charset}";
        } elseif ($driver === 'pgsql') {
            $dsn = "{$driver}:host={$host};port={$port};dbname={$dbname}";
        } elseif ($driver === 'sqlite') {
            $dsn = "{$driver}:{$pathDbSqllite}";
        } elseif ($driver === 'sqlsrv') {
            $dsn = "{$driver}:Server={$host};Database={$dbname}";
        } else {
            throw new \Exception("Errore: property DB_DRIVER non valida, specifica il driver di connessione al database. es: mysql / pgsql / sqlite / sqlsrv  ");
        }

        // Opzioni di sicurezza e stabilità per PDO
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Lancia eccezioni in caso di errori
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Restituisce array associativi di default
            PDO::ATTR_EMULATE_PREPARES => false, // Usa i prepared statement nativi del database
        ];

        try {
            if ($driver === 'sqlite') {
                $this->pdo = new PDO($dsn, null, null, $options);
                $this->pdo->exec('PRAGMA foreign_keys = ON;');
            } else {
                $this->pdo = new PDO($dsn, $user, $password, $options);
            }
            self::$instance = $this;
        } catch (\PDOException $e) {
            // In produzione logga l'errore e mostra un messaggio generico
            throw new \Exception("Errore di connessione al database: " . $e->getMessage());
        }
    }

    /**
     * Metodo globale per ottenere l'unica istanza PDO driver
     */
    public static function getDriver() {
        if (self::$instance === null) {
            self::$instance = new PDODriver();
        }
        return self::$instance;
    }

    /**
     * Esegue una query con prepared statements (adatta per SELECT, INSERT, UPDATE, DELETE)
     * 
     * @param string $sql La query SQL con i segnaposto (es. :id o ?)
     * @param array $params I parametri da associare alla query
     * @return PDOStatement
     */
    public function query(string $sql, array $params = []) {
        try {
            $this->lastInsertId = null;
            $statementSql = $sql;
            $shouldReturnId = $this->isPostgresInsert($sql) && stripos($sql, 'returning') === false;

            if ($shouldReturnId) {
                $statementSql = rtrim($statementSql, ';') . ' RETURNING id';
            }

            $stmt = $this->pdo->prepare($statementSql);
            $stmt->execute($params);

            if ($shouldReturnId) {
                $insertedId = $stmt->fetchColumn();
                if ($insertedId !== false) {
                    $this->lastInsertId = $insertedId;
                }
            }

            return $stmt;
        } catch (\PDOException $e) {
            throw new \Exception("Errore nella query SQL: " . $e->getMessage());
        }
    }

    /**
     * Scorciatoia per recuperare una singola riga (SELECT)
     */
    public function fetchRow(string $sql, array $params = []) {
        $stmt = $this->query($sql, $params);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Scorciatoia per recuperare tutte le righe (SELECT)
     */
    public function fetchAll(string $sql, array $params = []) {
        return $this->query($sql, $params)->fetchAll();
    }

    /**
     * Restituisce l'ultimo ID inserito (utile dopo una INSERT)
     */
    public function lastInsertId() {
        if ($this->lastInsertId !== null) {
            return $this->lastInsertId;
        }

        return $this->pdo->lastInsertId();
    }

    private function isPostgresInsert(string $sql): bool
    {
        return $this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME) === 'pgsql'
            && preg_match('/^\s*INSERT\b/i', $sql) === 1;
    }

    // Impedisce la clonazione dell'oggetto
    public function __clone() {
        
    }

    // Impedisce la deserializzazione dell'oggetto
    public function __wakeup() {
        
    }
}
