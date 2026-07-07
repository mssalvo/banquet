<?php

/** This file is part of Banquet.
 * (c) Salvatore Mariniello <salvo.mariniello@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Banquet\Ms\Core\Console\Commands;

use Banquet\Ms\Core\Console\Command;

class MakeActionCommand extends Command
{
    protected $signature = 'make:action';
    protected $description = 'Genera Action MVC';

    public function handle(array $args,array $arra_associativo)
    {
 
        $hasNotView  = isset($arra_associativo['not-view']);
        $stringParam="--with-view --with-route";
        if ($hasNotView) {
        $stringParam= str_replace('--with-view', '', $stringParam);    
        }
         $hasNotRoute  = isset($arra_associativo['not-route']);
        if ($hasNotRoute) {
         $stringParam= str_replace('--with-route', '', $stringParam);
        }
        $hasApi = isset($arra_associativo['with-api']);
        if ($hasApi) {
         $stringParam= $stringParam . ' --with-api';
        }
         $hasSwagger  = isset($arra_associativo['with-swagger']);
                if ($hasSwagger) {
                 $stringParam= $stringParam . ' --with-swagger';
                }

        $service =  null;
        $hasActionService = isset($arra_associativo['action-service']);
        if ($hasActionService) {
         $service = $arra_associativo['action-service'] ?? null;
        }

        $hasTable = isset($arra_associativo['table']);
       if ($hasTable) {
         $stringParam= $stringParam . ' --table='.$arra_associativo['table'] ?? '';
        }
        

        $action = $args[0] ?? null;
        

    


        if (!$action) {
            echo "❌ Specifica una tabella\n";
            return;
        }
        if ($service) {
        $service= preg_replace('/Service$/', '', $service); 
        }

        if ($service == null && $this->checkExist($action)) {
            echo "✅ Procedo alla creazione della singola action: $action\n";
            passthru("php bin/generate --action=$action --with-service $stringParam");
        } elseif ($service != null && $this->checkExist($service)) {
            echo "✅ Procedo alla creazione action: $action con service1\n";
            passthru("php bin/generate --action=$action --action-service=$service --with-service $stringParam");
        } elseif ($service != null && $hasTable) {
            echo "✅ Procedo alla creazione action: $action con service2\n";
            passthru("php bin/generate --action=$action --action-service=$service --with-service $stringParam");
        } 
        else {
            echo "✅ Procedo alla creazione action: $action\n";
            passthru("php bin/generate --action=$action $stringParam");
        }

    }

    private function toPascalCase(string $name)
    {
        $name = str_replace(" ", "", ucwords($name));
        $name = trim($name);
        $name = str_replace(['-', '/'], '_', $name);
        $name = preg_replace('/[^A-Za-z0-9_]+/', ' ', $name);
        $name = preg_replace('/_+/', '_', $name);
        $name = ucwords(str_replace('_', ' ', $name));
        $name = str_replace(' ', '', $name);

        return $name !== '' ? ucfirst($name) : 'Class';
    }


    private function checkExist(string $name)
    {
        $BASE_DIR = dirname(DIR_APP);
        $SRC_DIR = $BASE_DIR . '/app/src';

        $SERVICE_DIR = $SRC_DIR . '/Service';

        $classe = $this->toPascalCase($name);


        $configLoaded = false;
        $configFiles = [
            $SERVICE_DIR . '/' . $classe . 'Service.php'
        ];



        if (file_exists($configFiles[0])) {
            $configLoaded = true;

        }


        return $configLoaded;

    }



}