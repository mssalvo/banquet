<?php


/**
 * Description of start
 *
 * @author Utente
 */
namespace Banquet\Actions;
use Banquet\Core\SenderAction;

class Start extends SenderAction
{

    public function send()
    {

        $this->setTemplateName("pages/start");
        $this->setTemplateChildren(array(\Banquet\Actions\Header\Header::class,\Banquet\Actions\Menu\Menu::class,\Banquet\Actions\Footer\Footer::class));


        return $this->getTemplate('default');
    }


}

?>
