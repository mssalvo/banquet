<?php

/**
 * Description of Action
 *
 * @author Salvatore Mariniello
 */
namespace Banquet\Core;


use Banquet\Actions\Notfound\Notfound;
use Banquet\Core\Log;

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


         $router = require_once DIR_APP.'/src/routes/web.php';

          $action = $router->dispatch();
 
        if (!is_string($action) || !class_exists($action)) {
            http_response_code(404);
            $action = Notfound::class;
        }

        Log::writeInfo('Action resolved: ' . $action);

        return $action;
    }
 
}

?>
