<?php
namespace Banquet\Ms\Core\Jwt;


class JwtService
{
    // Usa una chiave segreta complessa. In produzione va letta dal file .env
    //private static $secretKey = getenv('JWT_SECRET');// 'IL_MIO_SUPER_SEGRETO_ULTRA_SICURO_2026!';


/**
     * Recupera la chiave segreta dal file .env in modo sicuro.
     * Fornisce un valore di backup solo per evitare crash se ci si dimentica il file .env.
     */
    private static function getSecretKey(): string
    {
        $secret = getenv('JWT_SECRET');
        
        if (!$secret) {
            // Avviso di sicurezza o fallback (usa qualcosa di complesso per sicurezza)
            return 'FALLBACK_CHIAVE_DI_EMERGENZA_NON_USARE_IN_PRODUZIONE_@@@!';
        }
        
        return $secret;
    }



    /**
     * Helper per convertire stringhe in Base64Url (richiesto dallo standard JWT)
     */
    private static function base64UrlEncode(string $data): string
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }

    /**
     * Helper per decodificare stringhe da Base64Url
     */
    private static function base64UrlDecode(string $data): string
    {
        $remainder = strlen($data) % 4;
        if ($remainder) {
            $data .= str_repeat('=', 4 - $remainder);
        }
        return base64_decode(str_replace(['-', '_'], ['+', '/'], $data));
    }

    /**
     * Genera un token JWT
     */
    public static function generate(array $payload, int $expirySeconds = 3600): string
    {
        // 1. Definisce l'Header (Algoritmo e Tipo)
        $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);

        // 2. Arricchisce il Payload con i dati di scadenza (exp) e data creazione (iat)
        $payload['iat'] = time();
        $payload['exp'] = time() + $expirySeconds;
        $payloadString = json_encode($payload);

        // 3. Codifica Header e Payload in Base64Url
        $base64UrlHeader = self::base64UrlEncode($header);
        $base64UrlPayload = self::base64UrlEncode($payloadString);

        // 4. Crea la firma HMAC-SHA256 usando la chiave segreta
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, self::getSecretKey(), true);
        $base64UrlSignature = self::base64UrlEncode($signature);

        // 5. Unisce le tre parti separate dal punto
        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }


/**
 * Controlla se il JTI del token è presente nella lista nera del database
 */
        private static function isBlacklisted(string $jti): bool
        {   /* Decommenta questo codice se vuoi implementare la blacklist dei token nel database
            // Esempio con PDO (sostituisci con la tua reale connessione al DB)
            $db = new PDO('mysql:host=localhost;dbname=tua_api', 'root', 'password');
            
            $stmt = $db->prepare("SELECT 1 FROM jwt_blacklist WHERE jti = :jti LIMIT 1");
            $stmt->execute(['jti' => $jti]);
            
            return $stmt->fetch() !== false; // Ritorna true se il token è stato revocato
            */
            return false; // Per ora, nessun token è in blacklist
        }




    /**
     * Valida un token JWT e ne restituisce il payload se valido
     */
    public static function validate(string $jwt)
    {
        // Divide il token nelle sue 3 parti componenti
        $tokenParts = explode('.', $jwt);
        if (count($tokenParts) !== 3) {
            return null; // Formato non valido
        }

        list($base64UrlHeader, $base64UrlPayload, $base64UrlSignature) = $tokenParts;

        // Ricalcola la firma basandosi sui dati ricevuti e la chiave segreta locale
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, self::getSecretKey(), true);
        $expectedSignature = self::base64UrlEncode($signature);

        // Verifica se la firma corrisponde (evita attacchi di tipo "timing attack" usando hash_equals)
        if (!hash_equals($expectedSignature, $base64UrlSignature)) {
            return null; // Token manomesso o non valido
        }

        // Decodifica il payload
        $payload = json_decode(self::base64UrlDecode($base64UrlPayload), true);

        // Verifica se il token è scaduto
        if (isset($payload['exp']) && $payload['exp'] < time()) {
            return null; // Token scaduto
        }

        // Se la firma e la scadenza sono valide, facciamo l'ultimo controllo sul DB:
        if (isset($payload['jti']) && self::isBlacklisted($payload['jti'])) {
        // Il token è valido strutturalmente, ma è stato revocato tramite logout!
        // Da decommentare il return se vuoi implementare la blacklist dei token nel database
        //return null; 
         
          }

        return $payload; // Token valido, restituisce i dati utente
    }
}
