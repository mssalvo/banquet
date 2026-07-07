<?php

/**
 * Description of Factory
 *
 * @author Salvatore Mariniello
 */

namespace Banquet\Ms\Core;

/**
 * @property Container|null $container
 */

use Banquet\Actions\Error\ErrorRest;
use Banquet\Ms\Core\Log;
use Banquet\Actions\Error\Error;
use Banquet\Actions\Notfound\Notfound;
use Exception;
use InvalidArgumentException;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionParameter;

class Factory
{

    private $data = array();
    private static $factory;
    private $actions = array();
    private $master_template = NULL;
    private $response = NULL;
    private $container = NULL;
    public function __construct()
    {

        self::$factory = $this;
    }

    public static function getInstance()
    {

        if (!isset(self::$factory)) {
            self::$factory = new Factory();
        }
        return self::$factory;
    }

    public static function getResponse()
    {
        if (self::getInstance()->response == NULL) {
            self::getInstance()->response = new Response();
        }
        return self::getInstance()->response;
    }
    public static function getContainer()
    {
        if (self::getInstance()->container == NULL) {
            self::getInstance()->container = app();
        }
        return self::getInstance()->container;
    }

    public static function setContainer($container)
    {
        self::getInstance()->container = $container;
    }

    public static function setResponse($response)
    {
        self::getInstance()->response = $response;
    }

    public static function get($key)
    {
        return (isset(self::getInstance()->data[$key]) ? self::getInstance()->data[$key] : NULL);
    }

    public static function set($key, $value)
    {
        self::getInstance()->data[$key] = $value;
    }


    public static function getActions()
    {
        return self::getInstance()->actions;
    }

    public static function getAction($key)
    {
        return (isset(self::getInstance()->actions[$key]) ? self::getInstance()->actions[$key] : NULL);
    }

    public static function setAction($key, $value)
    {
        self::getInstance()->actions[$key] = $value;
    }

    public static function setActions($childs)
    {
        self::getInstance()->actions = $childs;
    }

    public static function setMasterTemplate($master)
    {
        self::getInstance()->master_template = $master;
    }

    public static function output($action = NULL, $children = NULL)
    {
        if ($children !== NULL) {
            self::setActions($children);
        }

        if ($action !== NULL) {
            $output = self::getInstance()->getOutput($action);
            if (self::getInstance()->master_template !== NULL) {
                self::getInstance()->data[self::shortName(self::getInstance()->master_template)] = $output;
            } else {
                self::getInstance()->data[self::shortName($action)] = self::getInstance()->getOutput($action);
            }
        }

        $children = self::getInstance()->getActions();
        foreach ($children as $child) {
            self::getInstance()->data[self::shortName($child)] = self::getInstance()->getOutput($child);
        }

        if (self::getInstance()->master_template == NULL) {
            $template = DIR_TEMPLATE_MASTER . self::shortName($action) . '-master' . TEMPLATE_EXT;
        } else {
            $template = DIR_TEMPLATE_MASTER . self::shortName(self::getInstance()->master_template) . '-master' . TEMPLATE_EXT;
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

            throw new Exception("Method:output:: Impossibile caricare il template " . $template . "!");
        }
    }


        private function getOutput($actionClass)
    {


        if (self::getInstance()->container == NULL) {
            self::getInstance()->container = app();
        }

        try {

            $action = self::getInstance()->container->get($actionClass);
            return $action->send();
        } catch (Exception $e) {
            Log::writeError("metod:getOutput:: " . $e->getMessage());

            if (strpos($actionClass, "Api") != 0) {
                $action = self::getInstance()->container->get(ErrorRest::class);
                $action->varAdd("error", json_encode(['esito' => 'error', 'message' => $e->getMessage()]));
                return $action->send();
            } else {
                $action = self::getInstance()->container->get(Error::class);
                $action->varAdd("error", $e->getMessage());
                return $action->send();
            }
        }
    }


    public static function execute($root_obj)
    {

     
        $root =$root_obj;
        //var_dump($root);
        $action = '';
        if (is_array($root) && $root['execute'] == "send") {
            $action = $root['action'];
            if (!is_string($action) || !class_exists($action)) {
                http_response_code(404);
                $action = Notfound::class;
            }

            Log::writeInfo('Action resolved: ' . $action);
            self::getInstance()->output($action);

        } elseif (is_array($root) && $root['execute'] != "send") {

            $action = $root['action'];

            if (self::getInstance()->container == NULL) {
                self::getInstance()->container = app();
            }

            try {
             
                $params = isset($root['params']) && is_array($root['params']) ? $root['params'] : [];
             
                $actionClass = self::getInstance()->container->get($action);

                $methodName = $root['execute'];

                
                if(!method_exists($actionClass, $methodName)){
                Log::writeError('execute::method:: '.$root['execute']. ' Metodo '. $methodName .' non trovato in ' . $action );
                self::getInstance()->getJsonResponse(404,['esito' => 'error', 'message' => "Metodo {$methodName} non trovato in " . $action ]);   
                }

                $method = new ReflectionMethod($actionClass, $methodName);

               

                if ($method->getNumberOfParameters() > 0) {
 
                   $args = self::getInstance()->buildArguments($method, $params);
                    $method->invokeArgs($actionClass, $args);

                } else {
                    $method->invoke($actionClass);
                }
            } catch (InvalidArgumentException $e) {
                 Log::writeError('execute::method:: '.$root['execute']. ' InvalidArgumentException:  ' . $e->getMessage());
                    self::getInstance()->getJsonResponse(500,['esito' => 'error', 'message' => $e->getMessage()]);
                 } catch (Exception $e) {
                 Log::writeError('execute::method:: '.$root['execute'].' Exception: ' . $e->getMessage());
                 self::getInstance()->getJsonResponse(500,['esito' => 'error', 'message' => $e->getMessage()]);
             }
        }


        return $action;
    }


    function buildArguments(
        ReflectionMethod $method,
        array $input
    ): array {
        $args = [];
 
        foreach ($method->getParameters() as $parameter) {

            $value = $input[$parameter->getName()] ?? null;
                 
          if ($parameter->isDefaultValueAvailable() && $value === null) {
                $args[$parameter->getName()] = $parameter->getDefaultValue();
                continue;
            } 
            try {

                $args[$parameter->getName()] = self::getInstance()->convertValue($value, $parameter);
                 
            } catch (InvalidArgumentException $e) {
                throw new InvalidArgumentException($e->getMessage());
            }
        }

        return $args;
    }


    function convertValue( mixed $value, ReflectionParameter $parameter):mixed
    {
        $type = $parameter->getType();

        // Nessun type hint => restituisco il valore così com'è
        if (!$type instanceof ReflectionNamedType) {
            Log::writeInfo("convertValue:: type" . $type);
                return $value;
        }

        $typeName = $type->getName();
        switch ($typeName) {
            case 'int':
                if (filter_var($value, FILTER_VALIDATE_INT) !== false) {
                    return (int)$value;
                }
                throw new InvalidArgumentException(
                    "Il parametro {$parameter->getName()} deve essere un int"
                );

            case 'string':
                return (string)$value;

            case 'float':
                if (is_numeric($value)) {
                    return (float)$value;
                }
                throw new InvalidArgumentException(
                    "Il parametro {$parameter->getName()} deve essere un float"
                );

            case 'bool':
                $boolValue = filter_var(
                    $value,
                    FILTER_VALIDATE_BOOLEAN,
                    FILTER_NULL_ON_FAILURE
                );
                if ($boolValue === null) {
                    throw new InvalidArgumentException(
                        "Il parametro {$parameter->getName()} deve essere un bool"
                    );
                }
                return $boolValue;

            default:
                return $value;
        }
    }

     protected function getJsonResponse(int $statusCode, $data = null)
    {
        if (ob_get_length()) {
            ob_clean();
        }

        header('Content-Type: application/json; charset=utf-8');
        http_response_code($statusCode);

        if ($data !== null) {
            echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
        exit;
    }

    public static function has($key)
    {
        return isset(self::getInstance()->data[$key]);
    }

    public function __destruct() {}

    public static function getTemplate($data, $template = NULL, $children = NULL, $master_template = NULL)
    {
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

            throw new Exception("Method:getTemplate:: Impossibile caricare il template " . $template . "!");
        }
    }

    private static function getName($template)
    {

        if (!self::strContains($template, TEMPLATE_EXT, true)) {
            $template .= TEMPLATE_EXT;
        }

        return $template;
    }

    private static function shortName($name)
    {
        if (!is_string($name)) {
            return '';
        }
        // namespaced class like Banquet\Actions\Header\Header
        if (strpos($name, "\\") !== false) {
            return substr($name, strrpos($name, "\\") + 1);
        }
        if (strpos($name, '/') !== false) {
            return substr($name, strrpos($name, '/') + 1);
        }
        // Fallback to basename for other paths
        return basename($name);
    }

    private static function strContains($haystack, $needle, $ignoreCase = false)
    {
        if ($ignoreCase) {
            $haystack = strtolower($haystack);
            $needle = strtolower($needle);
        }
        $needlePos = strpos($haystack, $needle);
        return ($needlePos === false ? false : ($needlePos + 1));
    }

    public static function ensureDir($dir)
    {
        if (!is_dir($dir)) {
            return mkdir($dir, 0777, true);
        }
        return false;
    }

    public static function writeToFile($path, $val)
    {
        $file_ = fopen($path, "a+");
        if ($file_) {
            fwrite($file_, $val . "\n");
            fclose($file_);
        }
    }

    public static function renameDir($name_dir, $newNamedir)
    {
        return rename($name_dir, $newNamedir);
    }
}
