<?php

/**
 * Description of Action
 *
 * @author Salvatore Mariniello
 */
namespace Banquet\Core;

class Load {

    private $load_ = array();
    private static $loadclass;

    public function __construct($path) {
        self::$loadclass = $this;

        $file = DIR_LOAD . $path;

        if (file_exists($file)) {
            $_ = array();

            require($file);
            $this->load_ = array_merge($this->load_, $_);
        }
        else {
            Log::writeError('Impossibile caricare il file  [ ' . DIR_LOAD . $path .' ]');
            trigger_error('Errore: Impossibile caricare il file  [ ' . DIR_LOAD . $path .' ]');
            exit();
        }
    }

    private static function istance($path) {

        if (!isset(self::$loadclass)) {
            self::$loadclass = new Load($path);
        }
        return self::$loadclass;
    }

        private static function newistance($path) {

        self::$loadclass = new Load($path);
        
         return self::$loadclass;
    }
    
    
      public static function getNewValue($path,$name) {
    if(isset(self::newistance($path)->load_[$name])){
        $load=self::istance($path)->load_[$name];
        if ($load == NULL || $load == "") {
            $load = ACTION_PAGE_404;
         Log::writeError('Impossibile trovare il nome proprieta  nel file ' . $path . '  [ ' . $name. '! ]');  
         trigger_error('Errore: Impossibile trovare il nome proprieta  nel file ' . $path . '  [ ' . $name. '! ]');    
        }
        
        }else{
             $load = ACTION_PAGE_404;
        }
        return $load;
    }
    
    
    public static function getValue($path,$name) {
    if(isset(self::istance($path)->load_[$name])){
        $load=self::istance($path)->load_[$name];
        if ($load == NULL || $load == "") {
            $load = ACTION_PAGE_404;
         Log::writeError('Impossibile trovare il nome proprieta  nel file ' . $path . '  [ ' . $name. '! ]');      
         trigger_error('Errore: Impossibile trovare il nome  proprieta  nel file ' . $path . '  [ ' . $name. '! ]');    
        }
        
        }else{
             $load = ACTION_PAGE_404;
        }
        return $load;
    }
    
    
    public static function getLoad($path) {
    if(isset(self::newistance($path)->load_)){
        $load=self::istance($path)->load_;
        if ($load == NULL) {
         Log::writeError('Impossibile trovare il nome proprieta  nel file ' . $path .  '!');     
         trigger_error('Errore: Impossibile trovare il nome proprieta  nel file ' . $path . '!');    
        }
        
        } 
        return $load;
    }

}

?>
