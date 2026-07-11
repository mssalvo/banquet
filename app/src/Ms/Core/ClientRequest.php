<?php
/**
 * Description of ClientRequest
 *
 * @author Salvatore Mariniello
 */
namespace Banquet\Ms\Core;

use Exception;
use stdClass;

class ClientRequest
{
    private $ch;
    private string $url;
    
   
    private ?int $lastStatus = null;
    private ?string $lastMessage = null;

    public function __construct()
    {
    }

 
    public function request(string $method, string $url, $payload = null, array $header = ['Content-Type: application/json'], int $timeout = 10): self
    {
        $this->url = $url;
        $this->ch = curl_init();
        
        $method = strtoupper($method);

    
        curl_setopt($this->ch, CURLOPT_URL, $this->url);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $header);

       
        switch ($method) {
            case "GET":
                break;
            case "POST":
                curl_setopt($this->ch, CURLOPT_POST, true);
                if ($payload !== null) {
                    curl_setopt($this->ch, CURLOPT_POSTFIELDS, is_array($payload) ? json_encode($payload) : $payload);
                }
                break;
            case "PUT":
            case "DELETE":
            case "PATCH":
                curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $method);
                if ($payload !== null) {
                    curl_setopt($this->ch, CURLOPT_POSTFIELDS, is_array($payload) ? json_encode($payload) : $payload);
                }
                break;
            default:
                throw new Exception("Metodo HTTP non supportato: {$method}");
        }

        return $this;
    }

 
    public function getBody(): ?string
    {
        if (!$this->ch) {
            throw new Exception("Nessuna richiesta cURL inizializzata. Chiama prima request().");
        }
        return $this->send();
    }

 
    public function getBodyJson(bool $assoc = false): mixed
    {
        $response = $this->getBody();
        
   
        if ($response === false) {
            throw new Exception("Impossibile connettersi al servizio REST. Errore cURL: " . $this->lastMessage);
        }

   
        if (empty($response)) {
            return $assoc ? [] : new stdClass();
        }

        $decoded = json_decode($response, $assoc);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Il servizio non ha restituito un JSON valido.");
        }

        return $decoded;
    }

 
    public function get(string $url, array $header = ['Content-Type: application/json']): ?string
    {
        return $this->request('GET', $url, null, $header)->getBody();
    }

    public function getJson(string $url, array $header = ['Content-Type: application/json'], bool $assoc = false): mixed
    {
        return $this->request('GET', $url, null, $header)->getBodyJson($assoc);
    }

    public function post(string $url, $payload, array $header = ['Content-Type: application/json']): ?string
    {
        return $this->request('POST', $url, $payload, $header)->getBody();
    }


    public function getLastStatus(): ?int
    {
        return $this->lastStatus;
    }

    public function getLastMessage(): ?string
    {
        return $this->lastMessage;
    }

    private function send(): ?string
    {
        $response = curl_exec($this->ch);
        $error_msg = null;

        if (curl_errno($this->ch)) {
            $error_msg = curl_error($this->ch);
        }

    
        $this->lastStatus = (int) curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
        $this->lastMessage = $error_msg;
        
        curl_close($this->ch);
        $this->ch = null; 

        return $response === false ? false : $response;
    }
}
