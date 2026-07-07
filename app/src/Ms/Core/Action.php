<?php

/**
 * Description of Action
 *
 * @author Salvatore Mariniello
 */
namespace Banquet\Ms\Core;


use Banquet\Ms\Core\Log;

class Action {

    private $action_ = array();
 
    public function __construct() {
  
        $file = DIR_ACTION_NAME . 'action-name.php';

        if (file_exists($file)) {
            $_ = array();

            require($file);
            $this->action_ = array_merge($this->action_, $_);
        } else {
            Log::writeError('Impossibile caricare il file action-name  [ ' . DIR_ACTION_NAME . 'action-name.php! ]');
            trigger_error('Errore: Impossibile caricare il file action-name  [ ' . DIR_ACTION_NAME . 'action-name.php! ]');
            exit();
        }
    }

 

    public static function getAction() {
 
        return '';
    }
 
}

?>
