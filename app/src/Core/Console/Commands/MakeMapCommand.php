<?php

/** This file is part of Banquet.
 * (c) Salvatore Mariniello <salvo.mariniello@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Banquet\Core\Console\Commands;

use Banquet\Core\Console\Command;

class MakeMapCommand extends Command
{
    protected $signature = 'make:map';
    protected $description = 'Genera Entity, Dao con Crud completa, Model, Service, per una tabella';

    public function handle(array $args,array $arra_associativo)
    {
            $dsn  ='';
            $user = '';
            $pass = '';  
        $hasDns  = isset($arra_associativo['dsn']);
        if ($hasDns) {
            $dsn  = $arra_associativo['dsn'] ?? '';
            $user = $arra_associativo['user'] ?? '';
            $pass = $arra_associativo['pass'] ?? '';    
        }
        $hasPrefix  = isset($arra_associativo['prefix']);
        $stringPrefix='';
        if ($hasPrefix) {
         $stringPrefix=' --prefix='.$arra_associativo['prefix'] ?? '';
        }
        
        $hasSwagger  = isset($arra_associativo['with-swagger']);
                 $stringSwagger='';
                if ($hasSwagger) {
                $stringSwagger=' --with-swagger';
                }
        
        $hasNotView  = isset($arra_associativo['not-view']);
        $stringParam='--with-view --with-route';
        if ($hasNotView) {
        $stringParam = str_replace('--with-view', '', $stringParam);    
        }
        $hasNotRoute = isset($arra_associativo['not-route']);
        if ($hasNotRoute) {
         $stringParam = str_replace('--with-route', '', $stringParam);
        }
         
        $table = $args[0] ?? null;
        $fullAction = $args[1] ?? null;
        if (!$table) {
            echo "❌ Specifica una tabella\n O digita il parametro all per indicare tutte\n make:map all";
            return;
        }
   
        $cmd = "";
        if ($table == "all") {
            echo "⚡ Generazione Entity, Dao, Crud, Model, Service per tutte le tabelle\n";
             $cmd = "";  
            if($hasDns){ 
             $cmd = "php bin/generate --dsn=$dsn --user=$user --pass=$pass $stringPrefix"; 
            } else {
             $cmd = "php bin/generate";
            }
            passthru($cmd);

            echo "✅ CRUD generato\n";

        } elseif ($table != "all" && $fullAction!=null && $fullAction=="full-action" )  {
            echo "⚡ Generazione Entity, Dao, Crud, Model, Service per: $table\n";
            $cmd = "";
            if($hasDns){ 
             $cmd = "php bin/generate --dsn=$dsn --user=$user --pass=$pass --table=$table --action=$table $stringPrefix $stringParam --with-api $stringSwagger"; 
            } else {
             $cmd = "php bin/generate --table=$table --action=$table $stringPrefix $stringParam --with-api $stringSwagger"; 
            }
            passthru($cmd);

            echo "✅ CRUD generato\n";
          }
         else {
            echo "⚡ Generazione Entity, Dao, Crud, Model, Service per: $table\n";
            $cmd = "";
            if($hasDns){ 
            $cmd = "php bin/generate --dsn=$dsn --user=$user --pass=$pass $stringPrefix --table=$table";
            } else {
             $cmd = "php bin/generate $stringPrefix --table=$table";    
            }
            passthru($cmd);

            echo "✅ CRUD generato\n";
        }
    }
}