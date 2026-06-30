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

    public function handle(array $args)
    {
        $table = $args[0] ?? null;
        $fullAction = $args[1] ?? null;
        if (!$table) {
            echo "❌ Specifica una tabella\n O digita il parametro all per indicare tutte\n make:map all";
            return;
        }
   
        $cmd = "";
        if ($table == "all") {
            echo "⚡ Generazione Entity, Dao, Crud, Model, Service per tutte le tabelle\n";
            $cmd = "php bin/generate";
            passthru($cmd);

            echo "✅ CRUD generato\n";

        }elseif($table != "all" && $fullAction!=null && $fullAction=="full-action" )  {
      echo "⚡ Generazione Entity, Dao, Crud, Model, Service per: $table\n";
            $cmd = "php bin/generate --table=$table --action=$table --with-view --with-route --with-api";
            passthru($cmd);

            echo "✅ CRUD generato\n";
        }
         else {
            echo "⚡ Generazione Entity, Dao, Crud, Model, Service per: $table\n";
            $cmd = "php bin/generate --table=$table";
            passthru($cmd);

            echo "✅ CRUD generato\n";
        }
    }
}