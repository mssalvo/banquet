<?php



/**
 * Description of footer
 *
 * @author Utente
 */

namespace Banquet\Actions\Footer;
use \Banquet\Core\SenderAction;

class Footer extends SenderAction
{

    public function send()
    {
        $this->setTemplateName("footer/footer");

        $language = $this->loadLanguage();
        
        $this->varAdd('lang', $language);

        return $this->getTemplate();

    }
}

?>
