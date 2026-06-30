<?php

namespace Banquet\Actions;

/**
 * Generated 30/06/2026 10:34:30
 * Auto-generated tools banquet (https://github.com/mssalvo/banquet)
 * @copyright MIT
 * Action  Corsi
 */

use Banquet\Core\SenderAction;
use Banquet\Service\CorsiService;

class Corsi extends SenderAction{
    private $service;
    public function __construct(CorsiService $service) {
        $this->service=$service;
    }

    public function send() {
         $this->setTemplateName("pages/corsi");

         $this->varAdd("corsi", $this->service->getAllCorsi());

        return $this->getTemplate("default");
    }
}
