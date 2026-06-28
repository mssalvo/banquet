<?php

/**
 * Description of start
 *
 * @author Utente
 */
namespace Banquet\Actions;
use \Banquet\Core\SenderAction;

class Login extends SenderAction{

    private $model;
    private $email;
    private $password;
    
   
    public function __construct(\Banquet\Model\Login $model) {
        $this->model = $model;
    }

    public function send() {

        $this->setTemplateName("pages/login");
        $this->setTemplateChildren(array(\Banquet\Actions\Header\Header::class,\Banquet\Actions\Menu\Menu::class,\Banquet\Actions\Footer\Footer::class));


        $language=$this->load("message_". $this->getLangName().".php");
        $this->varAdd('lang', $language);



        if (isset($_POST['password']) && isset($_POST['email'])) {
 
            //.. fai qualcosa autentica!
          
            if($this->model->checkUser($_POST['email'], $_POST['password'])){
                
                //.. utente valido
            }
            
            $this->redirect('/home', 'refresh');     
            
 
        }else{

           //.. 

        }

        return $this->getTemplate("default");
    }
 

}

?>