<?php
namespace Banquet\Core;

class Router
{
    private $routes = [];

    /**
     * Registra una rotta GET
     */
    public function get($pattern, $action)
    {
        return $this->add('GET', $pattern, $action);
    }

    /**
     * Registra una rotta POST
     */
    public function post($pattern, $action)
    {
        return $this->add('POST', $pattern, $action);
    }

    /**
     * Registra una rotta PUT
     */
    public function put($pattern, $action)
    {
        return $this->add('PUT', $pattern, $action);
    }

    /**
     * Registra una rotta DELETE
     */
    public function delete($pattern, $action)
    {
        return $this->add('DELETE', $pattern, $action);
    }
    /**
     * Registra una rotta OPTIONS
     */
    public function options($pattern, $action)
    {
        return $this->add('OPTIONS', $pattern, $action);
    }
    /**
     * Registra una rotta HEAD
     */
    public function head($pattern, $action)
    {
        return $this->add('HEAD', $pattern, $action);
    }

    /**
     * Registra una rotta PATCH
     */
    public function patch($pattern, $action)
    {
        return $this->add('PATCH', $pattern, $action);
    }

    /**
     * Aggiunge una rotta
     */
    private function add($method, $pattern, $action)
    {
        $route = [
            'method' => $method,
            'pattern' => $pattern,
            'action' => $action,
            'execute' => 'send',
            'middleware' => []
        ];

        $this->routes[] = &$route;

        // ritorna oggetto fluente per middleware
        return new class ($route) {
            private $route;

            public function __construct(&$route)
            {
                $this->route = &$route;
            }

            public function middleware($name)
            {
                $this->route['middleware'][] = $name;
                return $this;
            }
              public function rest($name)
            {
                $this->route['execute'] = $name;
                return $this;
            }
        };
    }

    /**
     * Esegue il routing
     */
    public function dispatch()
    {
        $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
        $requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        $url = parse_url($requestUri, PHP_URL_PATH);
        $method = $requestMethod;

        foreach ($this->routes as $route) {

            if ($method !== $route['method']) {
                continue;
            }

            $paramNames = [];
            $regex = $this->convertPatternToRegex($route['pattern'], $paramNames);

            if (preg_match($regex, $url, $matches)) {

                array_shift($matches);

                // Parametri nominati
                $params = [];
                foreach ($paramNames as $index => $name) {
                    $params[$name] = $matches[$index] ?? null;
                }

                // Salva parametri globali
                $_REQUEST['_route_params'] = $params;

                // Middleware
                foreach ($route['middleware'] as $mw) {
                    $this->runMiddleware($mw);
                }

                if (isset($route['action']) && isset($route['execute']) && $route['execute'] != null) {
                    
                  return $this->runApi($route, $params);
                  
                }

                return $route['action'];
            }
        }

        return null;
    }

    /**
     * Converte pattern in regex (supporta {id} e {id:\d+})
     */
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

    /**
     * Gestione middleware base
     */
    private function runMiddleware($name)
    {
        switch ($name) {

            case 'auth':
                if (!isset($_SESSION['user_id'])) {
                    header('Location: /login');
                    exit;
                }
                break;

            case 'guest':
                if (isset($_SESSION['user_id'])) {
                    header('Location: /');
                    exit;
                }
                break;

            // puoi aggiungere altri middleware qui
            default:
                break;
        }
    }

    private function runApi($route, $params=[])
    {
         $ction = $route['action'];
         $execute = $route['execute'];
        
        if ($execute != null && class_exists($ction)) {
            $controller = resolve($ction);
            if (method_exists($controller, $execute)) { 
                call_user_func_array([$controller, $execute], $params);
            }
        }

        return $ction;
    }
}