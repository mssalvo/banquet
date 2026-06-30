<?php

/**
 * Generated 30/06/2026 10:34:30
 * Auto-generated tools banquet (https://github.com/mssalvo/banquet)
 * @copyright MIT
 * Api-Rest  Corsi
 */

namespace Banquet\Actions\Api;
use Banquet\Core\SenderAction;
use Banquet\Service\CorsiService;
use Banquet\Entity\Corsi;

class CorsiRest extends SenderAction
{
    private $service;
    public function __construct(CorsiService $service) {
        $this->service=$service;
    }
    public function send()
    {
        $this->setTemplateName("pages/json");


        switch ($this->getRequestMethod()) {

            case 'GET':
                $data = $this->route('id')
                    ? $this->service->getCorsiById($this->route('id'))
                    : $this->service->getAllCorsi();
                      $this->varAdd("json", json_encode($data));
                break;

                case 'POST':
                $body = json_decode(file_get_contents('php://input'), true);
                $entity = new Corsi($body);
                $this->service->salva($entity);
                $data = ['success' => true, 'id' => $this->service->getLastInsertId()];
                $this->varAdd("json", json_encode($data));
                break;

                case 'PUT':
                $body = json_decode(file_get_contents('php://input'), true);
                $entity = new Corsi($body);
                $this->service->update($entity);
                $data = ['success' => true, 'id' => $entity->id];
                $this->varAdd("json", json_encode($data));
                break;

                case 'DELETE':
                $data = array();
                $data['id']= $this->route('id');
                $this->service->delete(new Corsi($data));
                $row = $this->service->getCorsiById($this->route('id'));
                $dataJson =$row? ['success' => false, 'id' => $this->route('id')] : ['success'=> true,'id'=> $this->route('id')];
                $this->varAdd("json", json_encode($dataJson));
                break;

                default:
                $data = ['error' => 'Method not allowed', 'method'=>$this->getRequestMethod()] ;
                   $this->varAdd("json", json_encode($data));
        }


            $this->getResponse()->addHeader('Content-Type: application/json');

            return $this->getTemplate('empty');
    }
}
