<?php

namespace Banquet\Ms\Core;

use Banquet\Ms\Core\Factory;
use Banquet\Ms\Core\Log;
use Banquet\Ms\Core\Load;
use Banquet\Ms\Core\BaseAction;

abstract class SenderAction extends BaseAction {

    private $links = array();
    private $styles = array();
    private $scripts = array();
    public $data = array('dt'=> 'dt');
    private $template;
    private $children = NULL;
    public const TEMPLATE_DEFAULT = "default";
    abstract public function send();
    
    public function setTitle($title) {
        $this->data['title'] = $title;
    }

    public function setDescription($description) {
        $this->data['description'] = $description;
    }

    public function setKeywords($keywords) {
        $this->data['keywords'] = $keywords;
    }

    public function addLink($href, $rel) {
        $this->links[md5($href)] = array(
            'href' => $href,
            'rel' => $rel
        );
        $this->data['links'] = $this->links;
    }

    public function addStyle($href, $rel = 'stylesheet', $media = 'screen') {
        $this->styles[md5($href)] = array(
            'href' => $href,
            'rel' => $rel,
            'media' => $media
        );
        $this->data['styles'] = $this->styles;
    }

    public function getMd5($value) {
        return md5($value);
    }
    public function varAdd($key,$value) {
        $this->data[$key] = $value;
    }
    public function addScript($script) {
        $this->scripts[md5($script)] = $script;
        $this->data['scripts'] = $this->scripts;
    }

    public function route($key = null)
    {
        $params = $_REQUEST['_route_params'] ?? [];

        if ($key === null) {
            return $params;
        }

        return $params[$key] ?? null;
    }

    public function actionRoute()
    {
        $actionName = $_REQUEST['_action_route'] ?? '/';
        if (FOLDER_HOME!=='') {
        $actionName= str_replace(FOLDER_HOME, '', $actionName);
        }
        $action=explode('/', $actionName)[1];
        return $action;
    }

	public function security_click() {

    $tempo_limite = 15 * 60; // 15 minuti in secondi (900)

    if (!isset($_SESSION['_secutity_message']) || (time() - $_SESSION['_secutity_message']['_time']) > $tempo_limite) {
        $_SESSION['_secutity_message'] = [];
        $_SESSION['_secutity_message']['_count'] = 1;
        $_SESSION['_secutity_message']['_time'] = time();
    } else {
        $_SESSION['_secutity_message']['_count']++;
    }
    return $_SESSION['_secutity_message']['_count'];
    }
	
    public function getParameter($param) {
       if(isset($_REQUEST[$param])){
        return $_REQUEST[$param];   
       }
       
       return NULL;

    }
    
    public function getPost($param) {
        if(!isset($_POST[$param])) {
            return false;
        } else {
            return $_POST[$param];
        }
    }
    
    public function getGet($param) {
        if(!isset($_GET[$param])) {
            return false;
        } else {
            return $_GET[$param];
        }
    }
    public function getSession($param) {
        if(!isset($_SESSION[$param])) {
            return false;
        } else {
            return $_SESSION[$param];
        }
    }

        public function getValidSecurityPostCsrf() {
        
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                if (!isset($_POST['_csrf']) || $_POST['_csrf'] !== $_SESSION['_csrf']) {
                    //return false;
                    $this->redirect('/notauthorization', 'refresh');
                    exit;
                    //die("CSRF validation failed");
                }

                return true;
            } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
                return true;
            }

    }

    public function setSession($key,$value) {
            $_SESSION[$key]=$value;
    }

    public function unsetKeySession($key) {
        unset($_SESSION[$key]);
    }

    public function deleteAllKeySession() {
        session_unset();
        session_destroy();
    }

    public function getCookie($param) {
        if(!isset($_COOKIE[$param])) {
            return false;
        } else {
            return $_COOKIE[$param];
        }
    }
    public function setCookie($cookie_name,$cookie_value,$expire=0, $path='/', $domain=null, $secure=null, $httponly=null) {
        setcookie($cookie_name, $cookie_value, $expire?$expire:(time() + (86400 * 30)), $path,$domain,$secure,$httponly);
    }

    public function getRequestMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getResponse() {
        return Factory::getResponse();
    }
  
    public function setTemplateName($template) {
        $this->template = $template;
   
    }

    public function setTemplateChildren($arrayChildren) {
        $this->children = $arrayChildren;
    }

    public function getTemplate($master_template = NULL) {
        return Factory::getTemplate($this->data, $this->template, $this->children, $master_template);
    }
    
   public function getLangName() {
       if(!isset($_SESSION[KEY_LANG])){$_SESSION[KEY_LANG]=LANG_DEFAULT;}
       return $_SESSION[KEY_LANG];
    }
   
   public function setLangName($lang) {
       $_SESSION[KEY_LANG]=$lang;            
    }                      
    
    public function set($key, $value) {
        return Factory::set($key, $value);
    }

    public function get($key) {
        return Factory::get($key);
    }

    public function load($path) {
        return Load::getLoad($path);
    }
    
    public function loadLanguage() {
        return Load::getLoad("message_" . $this->getLangName() . ".php");
    }

    public function logInfo($value){
        Log::writeInfo($value);
    }

    public function logError($value){
        Log::writeError($value);
    }
  
    public function getDate() {

        return date('Y-m-d H:i:s');
    }

    public function getDateYmd() {

        return date('Y-m-d');
    }
    
    public function writeFile($path,$line){
       
        $file_=null;
        $file_=fopen($path, "a+");
        fwrite($file_, $line);
        fclose($file_);
    }

    public function mkf_File($filename) {
        if(!is_file($filename)) {
                fclose(fopen($filename,"x")); //create the file and close it
                return false;
        } else return true; //file already exists
    }
    
    public function generaID() {
        return str_replace(" ","",str_replace(".","",time()."".microtime()));  
    }
 
    public function redirect($uri = '', $method = 'auto', $code = NULL)
	{
                        
		// IIS environment likely? Use 'refresh' for better compatibility
		if ($method === 'auto' && isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== FALSE)
		{
			$method = 'refresh';
		}
		elseif ($method !== 'refresh' && (empty($code) OR ! is_numeric($code)))
		{
			if (isset($_SERVER['SERVER_PROTOCOL'], $_SERVER['REQUEST_METHOD']) && $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.1')
			{
				$code = ($_SERVER['REQUEST_METHOD'] !== 'GET')
					? 303	// reference: http://en.wikipedia.org/wiki/Post/Redirect/Get
					: 307;
			}
			else
			{
				$code = 302;
			}
		}

		switch ($method)
		{
			case 'refresh':
				header('Refresh:0;url='.$uri);
				break;
			default:
				header('Location: '.$uri, TRUE, $code);
				break;
		}
		exit;
	}

}

?>
