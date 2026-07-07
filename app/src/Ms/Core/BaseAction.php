<?php

namespace Banquet\Ms\Core;

use Banquet\Ms\Core\Log;
use Banquet\Ms\Core\ActionRestAuthorization;

abstract class BaseAction extends ActionRestAuthorization
{

    /**
     * Invia una risposta JSON generica.
     */
    protected function jsonResponse(int $statusCode, $data = null)
    {
        if (ob_get_length()) {
            ob_clean();
        }

        header('Content-Type: application/json; charset=utf-8');
        http_response_code($statusCode);

        if ($data !== null) {
            echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
        exit;
    }

    /**
     * 200 OK - Risposta di successo standard (es. GET o PUT)
     */
    protected function respondOk($data)
    {
        $this->jsonResponse(200, $data);
    }

    /**
     * 201 Created - Risorsa creata con successo (es. POST)
     */
    protected function respondCreated($data)
    { 
        $this->jsonResponse(201, $data);
    }

    /**
     * 204 No Content - Successo senza corpo (es. DELETE)
     */
    protected function respondNoContent()
    {
        $this->jsonResponse(204);
    }

    /**
     * 400 Bad Request - Errore di validazione o dati mancanti
     */
    protected function respondBadRequest(string $message = 'Richiesta non valida')
    {
        Log::writeError("Bad Request: " . $message);
        $this->jsonResponse(400, ['error' => $message]);
    }

    /**
     * 404 Not Found - Risorsa non trovata
     */
    protected function respondNotFound(string $message = 'Risorsa non trovata')
    {
        Log::writeError("Not Found: " . $message);
        $this->jsonResponse(404, ['error' => $message]);
    }

    /**
     * 500 Internal Server Error - Errore lato server
     */
    protected function respondServerError(string $message = 'Errore interno del server')
    {
        Log::writeError("Internal Server Error: " . $message);
        $this->jsonResponse(500, ['error' => 'Internal Server Error', 'message' => $message]);
    }
}