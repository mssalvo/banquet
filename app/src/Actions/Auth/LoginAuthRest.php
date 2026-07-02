<?php

/**
 * Generated 02/07/2026 10:55:49
 * Auto-generated tools banquet (https://github.com/mssalvo/banquet)
 * @copyright MIT
 * Api-Rest  Corsi
 */

namespace Banquet\Actions\Auth;

use Banquet\Core\SenderAction;
use Banquet\Core\Jwt\JwtService;

class LoginAuthRest extends SenderAction
{
    private $service;
    public function __construct() {
      
    }
    public function send()
    {
        $this->setTemplateName("pages/json");


        switch ($this->getRequestMethod()) {

                case 'POST':
                 try { 
                 $input = json_decode(file_get_contents('php://input'), true);
        
                $username = $input['username'] ?? '';
                $password = $input['password'] ?? '';

             /**
              * TODO QUI puoi implementare la tua logica di autenticazione, 
              * ad esempio controllando le credenziali nel database. 
              *
              * per semplicità, in questo esempio, 
              * accettiamo solo username "banquet" e password "banquet".      
              */       

        // Simulo il controllo delle credenziali sul database
        if ($username === 'banquet' && $password === 'banquet') {
            
            // Genera un ID unico casuale per il tokenID fondamentale per la blacklist   
              $idTokenUnico = bin2hex(random_bytes(16));      
            // Definisco i dati pubblici dell'utente da salvare nel token
            $payload = [
                'jti'=> $idTokenUnico,
                'user_id' => 42,
                'username' => 'banquet',
                'role' => 'admin'
            ];

            // Genera il JWT (valido per 1 ora / 3600 secondi)
            $token = JwtService::generate($payload, 3600);
            

            // Risponde inviando il token al client
            $this->respondOk([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => 3600
            ]);

            }

            // Credenziali errate
            $this->respondBadRequest('Credenziali fornite non valide.');
                } catch (\Exception $e) {
                    $this->respondServerError($e->getMessage());
                }

                break;

                default:
                $data = ['error' => 'Method not allowed', 'method'=>$this->getRequestMethod()] ;
                   $this->respondOk($data);
                 break;  

                 
        }


            $this->getResponse()->addHeader('Content-Type: application/json');

            return $this->getTemplate('empty');
    }
}
