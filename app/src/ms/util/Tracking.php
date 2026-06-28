<?php

/**
 * Description of Languages
 *
 * @author Utente
 */
class Tracking {
    
    public $list_lg;
    public $line_lg="";
    public $line_cd="";
    public $path_language;
    public $path_code;
    public $user; 
    public $browser;
     
   function __construct($user) {
     $this->user=$user;  
     $this->path_language =DIR_UTENTE.$user."/tracking/language/";
     $this->path_code =DIR_UTENTE.$user."/tracking/code/";
     Factory::ensureDir($this->path_language);
     Factory::ensureDir($this->path_code);
     Factory::ensureDir(DIR_UTENTE.$user."/qr/");
     $this->browser= new Browser();
    }
    
    
    
    public function addLanguageVisit($lang,$idCode){
       $this->list_lg =file($this->path_language.$idCode.".dat");   
         foreach ($this->list_lg as $key => $val) {
            $line_ary=explode("=",$val);
            $language=$line_ary[0];
            $tot=$line_ary[1];
          if($language==$lang){
         
        $this->line_lg.=$language."=".(intval($tot)+1)."\n";
           
            }else{
          $this->line_lg.=$val;         
            }
            
       }
        $file_=fopen($this->path_language.$idCode.".dat", "w");
        fwrite($file_, $this->line_lg);
        fclose($file_);
    }
    
    
     public function addCodeVisit($idCode){
         $this->line_cd=""; 
         //DISPOSITIVO,ACCEPT_LANGUAGE,REFERRER,IP,BROWSER
         $this->line_cd=$this->browser->getPlatform()."|".$this->getLang()."|".$this->getReferer()."|".$this->getRealIpAddr()."|".$this->browser->getBrowser()."|".$this->getDate()."\n";
         $this->aggiorna_code($this->path_code.$idCode.".dat", $this->line_cd);
     }
    
     
    public function writeLanguage($idCode){
       if(!is_file($this->path_language.$idCode.".dat")) {
        $this->aggiorna_code($this->path_language.$idCode.".dat", $this->getLanguageFile());
     }
    }
    
    
    public function aggiorna_code($path,$line){
        $file_=null;
        $file_=fopen($path, "a+");
        fwrite($file_, $line);
        fclose($file_);
    }


    public function mkf_file($filename) {
        if(!is_file($filename)) {
                fclose(fopen($filename,"x")); //create the file and close it
                return false;
        } else return true; //file already exists
    }
        
    public function getDate() {
            $data=date('Y-m-d H:i:s');
            return $data;
    } 
    
    
      public function getRealIpAddr(){
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
          $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
          $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
          $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
        }
        
     public function getReferer(){
             
           $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : ''; 
           return $referer;
       }
       
       public function getLang(){
            $lang = isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])?substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2):'';  
            return $lang;
       }

   public function getLanguageFile(){

    $str="af=0";
    $str.="\n";
    $str.="sq=0";
    $str.="\n";
    $str.="ar-dz=0";
    $str.="\n";
    $str.="ar-bh=0";
    $str.="\n";
    $str.="ar-eg=0";
    $str.="\n";
    $str.="ar-iq=0";
    $str.="\n";
    $str.="ar-jo=0";
    $str.="\n";
    $str.="ar-kw=0";
    $str.="\n";
    $str.="ar-lb=0";
    $str.="\n";
    $str.="ar-ly=0";
    $str.="\n";
    $str.="ar-ma=0";
    $str.="\n";
    $str.="ar-om=0";
    $str.="\n";
    $str.="ar-qa=0";
    $str.="\n";
    $str.="ar-sa=0";
    $str.="\n";
    $str.="ar-sy=0";
    $str.="\n";
    $str.="ar-tn=0";
    $str.="\n";
    $str.="ar-ae=0";
    $str.="\n";
    $str.="ar-ye=0";
    $str.="\n";
    $str.="ar=0";
    $str.="\n";
    $str.="hy=0";
    $str.="\n";
    $str.="as=0";
    $str.="\n";
    $str.="az=0";
    $str.="\n";
    $str.="eu=0";
    $str.="\n";
    $str.="be=0";
    $str.="\n";
    $str.="bn=0";
    $str.="\n";
    $str.="bg=0";
    $str.="\n";
    $str.="ca=0";
    $str.="\n";
    $str.="zh-cn=0";
    $str.="\n";
    $str.="zh-hk=0";
    $str.="\n";
    $str.="zh-mo=0";
    $str.="\n";
    $str.="zh-sg=0";
    $str.="\n";
    $str.="zh-tw=0";
    $str.="\n";
    $str.="zh=0";
    $str.="\n";
    $str.="hr=0";
    $str.="\n";
    $str.="cs=0";
    $str.="\n";
    $str.="da=0";
    $str.="\n";
    $str.="div=0";
    $str.="\n";
    $str.="nl-be=0";
    $str.="\n";
    $str.="nl=0";
    $str.="\n";
    $str.="en-au=0";
    $str.="\n";
    $str.="en-bz=0";
    $str.="\n";
    $str.="en-ca=0";
    $str.="\n";
    $str.="en-ie=0";
    $str.="\n";
    $str.="en-jm=0";
    $str.="\n";
    $str.="en-nz=0";
    $str.="\n";
    $str.="en-ph=0";
    $str.="\n";
    $str.="en-za=0";
    $str.="\n";
    $str.="en-tt=0";
    $str.="\n";
    $str.="en-gb=0";
    $str.="\n";
    $str.="en-us=0";
    $str.="\n";
    $str.="en-zw=0";
    $str.="\n";
    $str.="en=0";
    $str.="\n";
    $str.="us=0";
    $str.="\n";
    $str.="et=0";
    $str.="\n";
    $str.="fo=0";
    $str.="\n";
    $str.="fa=0";
    $str.="\n";
    $str.="fi=0";
    $str.="\n";
    $str.="fr-be=0";
    $str.="\n";
    $str.="fr-ca=0";
    $str.="\n";
    $str.="fr-lu=0";
    $str.="\n";
    $str.="fr-mc=0";
    $str.="\n";
    $str.="fr-ch=0";
    $str.="\n";
    $str.="fr=0";
    $str.="\n";
    $str.="mk=0";
    $str.="\n";
    $str.="gd=0";
    $str.="\n";
    $str.="ka=0";
    $str.="\n";
    $str.="de-at=0";
    $str.="\n";
    $str.="de-li=0";
    $str.="\n";
    $str.="de-lu=0";
    $str.="\n";
    $str.="de-ch=0";
    $str.="\n";
    $str.="de=0";
    $str.="\n";
    $str.="el=0";
    $str.="\n";
    $str.="gu=0";
    $str.="\n";
    $str.="he=0";
    $str.="\n";
    $str.="hi=0";
    $str.="\n";
    $str.="hu=0";
    $str.="\n";
    $str.="is=0";
    $str.="\n";
    $str.="id=0";
    $str.="\n";
    $str.="it-ch=0";
    $str.="\n";
    $str.="it=0";
    $str.="\n";
    $str.="ja=0";
    $str.="\n";
    $str.="kn=0";
    $str.="\n";
    $str.="kk=0";
    $str.="\n";
    $str.="kok=0";
    $str.="\n";
    $str.="ko=0";
    $str.="\n";
    $str.="kz=0";
    $str.="\n";
    $str.="lv=0";
    $str.="\n";
    $str.="lt=0";
    $str.="\n";
    $str.="ms=0";
    $str.="\n";
    $str.="ml=0";
    $str.="\n";
    $str.="mt=0";
    $str.="\n";
    $str.="mr=0";
    $str.="\n";
    $str.="mn=0";
    $str.="\n";
    $str.="ne=0";
    $str.="\n";
    $str.="nb-no=0";
    $str.="\n";
    $str.="nn-no=0";
    $str.="\n";
    $str.="no=0";
    $str.="\n";
    $str.="or=0";
    $str.="\n";
    $str.="pl=0";
    $str.="\n";
    $str.="pt-br=0";
    $str.="\n";
    $str.="pt=0";
    $str.="\n";
    $str.="pa=0";
    $str.="\n";
    $str.="rm=0";
    $str.="\n";
    $str.="ro-md=0";
    $str.="\n";
    $str.="ro=0";
    $str.="\n";
    $str.="ru-md=0";
    $str.="\n";
    $str.="ru=0";
    $str.="\n";
    $str.="sa=0";
    $str.="\n";
    $str.="sr=0";
    $str.="\n";
    $str.="sk=0";
    $str.="\n";
    $str.="ls=0";
    $str.="\n";
    $str.="sb=0";
    $str.="\n";
    $str.="es-ar=0";
    $str.="\n";
    $str.="es-bo=0";
    $str.="\n";
    $str.="es-cl=0";
    $str.="\n";
    $str.="es-co=0";
    $str.="\n";
    $str.="es-cr=0";
    $str.="\n";
    $str.="es-do=0";
    $str.="\n";
    $str.="es-ec=0";
    $str.="\n";
    $str.="es-sv=0";
    $str.="\n";
    $str.="es-gt=0";
    $str.="\n";
    $str.="es-hn=0";
    $str.="\n";
    $str.="es-mx=0";
    $str.="\n";
    $str.="es-ni=0";
    $str.="\n";
    $str.="es-pa=0";
    $str.="\n";
    $str.="es-py=0";
    $str.="\n";
    $str.="es-pe=0";
    $str.="\n";
    $str.="es-pr=0";
    $str.="\n";
    $str.="es-us=0";
    $str.="\n";
    $str.="es-uy=0";
    $str.="\n";
    $str.="es-ve=0";
    $str.="\n";
    $str.="es=0";
    $str.="\n";
    $str.="sx=0";
    $str.="\n";
    $str.="sw=0";
    $str.="\n";
    $str.="sv-fi=0";
    $str.="\n";
    $str.="sv=0";
    $str.="\n";
    $str.="syr=0";
    $str.="\n";
    $str.="ta=0";
    $str.="\n";
    $str.="tt=0";
    $str.="\n";
    $str.="te=0";
    $str.="\n";
    $str.="th=0";
    $str.="\n";
    $str.="ts=0";
    $str.="\n";
    $str.="tn=0";
    $str.="\n";
    $str.="tr=0";
    $str.="\n";
    $str.="uk=0";
    $str.="\n";
    $str.="ur=0";
    $str.="\n";
    $str.="uz=0";
    $str.="\n";
    $str.="vi=0";
    $str.="\n";
    $str.="xh=0";
    $str.="\n";
    $str.="yi=0";
    $str.="\n";
    $str.="zu=0";

return $str;
    
    }
    
    
     public function getTrakingRegionsMap($idCode){
       $this->list_lg =file($this->path_language.$idCode.".dat");   
        
       $ary=array(); 
       foreach ($this->list_lg as $key => $val) {
            $line_ary=explode("=",$val);
            $language=$line_ary[0];
            $tot=$line_ary[1];
          if($tot>0){
              array_push($ary, array($language,$tot));
       
            } 
            
       }
       
    }
       public function getTrakingDrawChart($idCode){
       $list_chart =file($this->path_code.$idCode.".dat");   
         //DISPOSITIVO,ACCEPT_LANGUAGE,REFERRER,IP,BROWSER,DATA 
       $ary=array(); 
       foreach ($list_chart as $key => $val) {
            $line_ary=explode("|",$val);
            $language=$line_ary[0];
            $tot=$line_ary[1];
          if($tot>0){
              array_push($ary, array($language,$tot));
       
            } 
            
       }
       
    }
        
}

?>
