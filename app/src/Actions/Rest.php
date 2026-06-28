<?php


/**
 * Description of start
 *
 * @author Utente
 */

namespace Banquet\Actions;
use \Banquet\Core\SenderAction;

class Rest extends SenderAction
{

    public function send()
    {

        $this->setTemplateName("pages/json");

        $obj= array();
        $obj["id"]=$this->route('id');;
        $obj["tipo"]="veicolo";
        $obj["marca"]="Audi";



        $this->varAdd("json",json_encode($obj));

        $this->getResponse()->addHeader('Content-Type: application/json');

        return $this->getTemplate('empty');
    }


}

?>
