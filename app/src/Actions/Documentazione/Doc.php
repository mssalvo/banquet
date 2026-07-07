<?php


/**
 * Description of start
 *
 * @author Utente
 */
namespace Banquet\Actions\Documentazione;
use Banquet\Ms\Core\Attribute\Route;
use Banquet\Ms\Core\SenderAction;
use Banquet\Actions\Header\Header;
use Banquet\Actions\Menu\Menu;  
use Banquet\Actions\Footer\Footer;

class Doc extends SenderAction
{

   #[Route(FOLDER_HOME.'/doc', 'GET')]
    public function send()
    {

        $this->setTemplateName("pages/doc/documentazione");
        $this->setTemplateChildren(array(Header::class, Menu::class, Footer::class));


        return $this->getTemplate('default');
    }


}

?>
