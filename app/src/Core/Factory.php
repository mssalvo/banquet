<?php

/**
 * Description of Factory
 *
 * @author Salvatore Mariniello
 */
namespace Banquet\Core;

/**
 * @property Container|null $container
 */

use Banquet\Actions\Error\ErrorRest;
use Banquet\Actions\Notfound\Notfound;
use Banquet\Core\Log;
use Banquet\Actions\Error\Error;
use Exception;
 

class Factory {

    private $data = array();
    private static $factory;
    private $actions = array();
    private $master_template = NULL;
    private $response = NULL;
    private static $MODELCLS = "Model";
    private $container = NULL;
    public function __construct() {

        self::$factory = $this;

    }

    public static function getInstance() {

        if (!isset(self::$factory)) {
            self::$factory = new Factory();
        }
        return self::$factory;
    }

    public static function getResponse() {
        if (self::getInstance()->response == NULL) {
            self::getInstance()->response = new Response();
        }
        return self::getInstance()->response;
    }
    public static function getContainer() {
        if (self::getInstance()->container == NULL) {
            self::getInstance()->container = app();
        }
        return self::getInstance()->container;
    }

    public static function setContainer($container) {
        self::getInstance()->container = $container;
    }

    public static function setResponse($response) {
        self::getInstance()->response = $response;
    }

    public static function get($key) {
        return (isset(self::getInstance()->data[$key]) ? self::getInstance()->data[$key] : NULL);
    }

    public static function set($key, $value) {
        self::getInstance()->data[$key] = $value;
    }


    public static function getActions() {
        return self::getInstance()->actions;
    }

    public static function getAction($key) {
        return (isset(self::getInstance()->actions[$key]) ? self::getInstance()->actions[$key] : NULL);
    }

    public static function setAction($key, $value) {
        self::getInstance()->actions[$key] = $value;
    }

    public static function setActions($childs) {
        self::getInstance()->actions = $childs;
    }

    public static function setMasterTemplate($master) {
        self::getInstance()->master_template = $master;
    }

    public static function output($action = NULL, $children = NULL) {
        if ($children !== NULL) {
            self::setActions($children);
           
        } 
         
        if ($action !== NULL) {
              Log::writeInfo("Factory Method>output action-> ".$action);
            $output = self::getInstance()->getOutput($action);
            if (self::getInstance()->master_template !== NULL) {
                self::getInstance()->data[basename(self::getInstance()->master_template)] = $output;
            } else {
                self::getInstance()->data[basename($action)] = self::getInstance()->getOutput($action);
            }
        }

        foreach (self::getInstance()->getActions() as $child) {
            self::getInstance()->data[basename($child)] = self::getInstance()->getOutput($child);
        }

        if (self::getInstance()->master_template == NULL) {
            $template = DIR_TEMPLATE_MASTER . basename($action) . '-master' . TEMPLATE_EXT;
        } else {
            $template = DIR_TEMPLATE_MASTER . basename(self::getInstance()->master_template) . '-master' . TEMPLATE_EXT;
        }
        if (file_exists($template)) {
            extract(self::getInstance()->data);

            ob_start();

            require($template);

            $output = ob_get_contents();

            ob_end_clean();

            self::getResponse()->setOutput($output);
            self::getResponse()->output();
           
        } else {
             Log::writeError('Method:output:: Impossibile caricare il template ' . $template . '!'); 
           
            throw new Exception("Method:output:: Impossibile caricare il template " .$template ."!");
          
        }
    }


    private function getOutput($actionClass) {


        if (self::getInstance()->container == NULL) {
            self::getInstance()->container = app();
        }
 
        try {
            
            $action = self::getInstance()->container->get($actionClass);
            return $action->send();

        } catch (Exception $e) {
            Log::writeError("metod:getOutput:: ". $e->getMessage());
   
            if (strpos($actionClass,"Api")!=0) {
            $action = self::getInstance()->container->get(ErrorRest::class);
            $action->varAdd("error",json_encode(['esito'=>'error','message'=>$e->getMessage()]));
            return $action->send();
            }else{
            $action = self::getInstance()->container->get(Error::class);
            $action->varAdd("error",$e->getMessage());
            return $action->send();   
            }
    }
    }

    public static function has($key) {
        return isset(self::getInstance()->data[$key]);
    }

    public function __destruct() {
        
         Log::writeInfo("Factory Method>__destruct_");
    }

    public static function getTemplate($data, $template = NULL, $children = NULL, $master_template = NULL) {
        if ($children !== NULL) {
            self::setActions($children);

        }
        if ($template == NULL) {
            Log::writeInfo("Factory Method>getTemplate template-> NULL");
            return '';
        }

        $template = self::getName($template);

        if ($master_template !== NULL) {
            self::getInstance()->master_template = $master_template;

        }
        
        if (file_exists(DIR_TEMPLATE . $template)) {

            extract($data);

            ob_start();

            require(DIR_TEMPLATE . $template);

            $output = ob_get_contents();

            ob_end_clean();

            return $output;
        } else {
             Log::writeError('Impossibile caricare il template ' . DIR_TEMPLATE . $template . '!'); 
          
             throw new Exception("Method:getTemplate:: Impossibile caricare il template " .$template ."!");
           
        }
    }

    private static function getName($template) {

        if (!self::strContains($template, TEMPLATE_EXT, true)) {
            $template .=TEMPLATE_EXT;
        }

        return $template;
    }

    private static function strContains($haystack, $needle, $ignoreCase = false) {
        if ($ignoreCase) {
            $haystack = strtolower($haystack);
            $needle = strtolower($needle);
        }
        $needlePos = strpos($haystack, $needle);
        return ($needlePos === false ? false : ($needlePos + 1));
    }

    public static function ensureDir($dir) {
        if (!is_dir($dir)) {
            return mkdir($dir, 0777, true);
        }
        return false;
    }

    public static function writeToFile($path, $val) {
        $file_ = fopen($path, "a+");
        if ($file_) {
            fwrite($file_, $val . "\n");
            fclose($file_);
        }
    }

    public static function renameDir($name_dir, $newNamedir) {
        return rename($name_dir, $newNamedir);
    }

}

?>