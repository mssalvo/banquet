<?php

/**
 * Generated 02/07/2026 10:55:49
 * Auto-generated tools banquet (https://github.com/mssalvo/banquet)
 * @copyright MIT
 * Api-Rest  Corsi
 */

namespace Banquet\Actions\Auth;

use Banquet\Core\SenderAction;

class LogoutAuthRest extends SenderAction
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

                 $userData = $this->validateAuthToken(); 

                // 2. Estrae il JTI e la scadenza (exp) dal payload
                $jti = $userData['jti'] ?? null;
                $exp = $userData['exp'] ?? null;

          
            // 2. Estrae il JTI e la scadenza (exp) dal payload
            $jti = $userData['jti'] ?? null;
            $exp = $userData['exp'] ?? null;

            if ($jti && $exp) {
                // 3. Salva il JTI nel database per bloccarlo
                /* 
                /* Se si vuole implementare la blacklist dei token nel database bisogna seguire questi passi:
                 * 1. Creare una tabella "jwt_blacklist" con colonne "jti" e "scade_il" (timestamp) nel tuo database.
                 * 2. Decommentare il codice qui sotto per inserire il JTI nella tabella blacklist.
                 * 3. Assicurarsi che la funzione isBlacklisted() in JwtService controlli la tabella "jwt_blacklist" per verificare se il token è stato revocato.   
                 *   in app\src\Core\Jwt\JwtService.php isBlacklisted()  
                 * 4. Assicurarsi che la funzione validate() in JwtService chiami isBlacklisted() per verificare se il token è stato revocato.
                 *    decommenta il "return null;" in validate() alla riga 109
                 *
                 * 
                 * 
                 * Script DDL SQL tabella che puoi creare nel tuo database :
                 *  
                 *   CREATE TABLE jwt_blacklist (
                 *       jti VARCHAR(64) PRIMARY KEY,
                 *       scade_il INT NOT NULL -- Timestamp UNIX in cui il token sarebbe comunque scaduto
                 *       );
                 *  
                 * 
                 * Decommenta questo codice se vuoi implementare la blacklist dei token nel database
                 * 
                $db = new \PDO('mysql:host=localhost;dbname=tua_api', 'root', 'password');
                $stmt = $db->prepare("INSERT INTO jwt_blacklist (jti, scade_il) VALUES (:jti, :scade_il)");
                $stmt->execute([
                    'jti' => $jti,
                    'scade_il' => $exp
                ]);
                }*/
                // 4. Risponde con successo (204 No Content o 200 OK con messaggio)
                $this->respondOk(['message' => 'Logout effettuato con successo. Token revocato.']);
                
                }
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
