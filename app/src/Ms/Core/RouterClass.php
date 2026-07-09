<?php
 
namespace Banquet\Ms\Core;

use Banquet\Actions\Notfound\Notfound;
use ReflectionClass;
use Banquet\Ms\Core\Attribute\Route;
use Banquet\Ms\Core\Factory;

class RouterClass {private string $cacheFile;
    private bool $debug;
    private array $rotte = [];

    public function __construct(string $cacheFile, bool $debug = false) {
        $this->cacheFile = $cacheFile;
        $this->debug = $debug;
        $this->caricaRotte();
    }

    private function caricaRotte(): void {
        if (!$this->debug && file_exists($this->cacheFile)) {
            $this->rotte = require $this->cacheFile;
            return;
        }

        $this->rotte = $this->scansionaController(DIR_APPLICATION . 'Actions');
        $codiceCache = "<?php\nreturn " . var_export($this->rotte, true) . ";";
        file_put_contents($this->cacheFile, $codiceCache);
    }

    private function scansionaController(string $cartella): array {
    $mappa = [];
    $directory = new \RecursiveDirectoryIterator($cartella);
    $iterator = new \RecursiveIteratorIterator($directory);
    $regexIterator = new \RegexIterator($iterator, '/^.+\.php$/i');

    foreach ($regexIterator as $file) {
        $className = $this->estraiClasseDaFile($file->getPathname());
        if (!$className || !class_exists($className)) continue;

        $reflectionClass = new ReflectionClass($className);
        foreach ($reflectionClass->getMethods() as $metodo) {
            // Questo recupera TUTTI gli attributi #[Route] applicati al metodo
            $attributi = $metodo->getAttributes(Route::class);
            
            foreach ($attributi as $attrRef) {
                /** @var Route $route */
                $route = $attrRef->newInstance();
                
                // Converte il path in Regex (es. '/utenti/{id}' -> '#^/utenti/([^/]+)$#')
                //$regexRotta = '#^' . preg_replace('/\{[a-zA-Z0-9_]+\}/', '([^/]+)', $route->path) . '$#';
                
                
                $mappa[$route->method][$route->path] = [
                    'controller' => $className,
                    'metodo' => $metodo->getName()
                ];
            }
        }
    }
    return $mappa;
}

    public function resolve() {
       
    
    //  richiesta HTTP  
        $metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $path = $_SERVER['REQUEST_URI'] ?? '/';
    
       
    
    // Se non ci sono rotte registrate per questo metodo HTTP
        if (!isset($this->rotte[$metodo])) {
                $arrayObj=[];
                $arrayObj['action']=Notfound::class;
                $arrayObj['execute']='send'; 
                $arrayObj['params']= [];    
        return Factory::execute($arrayObj);
        }


         $url = parse_url($path, PHP_URL_PATH);
         

        // Ciclo i path registrati in cache per questo metodo HTTP
        
        foreach ($this->rotte[$metodo] as $pathRoot => $info) {
            
            $paramNames = [];
            $regex = $this->convertPatternToRegex($pathRoot, $paramNames);
    
       
        if (preg_match($regex, $url, $matches)) {
                // Rimuovo il primo elemento
                array_shift($matches); 

               // Parametri nominati
                $params = [];
                foreach ($paramNames as $index => $name) {
                    $params[$name] = $matches[$index] ?? null;
                }
                // Salvo parametri globali
                $_REQUEST['_route_params'] = $params;
                $_REQUEST['_action_route'] = explode('/', $url)[1];
         
                $arrayObj=[];
                $arrayObj['action']=$info['controller'];
                $arrayObj['execute']=$info['metodo']; 
                $arrayObj['params']=$params;    
                return Factory::execute($arrayObj);
        
        }
      }
    
                $arrayObj=[];
                $arrayObj['action']=Notfound::class;
                $arrayObj['execute']='send'; 
                $arrayObj['params']= [];    
        return Factory::execute($arrayObj);
           
    }
    
    
    private function estraiClasseDaFile(string $filePath): ?string { 
    $contenuto = file_get_contents($filePath);
    $tokens = token_get_all($contenuto);
    $namespace = '';
    $class = '';
    $count = count($tokens);

    for ($i = 0; $i < $count; $i++) {
        if ($tokens[$i][0] === T_NAMESPACE) {
            for ($j = $i + 1; $j < $count; $j++) {
                if ($tokens[$j] === ';') {
                    break;
                }
                if (is_array($tokens[$j])) {
                    $namespace .= $tokens[$j][1];
                }
            }
            $namespace = trim($namespace);
        }

        if ($tokens[$i][0] === T_CLASS) {
            for ($j = $i + 1; $j < $count; $j++) {
                if ($tokens[$j] === '{' || is_array($tokens[$j]) && $tokens[$j][0] === T_WHITESPACE && $tokens[$j+1] === '{') {
                    break;
                }
                if (is_array($tokens[$j]) && $tokens[$j][0] === T_STRING) {
                    $class = $tokens[$j][1];
                    break;
                }
            }
            if ($class) {
                return $namespace ? $namespace . '\\' . $class : $class;
            }
        }
    }
    return null;

    }
    private function convertPatternToRegex($pattern, &$paramNames)
    {
        $paramNames = [];

        $regex = preg_replace_callback('/\{(\w+)(?::([^}]+))?\}/', function ($matches) use (&$paramNames) {

            $paramNames[] = $matches[1];

            // se c'è regex personalizzata
            if (isset($matches[2])) {
                return '(' . $matches[2] . ')';
            }

            return '([^/]+)';
        }, $pattern);

        return '#^' . $regex . '$#';
    }
}
