<?php

/**
 * Description of start
 *
 * @author Utente
 */
namespace Banquet\Actions;

use Banquet\Ms\Core\Attribute\Route;
use Banquet\Ms\Core\SenderAction;
use Banquet\Ms\Core\Log;
use Banquet\Model\LoginModel; 

class Login extends SenderAction{

    private $model;
    private $email;
    private $password;
    
   
    public function __construct(LoginModel $model) {
        $this->model = $model;
    }
    #[Route(FOLDER_HOME.'/login', 'GET')]
    #[Route(FOLDER_HOME.'/login', 'POST')]
    public function send() {

        $this->setTemplateName("pages/login");
        $this->setTemplateChildren(array(\Banquet\Actions\Header\Header::class,\Banquet\Actions\Menu\Menu::class,\Banquet\Actions\Footer\Footer::class));

        

        $language=$this->loadLanguage();

        $this->varAdd('lang', $language);



        if (isset($_POST['password']) && isset($_POST['email'])) {
                
                $this->getValidSecurityPostCsrf();
            //.. fai qualcosa autentica!
          
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->model->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                Log::writeInfo("validazione con successo: userId:".$user["id"]." !");
                session_regenerate_id(true);
                
                $_SESSION['user_id'] = $user['id'];

                $this->redirect('/home', 'refresh');
            } else {
                $this->varAdd('error', 'Credenziali non valide');
            }
 
            
            //$this->redirect('/login', 'refresh');     
            
 
        }else{

           //.. 

        }

        return $this->getTemplate("default");
    }
 

}

?>