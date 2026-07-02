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
        $obj["id"]=$this->route('id')?$this->route('id'):"nessun parametro id";
        $obj["tipo"]="veicolo";
        $obj["marca"]="Audi";


         $this->jsonResponse(200,$obj);

        return $this->getTemplate('empty');
    }


}

?>
