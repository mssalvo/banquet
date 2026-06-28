<?php

/**
 * Description of header
 *
 * @author Utente
 */

namespace Banquet\Actions\Header;
use \Banquet\Core\SenderAction;

class Carousel extends SenderAction{

    public function send() {
        $this->setTemplateName("header/carousel");
        $this->varAdd('title', '');
      
        $language=$this->load("message_".$this->getLangName().".php");
        $this->varAdd('lang', $language);
       
        return $this->getTemplate();
    }     
}

?>
