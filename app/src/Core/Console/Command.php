<?php

/** This file is part of Banquet.
 * (c) Salvatore Mariniello <salvo.mariniello@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Banquet\Core\Console;

abstract class Command
{
    protected $signature = '';
    protected $description = '';

    abstract public function handle(array $args,array $args_list);

    public function getSignature()
    {
        return $this->signature;
    }

    public function getDescription()
    {
        return $this->description;
    }
}