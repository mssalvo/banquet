<?php

namespace Banquet\Core;

use Banquet\Core\Log;

abstract class ActionRestAuthorization 
{

    /**
     * 401 Unauthorized - Accesso negato per token mancante o errato
     */
    protected function respondUnauthorized($message = 'Autenticazione richiesta')
    {

       if (ob_get_length()) {
            ob_clean();
        }

        header('Content-Type: application/json; charset=utf-8');
        http_response_code(401);

        if ($message == null) {
            $message = 'Autenticazione richiesta';
        }

        echo json_encode(['error' => $message], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        
        exit;
 
    }

    /**
     * Recupera l'header Authorization in modo cross-platform.
     */
    private function getAuthorizationHeader()
    {
        $headers = null;
        
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) { // Per server Apache/Nginx standard
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Normalizza le chiavi in minuscolo
            $requestHeaders = array_change_key_case($requestHeaders, CASE_LOWER);
            if (isset($requestHeaders['authorization'])) {
                $headers = trim($requestHeaders['authorization']);
            }
        }
        return $headers;
    }

    /**
     * Metodo di protezione degli endpoint.
     * Verifica la presenza del Bearer Token e la sua validità.
     */
    protected function validateAuthToken()
    {
        $authHeader = $this->getAuthorizationHeader();
        Log::writeInfo("Authorization Header: token:: " . $authHeader);
        // 1. Controlla se l'header Authorization esiste
        if (!$authHeader) {
            Log::writeError("validateAuthToken: Token di autenticazione mancante.");
            $this->respondUnauthorized('Token o credenziali di autenticazione mancanti.');
        }

        // BEARER TOKEN
        // 2. Verifica il formato "Bearer <token>" tramite Regex
        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];

            // 3. Logica di validazione del token.
            // In produzione qui verificherai un JWT (Json Web Token) o cercherai il token nel Database.
            $tokenValido = ($token === "IL_MIO_TOKEN_SEGRETO_123"); // Esempio di token hardcoded per test IL_MIO_TOKEN_SEGRETO_123

            if ($tokenValido) {
                return; // Token valido, l'esecuzione nell'Action  può procedere.
            }
        }

        // BASIC AUTH
        // 3. Verifica il formato "Basic <stringa_base64>" tramite Regex
        if (preg_match('/Basic\s(\S+)/i', $authHeader, $matches)) {
            $base64Credentials = $matches[1];

            // 1. Decodifica la stringa (ottiene il formato "username:password")
            $decodedCredentials = base64_decode($base64Credentials);

            if ($decodedCredentials !== false && strpos($decodedCredentials, ':') !== false) {
                // Esplode la stringa usando i due punti come separatore
                list($username, $password) = explode(':', $decodedCredentials, 2);

                // 2. Logica di validazione delle credenziali.
                // In produzione verificherai questi dati sul database con password_verify()
                $isValidUser = ($username === 'banquet' && $password === 'banquet'); // Esempio di credenziali per test

                if ($isValidUser) {
                    return; // Credenziali corrette, lo script può procedere
                }
            }
        }



        // 4. Se il formato è errato o il token non è valido, blocca tutto
        Log::writeError("Unauthorized: Token o credenziali non valide o scadute.");
        $this->respondUnauthorized('Token o credenziali non valide o scadute.');
    }
}