<?php

namespace Banquet\Core\Console\Commands;

use Banquet\Core\Console\Command;

class MakeMapCommand extends Command
{
    protected $signature = 'make:map';
    protected $description = 'Genera Entity, Dao con Crud completa, Model, Service, per una tabella';

    public function handle(array $args)
    {
        $table = $args[0] ?? null;

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

        } else {
            echo "⚡ Generazione Entity, Dao, Crud, Model, Service per: $table\n";
            $cmd = "php bin/generate --table=$table";
            passthru($cmd);

            echo "✅ CRUD generato\n";
        }
    }
}