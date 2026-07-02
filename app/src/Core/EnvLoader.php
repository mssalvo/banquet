<?php

namespace Banquet\Core;

class EnvLoader
{
    /**
     * Carica il file .env e definisce le variabili d'ambiente
     */
    public static function load(string $filePath)
    {
        if (!file_exists($filePath)) {
            return; // Se il file non esiste, esce silenziosamente
        }

        // Legge il file riga per riga
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $line = trim($line);

            // Ignora le righe vuote o i commenti che iniziano con #
            if ($line === '' || strpos($line, '#') === 0) {
                continue;
            }

            // Divide la riga al primo simbolo "=" trovato
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                
                $key = trim($key);
                $value = trim($value);

                // Rimuove eventuali virgolette singole o doppie attorno al valore
                $value = trim($value, '"\'');

                // Salva il valore sia nel sistema sia nell'array globale $_ENV
                putenv("$key=$value");
                $_ENV[$key] = $value;
            }
        }
    }


 public static function loadArray(string $filePath)
    {
        $arrayEnv = [];
        if (!file_exists($filePath)) {
            return; // Se il file non esiste, esce silenziosamente
        }

        // Legge il file riga per riga
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $line = trim($line);

            // Ignora le righe vuote o i commenti che iniziano con #
            if ($line === '' || strpos($line, '#') === 0) {
                continue;
            }

            // Divide la riga al primo simbolo "=" trovato
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                
                $key = trim($key);
                $value = trim($value);

                // Rimuove eventuali virgolette singole o doppie attorno al valore
                $value = trim($value, '"\'');

                // Salva il valore sia nel sistema sia nell'array globale $_ENV
                putenv("$key=$value");
                $_ENV[$key] = $value;
                $arrayEnv[$key] = $value;
            }
        }
        return $arrayEnv;
    }

}