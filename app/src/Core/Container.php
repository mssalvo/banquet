<?php
namespace Banquet\Core;

class Container
{
    protected $instances = [];
    protected $bindings = [];

    /**
     * Registra un binding
     */
    public function set($key, $resolver)
    {
        $this->bindings[$key] = $resolver;
    }

    /**
     * Risolve una classe
     */
    public function get($class)
    {
        // se già istanziata → singleton
        if (isset($this->instances[$class])) {
            return $this->instances[$class];
        }

        // binding custom ( PDO)
        if (isset($this->bindings[$class])) {

            $resolver = $this->bindings[$class];

            // se è una closure → eseguila
            $object = is_callable($resolver)
                ? $resolver()
                : $resolver;
            Log::writeInfo("class name::".$class);
            return $this->instances[$class] = $object;
        }

        // reflection normale
        $reflection = new \ReflectionClass($class);

        $constructor = $reflection->getConstructor();

        if (!$constructor) {
            return $this->instances[$class] = new $class;
        }

        // dipendenze
        $params = $constructor->getParameters();
        $dependencies = [];

        foreach ($params as $param) {

            $type = $param->getType();

            if ($type && !$type->isBuiltin()) {
                Log::writeInfo("Type name::".$type->getName());
                $dependencies[] = $this->get($type->getName());

            } elseif ($param->isDefaultValueAvailable()) {
                    $dependencies[] = $param->getDefaultValue();
   
               } else {
                    throw new \Exception(
                        "Impossibile risolvere '{$param->getName()}' in classe {$class}"
                    );
                }
        }

        return $this->instances[$class] = $reflection->newInstanceArgs($dependencies);
    }
}
