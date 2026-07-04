<?php



namespace Banquet\Model;

class Login {
   
    public function __construct() {
    
    }
    
    public function checkUser($user,$psw){
        
        //... fai qualcosa
        
        return TRUE;
    }

    public function findByEmail($email){
        //Esempio simulazione
        return array("id"=>"145","password"=>password_hash('123456', PASSWORD_DEFAULT));
    }
    
}
