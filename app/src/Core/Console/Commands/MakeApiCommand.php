<?php

namespace Banquet\Core\Console\Commands;

use Banquet\Core\Console\Command;

class MakeApiCommand extends Command
{
    protected $signature = 'make:api';
    protected $description = 'Genera API REST';

    public function handle(array $args)
    {
        $table = $args[0] ?? null;

        if (!$table) {
            echo "❌ Specifica una tabella\n";
            return;
        }
    if($this->checkEsixt($table)) {
    echo "✅ File Esiste\n";    
    passthru("php bin/generate --action-api=$table");
    } else {
         echo "❌ File non esistono\n";
        passthru("php bin/generate --table=$table --action-api=$table");
    }

    }

private function toPascalCase(string $name)
{
    $name = str_replace(" ","", ucwords($name));
    $name = trim($name);
    $name = str_replace(['-', '/'], '_', $name);
    $name = preg_replace('/[^A-Za-z0-9_]+/', ' ', $name);
    $name = preg_replace('/_+/', '_', $name);
    $name = ucwords(str_replace('_', ' ', strtolower($name)));
    $name = str_replace(' ', '', $name);

    return $name !== '' ? ucfirst($name) : 'Class';
}


private function checkEsixt(string $name){
$BASE_DIR = dirname(DIR_APP);
$SRC_DIR  = $BASE_DIR . '/app/src';

$ENTITY_DIR  = $SRC_DIR . '/Entity';
$DAO_DIR     = $SRC_DIR . '/Dao';
$MODEL_DIR   = $SRC_DIR . '/Model';
$SERVICE_DIR = $SRC_DIR . '/Service';

$classe = $this->toPascalCase($name);

 
$configLoaded = false;
$configFiles = [
    $ENTITY_DIR . '/'.$classe.'.php',
    $SERVICE_DIR . '/'.$classe.'Service.php',
    $DAO_DIR . '/'.$classe.'Dao.php',
    $MODEL_DIR . '/'.$classe.'Model.php'
];

 

foreach ($configFiles as $f) {
   
if (file_exists($f)) {
        $configLoaded = true;
        
    }
}

return $configLoaded;

}



}