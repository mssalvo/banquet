<?php

/**
 * Description of start
 *
 * @author Utente
 */


namespace Banquet\Actions;
use Banquet\Core\SenderAction;

class Home extends SenderAction{
   	 

    public function __construct() {
   
      }
 
        public function send() {
            
        $this->setTemplateName('pages/home');
        $this->setTemplateChildren(array(\Banquet\Actions\Header\Header::class,\Banquet\Actions\Header\Carousel::class,\Banquet\Actions\Menu\Menu::class,\Banquet\Actions\Footer\Footer::class));
       
        $language=$this->load("message_". $this->getLangName().".php");
        $this->varAdd('lang', $language);
         
        $this->varAdd('titolo',$language['titolo']);
        $this->varAdd('btn_chiudi',$language['btn_chiudi']);
        $this->varAdd("login", $language['btn_chiudi']);
        $this->varAdd('utente', "home");       
            
        
        return $this->getTemplate('default');
        
    }
    
    
}

?>
