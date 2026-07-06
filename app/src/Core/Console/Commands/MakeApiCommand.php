<?php

/** This file is part of Banquet.
 * (c) Salvatore Mariniello <salvo.mariniello@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Banquet\Core\Console\Commands;

use Banquet\Core\Console\Command;

class MakeApiCommand extends Command
{
    protected $signature = 'make:api';
    protected $description = 'Genera API REST';

    public function handle(array $args,array $arra_associativo)
    {
            $dsn  = '';
            $user = '';
            $pass = '';  
        $hasDns  = isset($arra_associativo['dsn']);
        if ($hasDns) {
            $dsn  = $arra_associativo['dsn'] ?? '';
            $user = $arra_associativo['user'] ?? '';
            $pass = $arra_associativo['pass'] ?? '';    
        }

          $hasSwagger  = isset($arra_associativo['with-swagger']);
                 $stringSwagger='';
                if ($hasSwagger) {
                $stringSwagger=' --with-swagger';
                }
                
         $stringPrefix='';
         $hasPrefix  = isset($arra_associativo['prefix']);

        if ($hasPrefix) {
         $stringPrefix=' --prefix='.$arra_associativo['prefix'] ?? '';
        }

        $service =  null;
        $hasActionService = isset($arra_associativo['action-service']);
        if ($hasActionService) {
         $service = $arra_associativo['action-service'] ?? '';
        $stringPrefix=$stringPrefix.' --action-service='.$service;
        }

        $table = $args[0] ?? null;

        if (!$table) {
            echo "❌ Specifica una tabella\n";
            return;
        }

       $serviceClass = ($service ?? $table);
       $serviceClass = preg_replace('/Service$/', '', $serviceClass);

    if(!$hasActionService &&$this->checkExists($table)) {
    echo "✅ File Esiste\n";    
    passthru("php bin/generate --action-api=$table $stringSwagger");
    } else {
         echo "❌ File non esistono\n";
       if($hasDns) {
         passthru("php bin/generate --dsn=$dsn --user=$user --pass=$pass --table=$serviceClass $stringPrefix --action-api=$table $stringSwagger");
       } else {
         passthru("php bin/generate --table=$serviceClass $stringPrefix --action-api=$table $stringSwagger");
       }
    }

    }

private function toPascalCase(string $name)
{
    $name = str_replace(" ","", ucwords($name));
    $name = trim($name);
    $name = str_replace(['-', '/'], '_', $name);
    $name = preg_replace('/[^A-Za-z0-9_]+/', ' ', $name);
    $name = preg_replace('/_+/', '_', $name);
    $name = ucwords(str_replace('_', ' ',  $name));
    $name = str_replace(' ', '', $name);

    return $name !== '' ? ucfirst($name) : 'Class';
}


private function checkExists(string $name){
$BASE_DIR = dirname(DIR_APP);
$SRC_DIR  = $BASE_DIR . '/app/src';

$ENTITY_DIR  = $SRC_DIR . '/Entity';
$DAO_DIR     = $SRC_DIR . '/Dao';
$MODEL_DIR   = $SRC_DIR . '/Model';
$SERVICE_DIR = $SRC_DIR . '/Service';

$classe = $this->toPascalCase($name);

 
$configLoaded = false;
$controlFiles= [];
 
$configFiles = [
    $ENTITY_DIR . '/'.$classe.'.php',
    $DAO_DIR . '/'.$classe.'Dao.php',
    $MODEL_DIR . '/'.$classe.'Model.php',
    $SERVICE_DIR . '/'.$classe.'Service.php'
];

 

foreach ($configFiles as $f) {
   
if (file_exists($f)) {
    
    $controlFiles[]=true;
    
    }

}

$configLoaded = count($controlFiles) === count($configFiles);


return $configLoaded;



}

}