<?php
 

//*- Config: CORS Headers ed Preflight */
// - Definisci le origini consentite (puoi usare '*' per consentire TUTTI i domini, ma in produzione è rischioso)
$allowedOrigins = [
    'http://localhost:3000', // Il tuo frontend di sviluppo (es. React)
    'https://iltuosito.com' // Il tuo sito in produzione
];

// Se vuoi limitare l'accesso a specifici domini, decommenta e usa  
// l'array come sopra per verificare l'origine della richiesta:
//if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowedOrigins)) {
//    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
//}

// NOTA: Se vuoi permettere l'accesso a CHIUNQUE (es. API pubblica), usa semplicemente:
	header("Access-Control-Allow-Origin: *");

// - Specifica quali metodi HTTP sono consentiti nella tua API RESTful
	header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// - Specifica quali Header personalizzati il client può inviare (es. Authorization per i token)
	header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// - Gestione della richiesta "Preflight" (Metodo OPTIONS)
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // I browser inviano una richiesta OPTIONS prima di POST/PUT/DELETE per verificare i permessi.
    // Dobbiamo rispondere immediatamente con uno stato 204 (No Content) e interrompere lo script.
    http_response_code(204);
    exit;
}
 
    
 
   
?>