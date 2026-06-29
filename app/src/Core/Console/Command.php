<?php

namespace Banquet\Core\Console;

abstract class Command
{
    protected $signature = '';
    protected $description = '';

    abstract public function handle(array $args);

    public function getSignature()
    {
        return $this->signature;
    }

    public function getDescription()
    {
        return $this->description;
    }
}